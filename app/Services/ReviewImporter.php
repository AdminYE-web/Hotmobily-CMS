<?php

namespace App\Services;

use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class ReviewImporter
{
    private const SHEETS_ENDPOINT =
        'https://sheets.googleapis.com/v4/spreadsheets';

    private const DRIVE_ENDPOINT =
        'https://www.googleapis.com/drive/v3/files';

    /**
     * Import only Google Sheet rows that have not been saved yet.
     *
     * This is the Laravel equivalent of original-web/get_data_review.php.
     * The sheet row number is stored as row_stamp, which makes subsequent
     * runs incremental and idempotent.
     */
    public function import(bool $dryRun = false, ?int $limit = null): array
    {
        $this->ensureConfiguration();

        if ($limit !== null && $limit < 1) {
            throw new RuntimeException('Review import limit must be greater than zero.');
        }

        $lastRow = Review::query()->max('row_stamp');
        $firstDataRow = max(
            2,
            (int) config('reviews.google.first_data_row', 2)
        );
        $startRow = $lastRow === null
            ? $firstDataRow
            : max($firstDataRow, (int) $lastRow + 1);

        $rows = $this->fetchSheetRows($startRow, $limit);

        $result = [
            'start_row' => $startRow,
            'available_rows' => count($rows),
            'imported' => 0,
            'skipped' => 0,
            'images_downloaded' => 0,
            'dry_run' => $dryRun,
        ];

        foreach ($rows as $offset => $columns) {
            $rowStamp = $startRow + (int) $offset;

            if (! is_array($columns)) {
                $result['skipped']++;

                continue;
            }

            if (! $this->hasContent($columns)) {
                $result['skipped']++;

                continue;
            }

            $imageNames = $dryRun
                ? []
                : $this->downloadImages(
                    $this->column($columns, 7),
                    $rowStamp
                );

            if (! $dryRun) {
                $result['images_downloaded'] += count($imageNames);

                Review::query()->updateOrCreate(
                    ['row_stamp' => $rowStamp],
                    $this->reviewAttributes($columns, $imageNames)
                );
            }

            $result['imported']++;
        }

        return $result;
    }

    /**
     * Validate the values needed to call the public Google APIs.
     */
    private function ensureConfiguration(): void
    {
        $missing = [];

        foreach ([
            'REVIEWS_GOOGLE_API_KEY' => config('reviews.google.api_key'),
            'REVIEWS_GOOGLE_SPREADSHEET_ID' => config('reviews.google.spreadsheet_id'),
        ] as $name => $value) {
            if (trim((string) $value) === '') {
                $missing[] = $name;
            }
        }

        if ($missing !== []) {
            throw new RuntimeException(
                'Missing review importer configuration: '.implode(', ', $missing)
            );
        }
    }

    /**
     * Read columns A:H from the next unimported row onward.
     */
    private function fetchSheetRows(int $startRow, ?int $limit = null): array
    {
        $spreadsheetId = rawurlencode(
            (string) config('reviews.google.spreadsheet_id')
        );
        $sheetName = (string) config(
            'reviews.google.sheet_name',
            'Form Responses 1'
        );
        $endRow = $limit === null ? '' : (string) ($startRow + $limit - 1);
        $range = $sheetName.'!A'.$startRow.':H'.$endRow;

        $response = Http::acceptJson()
            ->timeout((int) config('reviews.google.timeout', 30))
            ->get(
                self::SHEETS_ENDPOINT.'/'.$spreadsheetId.'/values/'.rawurlencode($range),
                ['key' => config('reviews.google.api_key')]
            );

        $this->throwForGoogleResponse($response, 'Google Sheets');

        $rows = $response->json('values', []);

        return is_array($rows) ? $rows : [];
    }

    /**
     * Map the legacy Google Form columns to the new table fields.
     */
    private function reviewAttributes(array $columns, array $imageNames): array
    {
        $sales = trim($this->column($columns, 4));

        return [
            'comment' => $this->column($columns, 1),
            'service' => $this->score($this->column($columns, 2)),
            'product' => $this->score($this->column($columns, 3)),
            'product_type' => $this->column($columns, 6),
            'images' => implode(',', $imageNames),
            'sale_name' => $sales !== ''
                ? $sales
                : (string) config(
                    'reviews.fallback_sale_name',
                    'その他・覚えていない'
                ),
            'date_reviews' => $this->reviewDate($this->column($columns, 0)),
        ];
    }

    /**
     * Download public Google Drive images and save them under public/reviews.
     */
    private function downloadImages(string $imageLinks, int $rowStamp): array
    {
        if (trim($imageLinks) === '') {
            return [];
        }

        $uploadDirectory = public_path(
            (string) config('reviews.upload_path', 'reviews/upload')
        );

        if (! is_dir($uploadDirectory) && ! mkdir($uploadDirectory, 0755, true) && ! is_dir($uploadDirectory)) {
            Log::warning('Unable to create review upload directory.', [
                'directory' => $uploadDirectory,
            ]);

            return [];
        }

        $storedNames = [];
        $links = preg_split('/\s*,\s*/', trim($imageLinks)) ?: [];

        foreach ($links as $imageIndex => $link) {
            $fileId = $this->driveFileId($link);

            if ($fileId === null) {
                continue;
            }

            try {
                $response = Http::timeout(
                    (int) config('reviews.google.timeout', 30)
                )->get(
                    self::DRIVE_ENDPOINT.'/'.rawurlencode($fileId),
                    [
                        'alt' => 'media',
                        'key' => config('reviews.google.api_key'),
                    ]
                );

                $this->throwForGoogleResponse($response, 'Google Drive');

                $extension = $this->extensionFromContentType(
                    (string) $response->header('Content-Type')
                );
                $filename = sprintf(
                    'image_%d_%s_%d.%s',
                    $rowStamp,
                    now()->format('YmdHis'),
                    (int) $imageIndex,
                    $extension
                );
                $filepath = $uploadDirectory.DIRECTORY_SEPARATOR.$filename;

                if (file_put_contents($filepath, $response->body(), LOCK_EX) === false) {
                    Log::warning('Unable to save an imported review image.', [
                        'row_stamp' => $rowStamp,
                        'file_id' => $fileId,
                    ]);

                    continue;
                }

                $storedNames[] = $filename;
            } catch (Throwable $exception) {
                // Keep the review import running when one Drive file is
                // missing, private, or no longer available.
                Log::warning('Unable to import a Google Drive review image.', [
                    'row_stamp' => $rowStamp,
                    'file_id' => $fileId,
                    'message' => $exception->getMessage(),
                ]);
            }
        }

        return $storedNames;
    }

    /**
     * Extract a Drive file ID from the URL formats used by Google Forms.
     */
    private function driveFileId(string $url): ?string
    {
        $url = trim($url);

        if ($url === '') {
            return null;
        }

        $parts = parse_url($url);

        if (is_array($parts) && isset($parts['query'])) {
            parse_str($parts['query'], $query);
            $queryId = (string) ($query['id'] ?? '');

            if (preg_match('/^[a-zA-Z0-9_-]+$/', $queryId) === 1) {
                return $queryId;
            }
        }

        if (preg_match(
            '~drive\.google\.com/file/d/([a-zA-Z0-9_-]+)~i',
            $url,
            $matches
        ) === 1) {
            return $matches[1];
        }

        if (preg_match(
            '~(?:^|[?&])id=([a-zA-Z0-9_-]+)~i',
            $url,
            $matches
        ) === 1) {
            return $matches[1];
        }

        return null;
    }

    private function extensionFromContentType(string $contentType): string
    {
        $contentType = strtolower(trim(explode(';', $contentType)[0]));

        return match ($contentType) {
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/svg+xml' => 'svg',
            'image/heic' => 'heic',
            'image/heif' => 'heif',
            'image/webp' => 'webp',
            default => 'jpg',
        };
    }

    private function throwForGoogleResponse(Response $response, string $service): void
    {
        if ($response->successful()) {
            return;
        }

        $message = $response->json('error.message')
            ?? $response->reason()
            ?? 'Unknown API error';

        throw new RuntimeException(
            $service.' request failed ('.$response->status().'): '.$message
        );
    }

    private function column(array $columns, int $index): string
    {
        $value = $columns[$index] ?? '';

        return is_scalar($value) ? (string) $value : '';
    }

    private function score(string $value): int
    {
        $value = trim($value);

        if (! is_numeric($value)) {
            return 0;
        }

        return max(0, min(5, (int) $value));
    }

    private function reviewDate(string $value): ?string
    {
        $value = trim($value);

        if ($value === '') {
            return null;
        }

        try {
            return Carbon::parse($value)->format('Y-m-d H:i:s');
        } catch (Throwable $exception) {
            Log::warning('Unable to parse a review date.', [
                'value' => $value,
                'message' => $exception->getMessage(),
            ]);

            return null;
        }
    }

    private function hasContent(array $columns): bool
    {
        foreach ($columns as $value) {
            if (is_scalar($value) && trim((string) $value) !== '') {
                return true;
            }
        }

        return false;
    }
}

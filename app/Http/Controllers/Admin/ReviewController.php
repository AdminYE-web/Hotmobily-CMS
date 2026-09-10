<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\ReviewAnswer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReviewController extends Controller
{
    public function index(Request $request): View|StreamedResponse
    {
        $filters = $this->filters($request);

        if ($request->boolean('export')) {
            return $this->export($filters);
        }

        $reviews = $this->filteredReviews($filters)
            ->when(ReviewAnswer::tableExists(), fn ($query) => $query->withCount('answers'))
            ->orderByDesc('date_reviews')
            ->orderByDesc('id')
            ->paginate(30)
            ->withQueryString();

        $saleNames = Review::query()
            ->whereNotNull('sale_name')
            ->where('sale_name', '!=', '')
            ->distinct()
            ->orderBy('sale_name')
            ->pluck('sale_name');

        return view('admin.reviews.index', compact('reviews', 'saleNames'));
    }

    /**
     * Support the legacy "YYYY-MM-DD / YYYY-MM-DD" filter, while keeping
     * the previous individual date fields usable for existing bookmarks.
     *
     * @return array{date_from: string|null, date_to: string|null, sale_name: string|null}
     */
    private function filters(Request $request): array
    {
        $filters = $request->validate([
            'daterange' => ['nullable', 'string', 'max:30'],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
            'sale_name' => ['nullable', 'string', 'max:65535'],
        ]);

        if (! filled($filters['daterange'] ?? null)) {
            return [
                'date_from' => $filters['date_from'] ?? null,
                'date_to' => $filters['date_to'] ?? null,
                'sale_name' => $filters['sale_name'] ?? null,
            ];
        }

        $dates = preg_split('/\s*\/\s*/', trim($filters['daterange']), 2);

        if ($dates === false || count($dates) !== 2) {
            throw ValidationException::withMessages([
                'daterange' => 'Please enter a start and end date.',
            ]);
        }

        $range = validator([
            'date_from' => $dates[0],
            'date_to' => $dates[1],
        ], [
            'date_from' => ['required', 'date'],
            'date_to' => ['required', 'date', 'after_or_equal:date_from'],
        ])->validate();

        return [
            'date_from' => $range['date_from'],
            'date_to' => $range['date_to'],
            'sale_name' => $filters['sale_name'] ?? null,
        ];
    }

    /** @param array{date_from: string|null, date_to: string|null, sale_name: string|null} $filters */
    private function filteredReviews(array $filters): Builder
    {
        return Review::query()
            ->when(
                filled($filters['date_from']),
                fn (Builder $query) => $query->whereDate('date_reviews', '>=', $filters['date_from'])
            )
            ->when(
                filled($filters['date_to']),
                fn (Builder $query) => $query->whereDate('date_reviews', '<=', $filters['date_to'])
            )
            ->when(
                filled($filters['sale_name']),
                fn (Builder $query) => $query->where('sale_name', $filters['sale_name'])
            );
    }

    /** @param array{date_from: string|null, date_to: string|null, sale_name: string|null} $filters */
    private function export(array $filters): StreamedResponse
    {
        $filename = 'reviews_data_'.now()->format('YmdHis').'.xlsx';
        $path = $this->createExcelExport($filters);

        return response()->streamDownload(function () use ($path): void {
            try {
                readfile($path);
            } finally {
                @unlink($path);
            }
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    /** @param array{date_from: string|null, date_to: string|null, sale_name: string|null} $filters */
    private function createExcelExport(array $filters): string
    {
        $path = tempnam(sys_get_temp_dir(), 'reviews-export-');

        if ($path === false) {
            throw new \RuntimeException('Unable to create the review export file.');
        }

        $zip = new \ZipArchive;

        if ($zip->open($path, \ZipArchive::OVERWRITE) !== true) {
            @unlink($path);
            throw new \RuntimeException('Unable to create the Excel export archive.');
        }

        $rows = [
            $this->excelRow(1, ['Date', 'Comment', 'Service', 'Product', 'Sale'], 1),
        ];
        $rowNumber = 2;

        foreach ($this->filteredReviews($filters)
            ->orderByDesc('date_reviews')
            ->orderByDesc('id')
            ->cursor() as $review) {
            $rows[] = $this->excelRow($rowNumber, [
                $review->date_reviews?->format('Y-m-d H:i:s') ?? '',
                (string) ($review->comment ?? ''),
                (string) ($review->service ?? ''),
                (string) ($review->product ?? ''),
                (string) ($review->sale_name ?? ''),
            ], 0);
            $rowNumber++;
        }

        $zip->addFromString('[Content_Types].xml', <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types"><Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/><Default Extension="xml" ContentType="application/xml"/><Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/><Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/><Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/></Types>
XML);

        $zip->addFromString('_rels/.rels', <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/></Relationships>
XML);

        $zip->addFromString('xl/workbook.xml', <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"><sheets><sheet name="Reviews" sheetId="1" r:id="rId1"/></sheets></workbook>
XML);

        $zip->addFromString('xl/_rels/workbook.xml.rels', <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/><Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/></Relationships>
XML);

        $zip->addFromString('xl/styles.xml', <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"><fonts count="2"><font><sz val="11"/><name val="Calibri"/></font><font><b/><color rgb="FFFFFFFF"/><sz val="11"/><name val="Calibri"/></font></fonts><fills count="3"><fill><patternFill patternType="none"/></fill><fill><patternFill patternType="gray125"/></fill><fill><patternFill patternType="solid"><fgColor rgb="FF5B9BD5"/><bgColor indexed="64"/></patternFill></fill></fills><borders count="1"><border><left/><right/><top/><bottom/><diagonal/></border></borders><cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs><cellXfs count="2"><xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/><xf numFmtId="0" fontId="1" fillId="2" borderId="0" xfId="0" applyFont="1" applyFill="1"><alignment horizontal="center"/></xf></cellXfs></styleSheet>
XML);

        $sheet = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            .'<cols><col min="1" max="1" width="22" customWidth="1"/><col min="2" max="2" width="72" customWidth="1"/><col min="3" max="4" width="12" customWidth="1"/><col min="5" max="5" width="24" customWidth="1"/></cols>'
            .'<sheetData>'.implode('', $rows).'</sheetData></worksheet>';
        $zip->addFromString('xl/worksheets/sheet1.xml', $sheet);
        $zip->close();

        return $path;
    }

    /** @param list<string> $values */
    private function excelRow(int $rowNumber, array $values, int $style): string
    {
        $cells = '';

        foreach ($values as $index => $value) {
            $column = chr(65 + $index);
            $escaped = htmlspecialchars($value, ENT_XML1 | ENT_QUOTES, 'UTF-8');
            $space = $value !== trim($value) ? ' xml:space="preserve"' : '';
            $cells .= sprintf(
                '<c r="%s%d" s="%d" t="inlineStr"><is><t%s>%s</t></is></c>',
                $column,
                $rowNumber,
                $style,
                $space,
                $escaped
            );
        }

        return sprintf('<row r="%d">%s</row>', $rowNumber, $cells);
    }

    public function create(): View
    {
        return view('admin.reviews.form', [
            'review' => new Review,
            'isEditing' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $review = Review::create($this->reviewData($request));

        return redirect()
            ->route('admin.reviews.index')
            ->with('status', "Review #{$review->id} was created.");
    }

    public function edit(Review $review): View
    {
        return view('admin.reviews.form', [
            'review' => $review,
            'isEditing' => true,
        ]);
    }

    public function update(Request $request, Review $review): RedirectResponse
    {
        $review->update($this->reviewData($request, $review));

        return redirect()
            ->route('admin.reviews.index')
            ->with('status', "Review #{$review->id} was updated.");
    }

    /**
     * Validate a review and keep uploaded images in the same public location
     * used by the existing review page: public/reviews/upload.
     *
     * @return array<string, mixed>
     */
    private function reviewData(Request $request, ?Review $review = null): array
    {
        $data = $request->validate([
            'comment' => ['nullable', 'string'],
            'date_reviews' => ['required', 'date'],
            'service' => ['nullable', 'integer', 'between:1,5'],
            'product' => ['nullable', 'integer', 'between:1,5'],
            'product_type' => ['nullable', 'string', 'max:100'],
            'sale_name' => ['nullable', 'string', 'max:65535'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:5120'],
        ]);

        $newImageNames = $this->storeImages($request);
        $oldImageNames = $review === null
            ? []
            : $this->imageNames((string) $review->images);

        unset($data['images']);

        return [
            ...$data,
            'images' => implode(',', [...$oldImageNames, ...$newImageNames]),
        ];
    }

    /** @return list<string> */
    private function storeImages(Request $request): array
    {
        $files = $request->file('images', []);

        if ($files === [] || $files === null) {
            return [];
        }

        $directory = public_path((string) config('reviews.upload_path', 'reviews/upload'));
        File::ensureDirectoryExists($directory);

        $names = [];

        foreach ($files as $file) {
            if ($file === null || ! $file->isValid()) {
                continue;
            }

            $name = Str::uuid()->toString().'.'.$file->extension();
            $file->move($directory, $name);
            $names[] = $name;
        }

        return $names;
    }

    /** @return list<string> */
    private function imageNames(string $images): array
    {
        return collect(explode(',', $images))
            ->map(static fn (string $name): string => basename(trim($name)))
            ->filter()
            ->values()
            ->all();
    }
}

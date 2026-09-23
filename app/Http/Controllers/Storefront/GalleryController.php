<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\AcrylicGallery;
use App\Models\GalleryPage;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function show(string $galleryPage): View
    {
        $page = GalleryPage::query()
            ->active()
            ->where('public_slug', $galleryPage)
            ->firstOrFail();

        $query = AcrylicGallery::query()
            ->where('type', $page->gallery_type)
            ->orderByDesc('id');

        // Every gallery page intentionally uses the same legacy-compatible
        // template as rubberstrap. The page settings and legacy type still
        // control its content, images, heading, and description.
        $galleries = $query->get();

        if ($page->public_slug === 'acrylic_key') {
            $galleries = $galleries
                ->concat($this->acrylicKeyArchive())
                ->values();
        }

        if ($page->public_slug === 'rubberkeyholder') {
            $galleries = $galleries
                ->concat($this->rubberKeyholderArchive())
                ->values();
        }

        if ($page->public_slug === 'rubbercoaster') {
            $galleries = $galleries
                ->concat($this->rubberCoasterArchive())
                ->values();
        }

        return view('gallery.rubber-keyholder', [
            'galleryPage' => $page,
            'galleries' => $galleries,
        ]);
    }

    /**
     * Load the historical acrylic keyholder rows appended by the original page.
     *
     * @return Collection<int, AcrylicGallery>
     */
    private function acrylicKeyArchive(): Collection
    {
        return $this->legacyGalleryArchive('acrylic_key_data.php', 'keyholder');
    }

    /**
     * Load the historical rows that the original PHP page appended after its
     * database rows. Keeping this source optional lets a DB-only deployment
     * continue to render if the legacy archive is not copied over yet.
     *
     * @return Collection<int, AcrylicGallery>
     */
    private function rubberKeyholderArchive(): Collection
    {
        return $this->legacyGalleryArchive('rubber_keyholder_data.php', 'rubber_keyholder');
    }

    /**
     * Load the historical rubber coaster rows appended by the original page.
     *
     * @return Collection<int, AcrylicGallery>
     */
    private function rubberCoasterArchive(): Collection
    {
        return $this->legacyGalleryArchive('rubber_coaster_data.php', 'rubber_coaster');
    }

    /**
     * Convert a legacy PHP archive into the same model shape as database rows.
     *
     * @return Collection<int, AcrylicGallery>
     */
    private function legacyGalleryArchive(string $filename, string $type): Collection
    {
        $archivePath = base_path('original-web/gallery/'.$filename);

        if (! is_file($archivePath)) {
            return collect();
        }

        $rows = require $archivePath;

        if (! is_array($rows)) {
            return collect();
        }

        return collect($rows)
            ->filter(static fn (mixed $row): bool => is_array($row))
            ->values()
            ->map(static function (array $row, int $index) use ($type): AcrylicGallery {
                $images = is_array($row['images'] ?? null) ? $row['images'] : [];
                $tags = is_array($row['tags'] ?? null) ? $row['tags'] : [];
                $details = is_array($row['details'] ?? null) ? $row['details'] : [];

                $archiveItem = new AcrylicGallery([
                    'arr_img' => implode(',', array_filter(array_map('strval', $images))),
                    'arr_txt1' => implode(',', array_filter(array_map('strval', $tags))),
                    'arr_txt2' => isset($details['お客様']) ? (string) $details['お客様'] : null,
                    'arr_txt3' => isset($details['製作年月']) ? (string) $details['製作年月'] : null,
                    'arr_txt4' => isset($details['一言コメント']) ? (string) $details['一言コメント'] : null,
                    'arr_web' => isset($details['Web']) ? (string) $details['Web'] : null,
                    'type' => $type,
                ]);

                // The model casts id to int, so use a stable numeric id for
                // archive-only rows while keeping their original order.
                $archiveItem->id = 900000000 + $index;

                return $archiveItem;
            });
    }
}

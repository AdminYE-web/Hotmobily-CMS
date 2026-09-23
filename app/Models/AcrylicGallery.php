<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\File;

class AcrylicGallery extends Model
{
    public const TYPE_KEYHOLDER = 'keyholder';

    protected $table = 'hm_acrylic_gallery';

    public $timestamps = false;

    protected $fillable = [
        'arr_img',
        'arr_txt1',
        'arr_txt2',
        'arr_txt3',
        'arr_txt4',
        'type',
        'arr_web',
        'created_by',
        'created_at',
        'manual_import',
    ];

    protected $casts = [
        'id' => 'integer',
        'manual_import' => 'boolean',
        'created_at' => 'datetime',
    ];

    public function logs(): HasMany
    {
        return $this->hasMany(AcrylicGalleryLog::class, 'gallery_id');
    }

    /**
     * The legacy table stores image names as a comma-separated string.
     * Keep the original order. Some imported rubber rows contain a complete
     * external URL, so those values must not be reduced to a basename.
     *
     * @return list<string>
     */
    public function imageNames(): array
    {
        return collect(explode(',', (string) $this->arr_img))
            ->map(static fn (string $name): string => trim($name))
            ->filter()
            ->values()
            ->all();
    }

    /**
     * Legacy keyholder rows commonly omit the .webp suffix in arr_img.
     * New uploads keep their real extension, while old rows continue to use
     * the same URL convention as the original admin page.
     */
    public function storedImageName(string $name, string $legacyExtension = 'webp'): string
    {
        if ($this->isExternalImage($name)) {
            return $name;
        }

        $name = basename($name);

        return pathinfo($name, PATHINFO_EXTENSION) === '' && $legacyExtension !== ''
            ? $name.'.'.$legacyExtension
            : $name;
    }

    public function imageUrl(
        string $name,
        string $directory = 'gallery/img-acrylic',
        string $legacyExtension = 'webp'
    ): string
    {
        if ($this->isExternalImage($name)) {
            return $name;
        }

        $name = basename($name);
        $resolvedName = $this->resolveLocalImageName($name, $directory, $legacyExtension);

        return asset(trim($directory, '/').'/'.rawurlencode($resolvedName));
    }

    public function safeWebsiteUrl(): ?string
    {
        $url = trim((string) $this->arr_web);

        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            return null;
        }

        return in_array(strtolower((string) parse_url($url, PHP_URL_SCHEME)), ['http', 'https'], true)
            ? $url
            : null;
    }

    private function isExternalImage(string $name): bool
    {
        return filter_var($name, FILTER_VALIDATE_URL) !== false
            || str_starts_with($name, '/');
    }

    private function resolveLocalImageName(
        string $name,
        string $directory,
        string $legacyExtension
    ): string {
        $directory = trim($directory, '/');
        $basePath = public_path($directory);
        $candidates = [$name];

        if (pathinfo($name, PATHINFO_EXTENSION) === '' && $legacyExtension !== '') {
            $candidates[] = $name.'.'.$legacyExtension;
        }

        foreach ($candidates as $candidate) {
            if (File::exists($basePath.'/'.$candidate)) {
                return $candidate;
            }
        }

        // Old upload handlers stored the basename in arr_img but retained
        // the original extension on disk. Resolve that convention when the
        // copied legacy media is available locally.
        if (pathinfo($name, PATHINFO_EXTENSION) === '') {
            $matches = glob($basePath.'/'.$name.'.*') ?: [];

            if ($matches !== []) {
                return basename($matches[0]);
            }
        }

        return $this->storedImageName($name, $legacyExtension);
    }
}

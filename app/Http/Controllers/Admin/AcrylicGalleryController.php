<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcrylicGallery;
use App\Models\AcrylicGalleryLog;
use App\Models\GalleryPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class AcrylicGalleryController extends Controller
{
    public function index(string $galleryPage): View
    {
        $page = $this->galleryPage($galleryPage);

        return view('admin.acrylic-gallery.index', [
            'galleryPage' => $page,
            'definition' => $page->legacyDefinition(),
            'galleries' => AcrylicGallery::query()
                ->where('type', $page->gallery_type)
                ->orderByDesc('id')
                ->paginate(75),
        ]);
    }

    public function create(string $galleryPage): View
    {
        $page = $this->galleryPage($galleryPage);

        return view('admin.acrylic-gallery.form', [
            'gallery' => new AcrylicGallery([
                'type' => $page->gallery_type,
            ]),
            'galleryPage' => $page,
            'definition' => $page->legacyDefinition(),
            'isEditing' => false,
        ]);
    }

    public function store(Request $request, string $galleryPage): RedirectResponse
    {
        $page = $this->galleryPage($galleryPage);
        $definition = $page->legacyDefinition();
        $data = $this->validatedText($request);
        $storedImages = [];

        try {
            $storedImages = $this->storeImages(
                $request->file('files', []),
                $definition['media_directory']
            );

            $gallery = DB::transaction(function () use ($data, $storedImages, $definition): AcrylicGallery {
                return AcrylicGallery::create([
                    ...$data,
                    'arr_img' => implode(',', $storedImages),
                    'type' => $definition['type'],
                    'created_by' => $this->adminName(),
                    'created_at' => now(),
                ]);
            });
        } catch (Throwable $exception) {
            $this->removeStoredImages($storedImages, $definition['media_directory']);

            throw $exception;
        }

        return redirect()
            ->route('admin.gallery-items.index', $page)
            ->with('status', "{$definition['label']} #{$gallery->id} was created.");
    }

    public function edit(string $galleryPage, AcrylicGallery $acrylicGallery): View
    {
        $page = $this->galleryPage($galleryPage);
        $definition = $page->legacyDefinition();
        $this->ensureGalleryType($acrylicGallery, $definition['type']);

        return view('admin.acrylic-gallery.form', [
            'gallery' => $acrylicGallery,
            'galleryPage' => $page,
            'definition' => $definition,
            'isEditing' => true,
        ]);
    }

    public function update(
        Request $request,
        string $galleryPage,
        AcrylicGallery $acrylicGallery
    ): RedirectResponse
    {
        $page = $this->galleryPage($galleryPage);
        $definition = $page->legacyDefinition();
        $this->ensureGalleryType($acrylicGallery, $definition['type']);

        $data = $this->validatedText($request);
        $storedImages = [];

        try {
            $storedImages = $this->storeImages(
                $request->file('files', []),
                $definition['media_directory']
            );

            // An empty file selection keeps the existing legacy image list.
            // When files are selected, replace the complete set with the new files.
            if ($storedImages !== []) {
                $data['arr_img'] = implode(',', $storedImages);
            }

            DB::transaction(function () use ($data, $acrylicGallery, $definition): void {
                $changes = $this->changesForLog($acrylicGallery, $data);

                $acrylicGallery->fill([
                    ...$data,
                    'type' => $definition['type'],
                ]);
                $acrylicGallery->save();

                $this->writeChangeLog($acrylicGallery, $changes, $definition['type']);
            });
        } catch (Throwable $exception) {
            // Do not leave newly uploaded files behind if the database update fails.
            $this->removeStoredImages($storedImages, $definition['media_directory']);

            throw $exception;
        }

        return redirect()
            ->route('admin.gallery-items.index', $page)
            ->with('status', "{$definition['label']} #{$acrylicGallery->id} was updated.");
    }

    public function destroy(string $galleryPage, AcrylicGallery $acrylicGallery): RedirectResponse
    {
        $page = $this->galleryPage($galleryPage);
        $definition = $page->legacyDefinition();
        $this->ensureGalleryType($acrylicGallery, $definition['type']);

        // Match the legacy page: deleting the row does not remove media files.
        $id = $acrylicGallery->id;
        $acrylicGallery->delete();

        return redirect()
            ->route('admin.gallery-items.index', $page)
            ->with('status', "{$definition['label']} #{$id} was deleted.");
    }

    /** @return array{arr_txt1: string|null, arr_txt2: string|null, arr_txt3: string|null, arr_txt4: string|null, arr_web: string|null} */
    private function validatedText(Request $request): array
    {
        $validated = $request->validate([
            'arr_txt1' => ['nullable', 'string', 'max:65535'],
            'arr_txt2' => ['nullable', 'string', 'max:65535'],
            'arr_txt3' => ['nullable', 'string', 'max:65535'],
            'arr_txt4' => ['nullable', 'string', 'max:65535'],
            'arr_web' => ['nullable', 'string', 'max:65535'],
            'files' => ['nullable', 'array', 'max:3'],
            'files.*' => ['file', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:10240'],
        ]);

        return [
            'arr_txt1' => $validated['arr_txt1'] ?? null,
            'arr_txt2' => $validated['arr_txt2'] ?? null,
            'arr_txt3' => $validated['arr_txt3'] ?? null,
            'arr_txt4' => $validated['arr_txt4'] ?? null,
            'arr_web' => $validated['arr_web'] ?? null,
        ];
    }

    /** @param array<int, UploadedFile>|null $files @return list<string> */
    private function storeImages(?array $files, string $mediaDirectory): array
    {
        if ($files === null || $files === []) {
            return [];
        }

        $directory = public_path($mediaDirectory);
        File::ensureDirectoryExists($directory);
        $names = [];

        foreach ($files as $file) {
            if (! $file instanceof UploadedFile || ! $file->isValid()) {
                continue;
            }

            $extension = strtolower($file->extension() ?: $file->getClientOriginalExtension() ?: 'jpg');
            $name = Str::uuid()->toString().'.'.$extension;
            $file->move($directory, $name);
            $names[] = $name;
        }

        return $names;
    }

    /** @param list<string> $names */
    private function removeStoredImages(array $names, string $mediaDirectory): void
    {
        foreach ($names as $name) {
            $path = public_path($mediaDirectory.'/'.basename($name));

            if (File::exists($path)) {
                File::delete($path);
            }
        }
    }

    private function galleryPage(string $slug): GalleryPage
    {
        return GalleryPage::query()->where('slug', $slug)->firstOrFail();
    }

    private function ensureGalleryType(AcrylicGallery $gallery, string $type): void
    {
        abort_unless($gallery->type === $type, 404);
    }

    private function adminName(): string
    {
        $admin = auth('admin')->user();

        return (string) ($admin?->user ?: $admin?->email ?: 'unknown');
    }

    /** @param array<string, mixed> $data @return array<string, array{old: mixed, new: mixed}> */
    private function changesForLog(AcrylicGallery $gallery, array $data): array
    {
        $changes = [];

        foreach (array_keys($data) as $field) {
            $old = $gallery->getRawOriginal($field);
            $new = $data[$field];

            if ((string) ($old ?? '') !== (string) ($new ?? '')) {
                $changes[$field] = [
                    'old' => $old,
                    'new' => $new,
                ];
            }
        }

        return $changes;
    }

    /** @param array<string, array{old: mixed, new: mixed}> $changes */
    private function writeChangeLog(AcrylicGallery $gallery, array $changes, string $type): void
    {
        if ($changes === []) {
            return;
        }

        $step = ((int) AcrylicGalleryLog::query()
            ->where('gallery_id', $gallery->id)
            ->max('step')) + 1;

        foreach ($changes as $field => $change) {
            AcrylicGalleryLog::create([
                'gallery_id' => $gallery->id,
                'product' => $type,
                'field' => $field,
                'old' => $change['old'],
                'new' => $change['new'],
                'created_by' => $this->adminName(),
                'created_at' => now(),
                'step' => $step,
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Support\RichTextSanitizer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        return view('admin.news.index', [
            'newsItems' => News::query()->orderBy('id')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.news.form', [
            'newsItem' => new News(),
            'isEditing' => false,
        ]);
    }

    public function store(Request $request, RichTextSanitizer $sanitizer): RedirectResponse
    {
        $data = $this->validatedData($request);
        $admin = $request->user('admin');

        News::query()->create([
            'title' => trim($data['title']),
            'description' => $sanitizer->sanitize($data['contents']),
            'published_at' => $data['published_at'] ?: null,
            'created_by' => (string) ($admin?->user ?? ''),
            'created_at' => now(),
            'status' => (int) $data['status'],
            'meta_title' => trim($data['meta_title']),
            'meta_description' => trim($data['meta_description']),
            'meta_keyword' => trim($data['meta_keyword']),
            'category' => $data['category'],
        ]);

        return redirect()
            ->route('admin.news.index')
            ->with('status', 'News created successfully.');
    }

    public function edit(News $news): View
    {
        return view('admin.news.form', [
            'newsItem' => $news,
            'isEditing' => true,
        ]);
    }

    public function update(Request $request, News $news, RichTextSanitizer $sanitizer): RedirectResponse
    {
        $data = $this->validatedData($request);

        $news->update([
            'title' => trim($data['title']),
            'description' => $sanitizer->sanitize($data['contents']),
            'published_at' => $data['published_at'] ?: null,
            'updated_at' => now(),
            'status' => (int) $data['status'],
            'meta_title' => trim($data['meta_title']),
            'meta_description' => trim($data['meta_description']),
            'meta_keyword' => trim($data['meta_keyword']),
            'category' => $data['category'],
        ]);

        return redirect()
            ->route('admin.news.index')
            ->with('status', 'News updated successfully.');
    }

    public function destroy(News $news): RedirectResponse
    {
        $news->delete();

        return redirect()
            ->route('admin.news.index')
            ->with('status', 'News deleted successfully.');
    }

    public function uploadImage(Request $request): JsonResponse
    {
        $data = $request->validate([
            'upload' => ['required', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:10240'],
        ]);

        $directory = public_path('uploads-news');
        File::ensureDirectoryExists($directory);

        $filename = Str::uuid().'.'.$data['upload']->extension();
        $data['upload']->move($directory, $filename);

        return response()->json([
            'url' => '/uploads-news/'.$filename,
        ]);
    }

    public function legacyEdit(Request $request): RedirectResponse
    {
        $id = $request->query('id');

        return $id
            ? redirect()->route('admin.news.edit', ['news' => $id])
            : redirect()->route('admin.news.create');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'contents' => ['nullable', 'string'],
            'published_at' => ['nullable', 'date'],
            'category' => ['required', 'in:top,acrylic'],
            'status' => ['required', 'integer', 'in:1,2'],
            'meta_title' => ['required', 'string', 'max:255'],
            'meta_description' => ['required', 'string', 'max:1000'],
            'meta_keyword' => ['required', 'string', 'max:1000'],
        ]);
    }
}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Support\RichTextSanitizer;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        return $this->listing();
    }

    public function acrylicIndex(): View
    {
        return $this->listing('acrylic');
    }

    private function listing(?string $category = null): View
    {
        $query = News::query()->where('status', 1);

        if ($category !== null) {
            $query->where('category', $category);
        }

        return view('news.index', [
            'category' => $category,
            'newsPage' => $query
                ->orderByDesc('published_at')
                ->orderByDesc('id')
                ->paginate(10)
                ->withQueryString(),
        ]);
    }

    public function show(News $news, RichTextSanitizer $sanitizer): View
    {
        abort_unless((int) $news->status === 1, 404);

        return $this->showNews($news, $sanitizer);
    }

    public function legacyShow(Request $request, RichTextSanitizer $sanitizer): View
    {
        $id = $request->query('id');
        abort_unless(is_scalar($id) && ctype_digit((string) $id), 404);

        $news = News::query()->findOrFail((int) $id);

        return $this->showNews($news, $sanitizer);
    }

    private function showNews(News $news, RichTextSanitizer $sanitizer): View
    {
        return view('news.show', [
            'newsItem' => $news,
            'contentHtml' => $sanitizer->sanitize($news->description),
        ]);
    }
}

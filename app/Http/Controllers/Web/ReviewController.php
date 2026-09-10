<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\ReviewAnswer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class ReviewController extends Controller
{
    /**
     * Return the HTML fragment used by the legacy AJAX endpoint.
     */
    public function feed(): View|Response
    {
        if (! $this->reviewTableExists()) {
            // Keep the old page usable until the new migration is run.
            return view('mocks.legacy-reviews');
        }

        return response()->view('reviews.feed', [
            'reviews' => $this->reviews(),
        ]);
    }

    /**
     * Display the full review page from the new review table.
     */
    public function index(): View
    {
        if (! $this->reviewTableExists()) {
            return view('mocks.legacy-reviews');
        }

        $hasAnswers = ReviewAnswer::tableExists();
        $query = Review::query()
            ->orderByDesc('date_reviews')
            ->orderByDesc('id');

        if ($hasAnswers) {
            $query->with('answers');
        }

        return view('reviews.index', [
            'reviewPage' => $query->paginate(100)->withQueryString(),
            'statistics' => $this->statistics(),
            'hasAnswers' => $hasAnswers,
        ]);
    }

    private function reviews(): array
    {
        return Review::query()
            ->orderByDesc('date_reviews')
            ->orderByDesc('id')
            ->limit((int) config('reviews.display_limit', 20))
            ->get()
            ->map(static fn (Review $review): array => $review->toDisplayArray())
            ->all();
    }

    private function reviewTableExists(): bool
    {
        return Review::tableExists();
    }

    /**
     * Build the same high-level rating summary shown by the legacy review page.
     *
     * @return array{total: int, service: array{average: float, distribution: array<int, int>}, product: array{average: float, distribution: array<int, int>}}
     */
    private function statistics(): array
    {
        return [
            'total' => Review::query()->count(),
            'service' => $this->ratingStatistics('service'),
            'product' => $this->ratingStatistics('product'),
        ];
    }

    /**
     * @return array{average: float, distribution: array<int, int>}
     */
    private function ratingStatistics(string $column): array
    {
        $counts = Review::query()
            ->whereBetween($column, [1, 5])
            ->select($column)
            ->selectRaw('COUNT(*) as total')
            ->groupBy($column)
            ->pluck('total', $column);

        $distribution = [];

        foreach (range(1, 5) as $score) {
            $distribution[$score] = (int) ($counts[$score] ?? 0);
        }

        return [
            'average' => (float) (Review::query()->avg($column) ?? 0),
            'distribution' => $distribution,
        ];
    }
}

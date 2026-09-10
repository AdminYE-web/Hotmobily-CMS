<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\ReviewAnswer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewAnswerController extends Controller
{
    public function index(): View
    {
        $answers = ReviewAnswer::query()
            ->with('review')
            ->orderByDesc('review_id')
            ->orderByDesc('id')
            ->paginate(30);

        return view('admin.review-answers.index', compact('answers'));
    }

    public function create(Review $review): View|RedirectResponse
    {
        if ($review->answers()->exists()) {
            return redirect()
                ->route('admin.review-answers.index')
                ->with('error', 'This review already has a reply. Please edit the existing reply.');
        }

        return view('admin.review-answers.form', [
            'review' => $review,
            'answer' => new ReviewAnswer,
            'isEditing' => false,
        ]);
    }

    public function store(Request $request, Review $review): RedirectResponse
    {
        if ($review->answers()->exists()) {
            return redirect()
                ->route('admin.review-answers.index')
                ->with('error', 'This review already has a reply.');
        }

        $answer = $review->answers()->create([
            ...$this->answerData($request),
            // The legacy system associates a reply with the review timestamp.
            'date_create' => $review->date_reviews ?? now(),
        ]);

        return redirect()
            ->route('admin.review-answers.index')
            ->with('status', "Reply #{$answer->id} was created.");
    }

    public function edit(ReviewAnswer $answer): View
    {
        $answer->load('review');

        return view('admin.review-answers.form', [
            'review' => $answer->review,
            'answer' => $answer,
            'isEditing' => true,
        ]);
    }

    public function update(Request $request, ReviewAnswer $answer): RedirectResponse
    {
        $answer->update($this->answerData($request));

        return redirect()
            ->route('admin.review-answers.index')
            ->with('status', "Reply #{$answer->id} was updated.");
    }

    /** @return array{ans_txt: string, ans_name: string|null} */
    private function answerData(Request $request): array
    {
        return $request->validate([
            'ans_txt' => ['required', 'string'],
            'ans_name' => ['nullable', 'string', 'max:65535'],
        ]);
    }
}

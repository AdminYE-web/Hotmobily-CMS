@extends('admin.layouts.app')

@section('title', '口コミ(返答)')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h3 mb-1">口コミ(返答)</h1>
                <p class="text-muted mb-0">Replies to customer reviews.</p>
            </div>
            <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary">口コミ(参照)</a>
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Reply list</strong>
                <span class="text-muted small">{{ $answers->total() }} reply/replies</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0 admin-answer-table">
                        <thead class="thead-light">
                            <tr>
                                <th>Review</th>
                                <th>Answer</th>
                                <th>Answer name</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($answers as $answer)
                                <tr>
                                    <td>
                                        @if ($answer->review)
                                            <a href="{{ route('admin.reviews.edit', $answer->review) }}">#{{ $answer->review_id }}</a>
                                        @else
                                            #{{ $answer->review_id }}
                                        @endif
                                    </td>
                                    <td class="answer-text">{!! nl2br(e($answer->ans_txt ?: '-')) !!}</td>
                                    <td>{{ $answer->ans_name ?: '-' }}</td>
                                    <td class="text-nowrap">{{ $answer->date_create?->format('Y-m-d H:i') ?? '-' }}</td>
                                    <td><a href="{{ route('admin.review-answers.edit', $answer) }}" class="btn btn-sm btn-outline-primary">Edit</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-4">No replies found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if ($answers->hasPages())
            <div class="mt-3">{{ $answers->links() }}</div>
        @endif
    </div>
@endsection

@push('styles')
    <style>.admin-answer-table .answer-text { min-width: 360px; white-space: normal; }</style>
@endpush

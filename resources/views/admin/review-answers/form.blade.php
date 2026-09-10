@extends('admin.layouts.app')

@section('title', $isEditing ? 'Edit reply' : 'Reply to review')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h3 mb-1">{{ $isEditing ? 'Edit reply' : 'Reply to review' }}</h1>
                <p class="text-muted mb-0">口コミ(返答)</p>
            </div>
            <a href="{{ route('admin.review-answers.index') }}" class="btn btn-outline-secondary">&larr; Back</a>
        </div>

        <div class="card shadow-sm mb-3">
            <div class="card-header"><strong>Customer review #{{ $review?->id }}</strong></div>
            <div class="card-body">
                <p class="mb-2">{!! nl2br(e($review?->comment ?: '-')) !!}</p>
                <div class="text-muted small">
                    Date: {{ $review?->date_reviews?->format('Y-m-d H:i') ?? '-' }}
                    &middot; Sales person: {{ $review?->sale_name ?: '-' }}
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ $isEditing ? route('admin.review-answers.update', $answer) : route('admin.review-answers.store', $review) }}">
                    @csrf
                    @if ($isEditing)
                        @method('PUT')
                    @endif

                    <div class="form-group">
                        <label for="ans_txt">Answer</label>
                        <textarea id="ans_txt" name="ans_txt" rows="6" required class="form-control @error('ans_txt') is-invalid @enderror">{{ old('ans_txt', $answer->ans_txt) }}</textarea>
                        @error('ans_txt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="ans_name">Answer name</label>
                        <input id="ans_name" type="text" name="ans_name" value="{{ old('ans_name', $answer->ans_name) }}" class="form-control @error('ans_name') is-invalid @enderror">
                        @error('ans_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary">{{ $isEditing ? 'Update' : 'Add' }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection

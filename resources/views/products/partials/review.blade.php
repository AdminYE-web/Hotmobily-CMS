@php
    $reviewBlock = is_array($reviewData[$blockId] ?? null)
        ? $reviewData[$blockId]
        : [];

    $reviewType = trim((string) ($reviewBlock['product_type'] ?? ''));
    $reviewItems = $reviewBlock['reviews'] ?? collect();

    if (! $reviewItems instanceof \Illuminate\Support\Collection) {
        $reviewItems = collect($reviewItems);
    }
@endphp

@if ($reviewType !== '' && $reviewItems->isNotEmpty())
    <div class="store-product-review-component">
        @foreach ($reviewItems as $review)
            @php
                $serviceScore = min(5, max(0, (int) ($review->service ?? 0)));
                $productScore = min(5, max(0, (int) ($review->product ?? 0)));
                $saleName = trim((string) ($review->sale_name ?? '')) ?: '-';
                $displayProductType = trim((string) ($review->product_type ?? '')) ?: $reviewType;
                $comment = trim((string) ($review->comment ?? ''));
                $imageNames = collect(explode(',', (string) ($review->images ?? '')))
                    ->map(static fn (string $name): string => basename(trim($name)))
                    ->filter()
                    ->values();
            @endphp

            <div class="reviews_area {{ $loop->last ? 'rev-last-item' : '' }}">
                <div class="user_icon rev-question" aria-hidden="true">
                    <img src="{{ asset('reviews/img/user_icon.png') }}" alt="">
                </div>

                <div class="reviews_box rev-answer">
                    @if ($comment !== '')
                        <p class="comment">{!! nl2br(e($comment)) !!}</p>
                    @endif

                    @if ($imageNames->isNotEmpty())
                        <div class="cust_img">
                            @foreach ($imageNames->take(3) as $imageIndex => $imageName)
                                <a href="{{ asset('reviews/upload/' . rawurlencode($imageName)) }}" target="_blank" rel="noopener">
                                    <img src="{{ asset('reviews/upload/' . rawurlencode($imageName)) }}" alt="お客様からの投稿画像" loading="lazy">
                                    @if ($imageIndex === 2 && $imageNames->count() > 3)
                                        <span class="more-images">+{{ $imageNames->count() - 2 }}</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    @endif

                    <hr>

                    <p class="star">
                        <span>
                            お客様対応:<span class="score">@for ($score = 1; $score <= 5; $score++){{ $score <= $serviceScore ? '★' : '☆' }}@endfor</span>
                        </span>
                        <span>
                            製品の満足度:<span class="score">@for ($score = 1; $score <= 5; $score++){{ $score <= $productScore ? '★' : '☆' }}@endfor</span>
                        </span>
                        <span>
                            営業担当：<span class="sale">{{ $saleName }}</span>
                        </span>
                        <span>
                            製品：<span class="product_type">{{ $displayProductType }}</span>
                        </span>
                    </p>

                    @if ($review->date_reviews)
                        <p class="date">{{ $review->date_reviews->format('Y年m月d日 H:i:s') }}</p>
                    @endif
                </div>
            </div>
        @endforeach

        <div class="store-product-review-link">
            <a href="{{ route('reviews.index') }}">レビュー一覧ページへ</a>
        </div>
    </div>
@endif

@foreach ($reviews ?? [] as $review)
    @php
        $serviceScore = min(5, max(0, (int) ($review['service'] ?? 0)));
        $productScore = min(5, max(0, (int) ($review['product'] ?? 0)));
        $saleName = $review['sale_name'] ?? $review['sale'] ?? '-';
        $productType = $review['product_type'] ?? $review['type'] ?? '-';
        $reviewDate = $review['date'] ?? $review['date_reviews'] ?? null;
    @endphp

    <div class="reviews_box">
        @if (!empty($review['comment']))
            <p class="comment">{{ $review['comment'] }}</p>
            <hr>
        @endif

        <p class="star">
            お客様対応:<span class="score">
                @for ($score = 1; $score <= 5; $score++)
                    {{ $score <= $serviceScore ? '★' : '☆' }}
                @endfor
            </span>
            製品の満足度:<span class="score">
                @for ($score = 1; $score <= 5; $score++)
                    {{ $score <= $productScore ? '★' : '☆' }}
                @endfor
            </span>
            &nbsp;&nbsp;営業担当： <span class="sale">{{ $saleName }}</span>
            &nbsp;&nbsp;製品： <span class="product_type">{{ $productType }}</span>
        </p>

        @if (!empty($reviewDate))
            <p class="date">{{ $reviewDate }}</p>
        @endif
    </div>
@endforeach

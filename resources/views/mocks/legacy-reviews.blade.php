@php
    $reviews = [
        ['comment' => '【モック】丁寧に対応していただき、仕上がりにも満足しています。', 'service' => 5, 'product' => 5, 'sale' => '担当者', 'type' => 'アクリルキーホルダー', 'date' => '2026年08月28日 10:30:00'],
        ['comment' => '【モック】希望した納期に合わせて相談できました。', 'service' => 5, 'product' => 4, 'sale' => '担当者', 'type' => 'ラバーストラップ', 'date' => '2026年08月20日 14:15:00'],
        ['comment' => '【モック】初めての注文でも分かりやすかったです。', 'service' => 4, 'product' => 5, 'sale' => '担当者', 'type' => 'オリジナルグッズ', 'date' => '2026年08月12日 09:45:00'],
    ];
@endphp

@foreach ($reviews as $review)
    <div class="reviews_box" data-mock="review">
        <p class="comment">{{ $review['comment'] }}</p>
        <hr>
        <p class="star">
            お客様対応:<span class="score">{{ str_repeat('★', $review['service']) }}{{ str_repeat('☆', 5 - $review['service']) }}</span>
            製品の満足度:<span class="score">{{ str_repeat('★', $review['product']) }}{{ str_repeat('☆', 5 - $review['product']) }}</span>
            &nbsp;&nbsp;営業担当：<span class="sale">{{ $review['sale'] }}</span>
            製品：<span class="product_type">{{ $review['type'] }}</span>
        </p>
        <p class="date">{{ $review['date'] }}</p>
    </div>
@endforeach

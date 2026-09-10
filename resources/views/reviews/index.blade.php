@extends('layouts.product')

@section('head')
    <meta charset="utf-8">
    <meta name="description" content="アンケートにご協力いただいたお客様の声をリアルタイムで公開しています。">
    <meta name="keywords" content="お客様の声,口コミ,評判,アンケート">
    <meta name="robots" content="index,follow">
    <title>口コミ・お客様の声をリアルタイムで公開 | HOTMOBILY</title>
    @include('partials.legacy-head-products')
    <link href="{{ asset('reviews/css/reviews.css') }}?v=4" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
@endsection

@section('content')
    @php
        $service = $statistics['service'];
        $product = $statistics['product'];
        $serviceChartScores = [
            $service['distribution'][5],
            $service['distribution'][4],
            $service['distribution'][3],
            $service['distribution'][2],
            $service['distribution'][1],
        ];
        $productChartScores = [
            $product['distribution'][5],
            $product['distribution'][4],
            $product['distribution'][3],
            $product['distribution'][2],
            $product['distribution'][1],
        ];
    @endphp

    <div class="reviews reviews-page">
        <h1 class="title">口コミ・お客様の声をリアルタイムで公開。2016年より集計。</h1>

        <img class="reviews-banner" src="{{ asset('reviews/img/reviews_bannerB2.jpg') }}" alt="リアルタイム更新中 お客様の声">

        <div class="reviews-intro">
            <p>HOTMOBILYオリジナルグッズでは、ネックストラップを購入頂いた全てのお客様にお願いし、ご注文製品の発送時に、電子メールにて、アンケートへのご協力をお願いしております。</p>
            <p>アンケートは３つです。</p>
            <p>
                ①HOTMOBILYオリジナルグッズの製品及びサービスに対する全体的なご感想（自由記入）<br>
                ②HOTMOBILYオリジナルグッズの営業担当のサービスに対する評価（最高点5、最低点1）<br>
                ③HOTMOBILYオリジナルグッズの製品に対する評価（最高点5、最低点1）
            </p>
            <p>HOTMOBILYオリジナルグッズの評判はどうなの？というお客様に是非ご覧いただきいたいです。</p>
        </div>

        <section class="container-rating" aria-label="レビュー評価の集計">
            <div class="inner">
                <article class="rating">
                    <div class="chart-box">
                        <h2>お客様対応</h2>
                        <span class="rating-num">{{ number_format($service['average'], 1) }}</span>
                        <div class="star-rating" aria-label="お客様対応 {{ number_format($service['average'], 1) }} 点">
                            <span class="rating-upper" style="width: {{ min(100, max(0, $service['average'] / 5 * 100)) }}%">★★★★★</span>
                            <span class="rating-lower">★★★★★</span>
                        </div>
                        <p class="rating-users"><i class="fa fa-user" aria-hidden="true"></i> {{ number_format($statistics['total']) }}</p>
                    </div>
                    <canvas id="serviceChart" class="review-chart" aria-label="お客様対応の評価分布"></canvas>
                </article>

                <div class="line" aria-hidden="true"></div>

                <article class="rating">
                    <div class="chart-box">
                        <h2>製品の満足度</h2>
                        <span class="rating-num">{{ number_format($product['average'], 1) }}</span>
                        <div class="star-rating" aria-label="製品の満足度 {{ number_format($product['average'], 1) }} 点">
                            <span class="rating-upper" style="width: {{ min(100, max(0, $product['average'] / 5 * 100)) }}%">★★★★★</span>
                            <span class="rating-lower">★★★★★</span>
                        </div>
                        <p class="rating-users"><i class="fa fa-user" aria-hidden="true"></i> {{ number_format($statistics['total']) }}</p>
                    </div>
                    <canvas id="productChart" class="review-chart" aria-label="製品の満足度の評価分布"></canvas>
                </article>
            </div>
        </section>

        @if ($reviewPage->hasPages())
            <nav class="review-pagination" aria-label="レビューのページ送り">
                @if ($reviewPage->onFirstPage())
                    <span class="is-disabled" aria-hidden="true">‹</span>
                @else
                    <a href="{{ $reviewPage->previousPageUrl() }}" rel="prev" aria-label="前のページ">‹</a>
                @endif

                @for ($page = 1; $page <= $reviewPage->lastPage(); $page++)
                    @if ($page === $reviewPage->currentPage())
                        <span class="active_l" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $reviewPage->url($page) }}">{{ $page }}</a>
                    @endif
                @endfor

                @if ($reviewPage->hasMorePages())
                    <a href="{{ $reviewPage->nextPageUrl() }}" rel="next" aria-label="次のページ">›</a>
                @else
                    <span class="is-disabled" aria-hidden="true">›</span>
                @endif
            </nav>
        @endif

        <section class="reviews_area" aria-label="お客様のレビュー一覧">
            @forelse ($reviewPage as $review)
                @php
                    $serviceScore = min(5, max(0, (int) $review->service));
                    $productScore = min(5, max(0, (int) $review->product));
                    $imageNames = collect(explode(',', (string) $review->images))
                        ->map(static fn (string $name): string => basename(trim($name)))
                        ->filter()
                        ->values();
                @endphp

                <article class="review-entry">
                    <div class="user_icon" aria-hidden="true">
                        <img src="{{ asset('reviews/img/user_icon.png') }}" alt="">
                    </div>
                    <div class="reviews_box">
                        @if (filled($review->comment))
                            <p class="comment">{!! nl2br(e($review->comment)) !!}</p>
                        @endif

                        @if ($imageNames->isNotEmpty())
                            <div class="cust_img">
                                @foreach ($imageNames->take(3) as $imageIndex => $imageName)
                                    <a href="{{ asset('reviews/upload/'.rawurlencode($imageName)) }}" target="_blank" rel="noopener" aria-label="レビュー画像を開く">
                                        <img src="{{ asset('reviews/upload/'.rawurlencode($imageName)) }}" alt="お客様からの投稿画像" loading="lazy">
                                        @if ($imageIndex === 2 && $imageNames->count() > 3)
                                            <span class="more-images">+{{ $imageNames->count() - 2 }}</span>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        <hr>
                        <p class="star">
                            <span>お客様対応: <span class="score">@for ($score = 1; $score <= 5; $score++){{ $score <= $serviceScore ? '★' : '☆' }}@endfor</span></span>
                            <span>製品の満足度: <span class="score">@for ($score = 1; $score <= 5; $score++){{ $score <= $productScore ? '★' : '☆' }}@endfor</span></span>
                            <span>営業担当: <span class="sale">{{ filled($review->sale_name) ? $review->sale_name : '-' }}</span></span>
                            <span>製品: <span class="product_type">{{ filled($review->product_type) ? $review->product_type : '-' }}</span></span>
                        </p>

                        @if ($review->date_reviews)
                            <p class="date">{{ $review->date_reviews->format('Y年m月d日 H:i:s') }}</p>
                        @endif
                    </div>
                </article>

                @if ($hasAnswers)
                    @foreach ($review->answers as $answer)
                        <article class="ansuser_box">
                            <div class="ansuser_icon" aria-hidden="true">
                                <img src="{{ asset('reviews/img/icon_user_ans.png') }}" alt="">
                            </div>
                            <div class="ans_box">
                                @if (filled($answer->ans_txt))
                                    <p class="comment">{!! nl2br(e($answer->ans_txt)) !!}</p>
                                @endif
                                <p class="star">担当: <span class="sale">{{ filled($answer->ans_name) ? $answer->ans_name : '-' }}</span></p>
                            </div>
                        </article>
                    @endforeach
                @endif
            @empty
                <p class="reviews-empty">現在表示できるレビューはありません。</p>
            @endforelse
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (!window.Chart || !window.ChartDataLabels) {
                return;
            }

            Chart.register(ChartDataLabels);

            var labels = ['★5', '★4', '★3', '★2', '★1'];
            var colors = ['#c5d509', '#78a757', '#599477', '#37809a', '#2b78a6'];

            function createReviewChart(elementId, scores) {
                var element = document.getElementById(elementId);

                if (!element) {
                    return;
                }

                new Chart(element, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: scores,
                            backgroundColor: colors,
                            hoverOffset: 1,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        animation: {
                            duration: 1200,
                            easing: 'easeOutQuart',
                        },
                        layout: {
                            padding: 15,
                        },
                        elements: {
                            arc: {
                                borderWidth: 2,
                                borderColor: 'white',
                            },
                        },
                        plugins: {
                            legend: {
                                display: false,
                            },
                            datalabels: {
                                display: function (context) {
                                    return context.dataset.data[context.dataIndex] > 0;
                                },
                                backgroundColor: function (context) {
                                    return context.dataset.backgroundColor[context.dataIndex];
                                },
                                borderColor: 'white',
                                borderRadius: 50,
                                borderWidth: 2,
                                color: 'white',
                                anchor: 'end',
                                align: 'center',
                                padding: 5,
                                formatter: function (value, context) {
                                    return context.chart.data.labels[context.dataIndex];
                                },
                                font: {
                                    size: 14,
                                },
                            },
                        },
                        cutout: '70%',
                        rotation: -80,
                    },
                });
            }

            createReviewChart('serviceChart', @json($serviceChartScores));
            createReviewChart('productChart', @json($productChartScores));
        });
    </script>
@endpush

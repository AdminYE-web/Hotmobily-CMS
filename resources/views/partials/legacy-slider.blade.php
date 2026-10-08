@if ($homeBanners->isNotEmpty())
    <style>
        .home-banner-slides { display: none; }
        .home-banner-slides img { vertical-align: middle; width: 100%; max-width: 770px; }
        .home-slideshow-container { max-width: 771px; position: relative; margin: auto; }
        .home-banner-prev, .home-banner-next {
            cursor: pointer; position: absolute; top: 50%; width: auto; padding: 16px; margin-top: -22px;
            color: #666; font-weight: 700; font-size: 18px; transition: .6s ease; border: 0;
            border-radius: 0 3px 3px 0; user-select: none; background: transparent;
        }
        .home-banner-next { right: 0; border-radius: 3px 0 0 3px; }
        .home-banner-prev:hover, .home-banner-next:hover { background-color: rgba(0, 0, 0, .5); color: #fff; }
        .home-banner-dots { padding: 5px 0; text-align: center; }
        .home-banner-dot {
            cursor: pointer; height: 15px; width: 15px; margin: 0 2px; padding: 0; border: 0;
            background-color: #bbb; border-radius: 50%; display: inline-block; transition: background-color .6s ease;
        }
        .home-banner-dot.active, .home-banner-dot:hover { background-color: #717171; }
        .home-banner-fade { animation: home-banner-fade 1.5s; }
        @keyframes home-banner-fade { from { opacity: .4; } to { opacity: 1; } }
        @media only screen and (max-width: 300px) {
            .home-banner-prev, .home-banner-next { font-size: 11px; }
        }
        @media (max-width: 980px) {
            .home-banner-prev, .home-banner-next { margin-top: -25px; background-color: rgba(0, 0, 0, .3); color: #fff; }
        }
    </style>

    <div class="home-slideshow-container" data-home-banner-slider>
        @foreach ($homeBanners as $banner)
            <div class="home-banner-slides home-banner-fade">
                @if ($banner->link_url)
                    <a href="{{ $banner->link_url }}">
                @endif
                <picture>
                    <source media="(max-width: 768px)" srcset="{{ $banner->mobile_image_url }}">
                    <img src="{{ $banner->desktop_image_url }}" alt="{{ $banner->alt_text }}" width="770" height="240">
                </picture>
                @if ($banner->link_url)
                    </a>
                @endif
            </div>
        @endforeach

        @if ($homeBanners->count() > 1)
            <button type="button" class="home-banner-prev" data-banner-prev aria-label="Previous banner">&#10094;</button>
            <button type="button" class="home-banner-next" data-banner-next aria-label="Next banner">&#10095;</button>
        @endif
    </div>

    @if ($homeBanners->count() > 1)
        <div class="home-banner-dots" data-home-banner-dots>
            @foreach ($homeBanners as $banner)
                <button type="button" class="home-banner-dot" data-banner-dot="{{ $loop->index }}" aria-label="Show banner {{ $loop->iteration }}"></button>
            @endforeach
        </div>
    @endif

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const slider = document.querySelector('[data-home-banner-slider]');
                if (!slider) return;
                const slides = Array.from(slider.querySelectorAll('.home-banner-slides'));
                const dots = Array.from(document.querySelectorAll('[data-home-banner-dots] [data-banner-dot]'));
                if (!slides.length) return;

                let activeIndex = 0;
                let timer;
                function showSlide(index) {
                    activeIndex = (index + slides.length) % slides.length;
                    slides.forEach(function (slide, i) { slide.style.display = i === activeIndex ? 'block' : 'none'; });
                    dots.forEach(function (dot, i) {
                        dot.classList.toggle('active', i === activeIndex);
                        dot.setAttribute('aria-current', i === activeIndex ? 'true' : 'false');
                    });
                }
                function restartTimer() {
                    window.clearInterval(timer);
                    if (slides.length > 1) timer = window.setInterval(function () { showSlide(activeIndex + 1); }, 10000);
                }

                slider.querySelector('[data-banner-prev]')?.addEventListener('click', function () { showSlide(activeIndex - 1); restartTimer(); });
                slider.querySelector('[data-banner-next]')?.addEventListener('click', function () { showSlide(activeIndex + 1); restartTimer(); });
                dots.forEach(function (dot) {
                    dot.addEventListener('click', function () { showSlide(Number(dot.dataset.bannerDot)); restartTimer(); });
                });
                showSlide(0);
                restartTimer();
            });
        </script>
    @endpush
@endif

@php
    $catalog = array_replace(\App\Support\ProductCatalogContent::defaults(), $content);
    $categoryIds = array_column($catalog['categories'], 'id');
    $activeCategory = in_array($catalog['default_category'], $categoryIds, true) ? $catalog['default_category'] : '';
    $catalogKey = 'pc-'.\Illuminate\Support\Str::random(12);
    $activeCategoryName = array_column($catalog['categories'], 'name', 'id')[$activeCategory] ?? '';
@endphp
<section class="product-catalog" data-product-catalog data-pc-default="{{ $activeCategory }}"
    style="--pc-columns: {{ (int) $catalog['columns'] }}; --pc-mobile-columns: {{ (int) $catalog['mobile_columns'] }};">
    @if($catalog['title'] !== '')<h3>{{ $catalog['title'] }}</h3>@endif
    @if($catalog['description'] !== '' || count($catalog['categories']))
        <div class="pc-controls">
            @if($catalog['description'] !== '')<div class="pc-intro">{!! (new \App\Support\RichTextSanitizer)->sanitize($catalog['description']) !!}</div>@endif
            @if(count($catalog['categories']))
                <div class="pc-filters" role="group" aria-label="{{ $catalog['title'] ?: 'Product categories' }}">
                    @foreach($catalog['categories'] as $category)
                        <button type="button" data-pc-filter="{{ $category['id'] }}" aria-pressed="{{ $activeCategory === $category['id'] ? 'true' : 'false' }}" aria-controls="{{ $catalogKey }}">{{ $category['name'] }}</button>
                    @endforeach
                </div>
                <div class="pc-reset-wrap" data-pc-reset-wrap @if($activeCategory === '') hidden @endif>
                    <span class="pc-active-label" aria-live="polite">現在絞り込み中：<strong data-pc-active-name>{{ $activeCategoryName }}</strong></span>
                    <button type="button" class="pc-reset" data-pc-reset aria-controls="{{ $catalogKey }}"><span aria-hidden="true">×</span> すべて表示</button>
                </div>
            @endif
        </div>
    @endif
    <div class="pc-grid" id="{{ $catalogKey }}">
        @foreach($catalog['items'] as $item)
            @php $visible = $activeCategory === '' || in_array($activeCategory, $item['category_ids'], true); @endphp
            <article class="pc-card" data-pc-categories="{{ json_encode($item['category_ids']) }}" @if(!$visible) hidden @endif>
                <a class="pc-image-link" href="{{ $safeUrl($item['url']) }}">
                    <img class="pc-photo" src="{{ $safeUrl($item['image_url']) }}" alt="{{ $item['alt'] ?: $item['title'] }}" width="320" height="320" loading="lazy">
                </a>
                <h4 class="pc-title"><a href="{{ $safeUrl($item['url']) }}">{{ $item['title'] }}</a></h4>
                @php $details = \App\Support\ProductCatalogContent::cardDetails($item); @endphp
                @if($details !== '')<div class="pc-details">{!! $details !!}</div>@endif
                @if($item['badge'] !== '')<mark class="pc-badge">{{ $item['badge'] }}</mark>@endif
            </article>
        @endforeach
    </div>
    <p class="pc-empty" data-pc-empty role="status" @if(count(array_filter($catalog['items'], fn ($item) => $activeCategory === '' || in_array($activeCategory, $item['category_ids'], true)))) hidden @endif>{{ $catalog['empty_label'] }}</p>
</section>

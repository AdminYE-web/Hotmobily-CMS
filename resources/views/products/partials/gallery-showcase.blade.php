@php
    $showcase = array_replace(\App\Support\GalleryShowcaseContent::defaults(), $settings['showcase'] ?? [], $content);
    $sourcePage = !empty($showcase['gallery_page_id']) ? \App\Models\GalleryPage::active()->find($showcase['gallery_page_id']) : null;
    $choices = $sourcePage ? collect(app(\App\Services\GalleryItems::class)->choices($sourcePage))->keyBy('key') : collect();
    $selected = collect($showcase['items'])->map(function ($selection) use ($choices) {
        $source = $choices->get($selection['key'] ?? '');
        return $source ? array_merge($source, ['title' => (string) ($selection['title'] ?? '')]) : null;
    })->filter()->values();
    $tags = collect($sourcePage ? app(\App\Services\GalleryItems::class)->tagOptions($sourcePage) : []);
    $showcaseId = 'gs-'.\Illuminate\Support\Str::random(12);
@endphp
<section class="gallery-showcase" data-gallery-showcase style="--gs-columns:{{ max(1, min(4, (int) $showcase['columns'])) }};--gs-mobile-columns:{{ max(1, min(2, (int) $showcase['mobile_columns'])) }}">
    @if($showcase['title'] !== '')<h3 class="gs-heading">{{ $showcase['title'] }}</h3>@endif
    @if($showcase['description'] !== '')<div class="gs-intro">{!! (new \App\Support\RichTextSanitizer)->sanitize($showcase['description']) !!}</div>@endif
    @if($showcase['show_tags'] && $tags->isNotEmpty())
        <div class="gs-tags" aria-label="タグで絞込み">
            <strong>タグで絞込み：</strong>
            @foreach($tags as $tag)<a href="{{ route('gallery.show', ['galleryPage' => $sourcePage->public_slug, 'tag' => $tag]) }}" data-gs-tag="{{ $tag }}">{{ $tag }}</a>@endforeach
        </div>
    @endif
    <div class="gs-grid">
        @foreach($selected as $item)
            @php
                $group = $showcaseId.'-'.$loop->index;
                $images = array_values(array_unique(array_merge([$item['image_url']], $item['images'])));
                $caption = trim(implode("\n", array_filter([$item['title'], $item['customer'], $item['date'], $item['comment']])));
            @endphp
            <article class="gs-card" data-gs-card data-tags="{{ json_encode($item['tags'], JSON_UNESCAPED_UNICODE) }}">
                @if($item['title'] !== '')<h4 class="gs-card-title">{{ $item['title'] }}</h4>@endif
                <a class="gs-photo-link" href="{{ $safeUrl($item['image_url']) }}" data-store-image-modal-trigger
                   data-image-modal-src="{{ $safeUrl($item['image_url']) }}" data-image-modal-alt="{{ $item['title'] }}"
                   data-image-modal-description="{{ $caption }}" data-image-modal-group="{{ $group }}">
                    <img src="{{ $safeUrl($item['image_url']) }}" alt="{{ $item['title'] }}" width="320" height="320" loading="lazy">
                    <span class="gs-zoom">{{ $showcase['zoom_label'] }}</span>
                </a>
                @foreach(array_slice($images, 1) as $image)
                    <a hidden href="{{ $safeUrl($image) }}" data-store-image-modal-trigger data-image-modal-src="{{ $safeUrl($image) }}"
                       data-image-modal-alt="{{ $item['title'] }}" data-image-modal-description="{{ $caption }}" data-image-modal-group="{{ $group }}"></a>
                @endforeach
            </article>
        @endforeach
    </div>
    @if($showcase['show_more'] && $sourcePage)
        <div class="gs-more"><a href="{{ route('gallery.show', $sourcePage->public_slug) }}"><span>{{ $showcase['more_label'] }}</span><svg class="gs-more-arrow" aria-hidden="true" focusable="false" viewBox="0 0 16 16"><circle cx="8" cy="8" r="8" fill="currentColor"/><path d="M4 8h7M8 4.5 11.5 8 8 11.5" fill="none" stroke="#fff" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></a></div>
    @endif
</section>

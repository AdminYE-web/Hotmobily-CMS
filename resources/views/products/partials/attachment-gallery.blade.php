@php
    $gallery = array_replace(\App\Support\AttachmentGalleryContent::defaults(), $content);
    $galleryMode = array_key_exists('display_mode', $content)
        ? $gallery['display_mode']
        : (!empty($gallery['collapsible']) ? 'height' : 'all');
    $galleryKey = 'ag-'.\Illuminate\Support\Str::random(12);
@endphp
<section class="attachment-gallery" data-attachment-gallery
    data-ag-mode="{{ $galleryMode }}"
    data-ag-visible-items="{{ (int) ($gallery['visible_items'] ?? 6) }}"
    data-ag-show-toggle="{{ ($gallery['show_all_button'] ?? true) ? '1' : '0' }}"
    data-ag-collapsible="{{ $gallery['collapsible'] ? '1' : '0' }}"
    data-ag-height="{{ (int) $gallery['collapsed_height'] }}"
    style="--ag-columns: {{ (int) $gallery['columns'] }}; --ag-mobile-columns: {{ (int) $gallery['mobile_columns'] }}; --ag-height: {{ (int) $gallery['collapsed_height'] }}px;">
    @if($gallery['title'] !== '')<h3>{{ $gallery['title'] }}</h3>@endif
    @if($gallery['description'] !== '')
        <div class="ag-intro">{!! (new \App\Support\RichTextSanitizer)->sanitize($gallery['description']) !!}</div>
    @endif
    @if(count($gallery['items']))
        <div class="ag-viewport" id="{{ $galleryKey }}" data-ag-viewport>
            <div class="ag-grid" data-ag-grid>
                @foreach($gallery['items'] as $item)
                    @php
                        $image = $safeUrl($item['image_url']);
                        $zoom = $safeUrl($item['zoom_url'] ?: $item['image_url']);
                        $alt = $item['alt'] ?: $item['title'];
                        $detail = implode("\n", array_filter([$item['title'], $item['description']], fn ($v) => $v !== ''));
                    @endphp
                    <figure class="ag-item" data-ag-item>
                        <a class="ag-image-link" href="{{ $zoom }}" data-store-image-modal-trigger
                            data-image-modal-src="{{ $zoom }}" data-image-modal-alt="{{ $alt }}"
                            data-image-modal-description="{{ $detail }}" data-image-modal-group="{{ $galleryKey }}"
                            aria-label="{{ $item['title'] ?: $alt ?: $gallery['zoom_label'] }}">
                            <img class="ag-photo" src="{{ $image }}" alt="{{ $alt }}" loading="lazy">
                            <span class="ag-image-placeholder" hidden>Image unavailable</span>
                        </a>
                        <figcaption>
                            <div class="ag-price">{{ \App\Support\AttachmentGalleryContent::formatPrice($item['price'] ?? null) }}</div>
                            @if($gallery['zoom_label'] !== '')<button type="button" class="ag-zoom" data-ag-zoom>{{ $gallery['zoom_label'] }}</button>@endif
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        </div>
        <div class="ag-toggle-wrap" data-ag-toggle-wrap hidden>
            <button type="button" class="ag-toggle" data-ag-toggle aria-expanded="false" aria-controls="{{ $galleryKey }}"
                data-ag-more="{{ $gallery['more_label'] }}" data-ag-less="{{ $gallery['less_label'] }}">{{ $gallery['more_label'] }}</button>
        </div>
    @endif
</section>

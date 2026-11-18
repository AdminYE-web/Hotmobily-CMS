@php
    $mainWidth = (int) ($settings['main_image_width'] ?? 65);
    $mainWidth = in_array($mainWidth, [50, 60, 65, 70, 75], true) ? $mainWidth : 65;
    $images = [];

    foreach (['main' => 'zoom', 'detail' => 'none'] as $slot => $defaultAction) {
        $url = $safeUrl($content[$slot.'_image_url'] ?? '');
        if ($url === '') {
            continue;
        }

        $action = $content[$slot.'_image_action'] ?? $defaultAction;
        $link = $action === 'link' ? $safeUrl($content[$slot.'_image_link'] ?? '') : '';
        $alt = trim((string) ($content[$slot.'_image_alt'] ?? ''));
        $label = trim((string) ($content[$slot.'_image_label'] ?? ''));
        $images[] = compact('url', 'link', 'alt', 'action', 'label');
    }
@endphp

@if($images)
    <div class="image-detail-pair image-detail-pair--with-labels{{ count($images) === 1 ? ' image-detail-pair--single' : '' }}"
        style="--image-detail-main: {{ $mainWidth }}fr; --image-detail-secondary: {{ 100 - $mainWidth }}fr;">
        @foreach($images as $image)
            @php
                $zoom = $image['action'] === 'zoom';
                $tag = $image['link'] !== '' ? 'a' : ($zoom ? 'button' : 'div');
            @endphp
            <figure class="image-detail-pair__figure">
                <{{ $tag }} class="image-detail-pair__panel{{ $zoom ? ' store-image-modal-trigger' : '' }}"
                    @if($tag === 'a')
                        href="{{ $image['link'] }}"
                        @if($image['alt'] === '') aria-label="Open image link" @endif
                    @elseif($zoom)
                        type="button" data-store-image-modal-trigger
                        data-image-modal-src="{{ $image['url'] }}"
                        data-image-modal-alt="{{ $image['alt'] }}"
                        data-image-modal-group="image-detail-pair-{{ $blockId }}"
                        aria-label="{{ $image['alt'] !== '' ? 'Enlarge '.$image['alt'] : 'Enlarge image' }}"
                    @endif
                >
                    <img src="{{ $image['url'] }}" alt="{{ $image['alt'] }}" loading="lazy">
                    @if($zoom)
                        <span class="image-detail-pair__hint">📷 クリックすると拡大します</span>
                    @endif
                </{{ $tag }}>
                @if($image['label'] !== '')
                    <figcaption class="image-detail-pair__label">{{ $image['label'] }}</figcaption>
                @endif
            </figure>
        @endforeach
    </div>
@endif

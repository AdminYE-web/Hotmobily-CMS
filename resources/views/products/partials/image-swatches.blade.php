@php
    $swatchWidth = max(48, min(240, (int) ($settings['swatch_width'] ?? 106)));
    $swatchGap = max(0, min(48, (int) ($settings['swatch_gap'] ?? 10)));
    $swatches = [];

    foreach (($content['swatches'] ?? []) as $swatch) {
        if (!is_array($swatch) || !is_string($swatch['image_url'] ?? null)) {
            continue;
        }

        $url = $safeUrl($swatch['image_url']);
        if ($url === '') {
            continue;
        }

        $label = trim((string) ($swatch['label'] ?? ''));
        $alt = trim((string) ($swatch['alt'] ?? ''));
        $swatches[] = compact('url', 'label', 'alt');
    }
@endphp

@if($swatches)
    <div class="image-swatches" style="--image-swatch-width: {{ $swatchWidth }}px; --image-swatch-gap: {{ $swatchGap }}px;">
        @foreach($swatches as $swatch)
            <figure class="image-swatches__item">
                <img class="image-swatches__image" src="{{ $swatch['url'] }}" alt="{{ $swatch['alt'] !== '' ? $swatch['alt'] : $swatch['label'] }}" loading="lazy">
                @if($swatch['label'] !== '')
                    <figcaption class="image-swatches__label">{{ $swatch['label'] }}</figcaption>
                @endif
            </figure>
        @endforeach
    </div>
@endif

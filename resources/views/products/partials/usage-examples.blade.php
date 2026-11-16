@php
    $examples = array_replace(\App\Support\UsageExamplesContent::defaults(), $content);
    $exampleGroup = 'ue-'.\Illuminate\Support\Str::random(12);
    $sanitizer = new \App\Support\RichTextSanitizer;
@endphp
<section class="usage-examples" style="--ue-columns: {{ (int) $examples['columns'] }}; --ue-mobile-columns: {{ (int) $examples['mobile_columns'] }};">
    @if($examples['title'] !== '')<h3>{{ $examples['title'] }}</h3>@endif
    @if($examples['description'] !== '')<div class="ue-intro ue-rich">{!! $sanitizer->sanitize($examples['description']) !!}</div>@endif
    @if(count($examples['items']))
        <div class="ue-grid">
            @foreach($examples['items'] as $item)
                @php
                    $image = $safeUrl($item['image_url']);
                    $zoom = $safeUrl(($item['zoom_url'] ?? '') ?: $item['image_url']);
                    $alt = ($item['alt'] ?? '') ?: ($item['title'] ?? '');
                @endphp
                <article class="ue-card">
                    <a class="ue-image-link" href="{{ $zoom }}" data-store-image-modal-trigger
                        data-image-modal-src="{{ $zoom }}" data-image-modal-alt="{{ $alt }}"
                        data-image-modal-description="{{ $item['title'] ?? '' }}" data-image-modal-group="{{ $exampleGroup }}"
                        aria-label="{{ $alt ?: $examples['zoom_label'] }}">
                        <img class="ue-photo" src="{{ $image }}" alt="{{ $alt }}" width="320" height="320" loading="lazy">
                        @if($examples['zoom_label'] !== '')<span class="ue-zoom">{{ $examples['zoom_label'] }}</span>@endif
                    </a>
                    @if(!empty($item['date']))
                        <time class="ue-date" datetime="{{ $item['date'] }}">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $item['date'])->format('Y年n月j日') }}</time>
                    @endif
                    @if(!empty($item['title']))<h4 class="ue-title">{{ $item['title'] }}</h4>@endif
                    @if(!empty($item['description']))<div class="ue-description ue-rich">{!! $sanitizer->sanitize($item['description']) !!}</div>@endif
                </article>
            @endforeach
        </div>
    @endif
</section>

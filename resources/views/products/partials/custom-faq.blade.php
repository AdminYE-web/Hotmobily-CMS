@php
    $customFaq = array_replace(\App\Support\CustomFaqContent::defaults(), $content);
    $customFaqIcons = \App\Support\CustomFaqContent::icons();
@endphp
<section class="custom-faq" style="--cf-columns: {{ (int) $customFaq['columns'] }}; --cf-mobile-columns: {{ (int) $customFaq['mobile_columns'] }};">
    @if($customFaq['title'] !== '')<h3>{{ $customFaq['title'] }}</h3>@endif
    @if($customFaq['description'] !== '')<div class="cf-description">{!! (new \App\Support\RichTextSanitizer)->sanitize($customFaq['description']) !!}</div>@endif
    @if(count($customFaq['items']))
        <div class="cf-grid">
            @foreach($customFaq['items'] as $item)
                <a class="cf-link" href="{{ $safeUrl($item['url']) }}" @if($item['new_tab'] ?? false) target="_blank" rel="noopener noreferrer" @endif>
                    <span class="cf-icon">{!! $customFaqIcons[\App\Support\CustomFaqContent::iconName($item)]['svg'] !!}</span>
                    <span>{{ $item['title'] }}</span>
                </a>
            @endforeach
        </div>
    @endif
</section>

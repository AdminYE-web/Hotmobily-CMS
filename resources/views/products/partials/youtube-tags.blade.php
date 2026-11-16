@php
    $youtubeTags = array_replace(\App\Support\YoutubeTagsContent::defaults(), array_intersect_key($content, \App\Support\YoutubeTagsContent::defaults()));
    $tagBackground = preg_match('/^#[0-9a-fA-F]{6}$/', (string) $youtubeTags['tag_background_color']) ? $youtubeTags['tag_background_color'] : '#58aede';
    $tagColor = preg_match('/^#[0-9a-fA-F]{6}$/', (string) $youtubeTags['tag_text_color']) ? $youtubeTags['tag_text_color'] : '#ffffff';
@endphp
@if($youtubeTags['tags_enabled'] && count($youtubeTags['tags']))
    <ul class="store-youtube-tags" aria-label="Video tags" style="--yt-tag-background:{{ $tagBackground }};--yt-tag-color:{{ $tagColor }}">
        @foreach($youtubeTags['tags'] as $tag)
            @if(trim((string) ($tag['label'] ?? '')) !== '')
                @php($tagUrl = $safeUrl($tag['url'] ?? ''))
                <li>@if($tagUrl !== '')<a class="store-youtube-tag" href="{{ $tagUrl }}">{{ $tag['label'] }}</a>@else<span class="store-youtube-tag">{{ $tag['label'] }}</span>@endif</li>
            @endif
        @endforeach
    </ul>
@endif

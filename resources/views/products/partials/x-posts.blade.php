@php
    $xPosts = array_replace(\App\Support\XPostsContent::defaults(), $content);
    $xSettings = \App\Support\XPostsContent::settings($settings ?? []);
@endphp
<section class="x-posts" data-x-posts data-xp-columns="{{ $xSettings['x_columns'] }}" data-xp-theme="{{ $xSettings['x_theme'] }}" data-xp-conversation="{{ $xSettings['x_conversation'] }}" style="--xp-columns: {{ $xSettings['x_columns'] }};">
    @if($xPosts['title'] !== '')<h3>{{ $xPosts['title'] }}</h3>@endif
    @if($xPosts['description'] !== '')<div class="xp-description">{!! (new \App\Support\RichTextSanitizer)->sanitize($xPosts['description']) !!}</div>@endif
    @if(count($xPosts['items']))
        <div class="xp-grid">
            @foreach($xPosts['items'] as $item)
                @php $xPost = \App\Support\XPostsContent::post($item['url'] ?? ''); @endphp
                @if($xPost)
                    <div class="xp-item" data-xp-id="{{ $xPost['post_id'] }}">
                        <div class="xp-embed" data-xp-embed hidden></div>
                        <a class="xp-fallback" data-xp-fallback href="{{ $xPost['url'] }}" target="_blank" rel="noopener noreferrer">{{ ($item['note'] ?? '') ?: 'Xで投稿を見る' }} <span aria-hidden="true">↗</span></a>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</section>

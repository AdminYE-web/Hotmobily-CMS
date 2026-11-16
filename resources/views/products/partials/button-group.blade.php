@php
    $buttonGroup = array_replace(\App\Support\ButtonGroupContent::defaults(), $content);
    $buttonIcons = \App\Support\ButtonGroupContent::icons();
@endphp
<div class="store-button-group" style="--bg-columns:{{ max(1,min(4,(int) $buttonGroup['columns'])) }};--bg-mobile-columns:{{ max(1,min(2,(int) $buttonGroup['mobile_columns'])) }};--bg-gap:{{ max(0,min(80,(int) $buttonGroup['gap'])) }}px;">
    @foreach($buttonGroup['items'] as $groupButton)
        @php
            $downloadButton = ($groupButton['link_mode'] ?? 'link') === 'download';
            $groupButtonUrl = $downloadButton ? \App\Support\TextLinkDownload::url($groupButton) : $safeUrl($groupButton['url'] ?? '');
            $buttonStyle = ($groupButton['style'] ?? '') === 'card' ? 'card' : 'solid';
            $appearance = \App\Support\ButtonGroupContent::appearance($buttonStyle);
            foreach (['background_color','text_color','icon_color','border_color'] as $property) {
                if (preg_match('/^#[0-9a-fA-F]{6}$/', (string) ($groupButton[$property] ?? ''))) $appearance[$property] = $groupButton[$property];
            }
            foreach (['border_radius'=>999,'font_size'=>48,'icon_size'=>120,'padding_x'=>80,'padding_y'=>80,'min_height'=>300] as $property=>$maximum) {
                $appearance[$property] = max(0,min($maximum,(int) ($groupButton[$property] ?? $appearance[$property])));
            }
            $buttonIcon = $buttonIcons[$groupButton['icon'] ?? 'none']['svg'] ?? '';
            $uploadedButtonIcon = ($groupButton['icon'] ?? '') === 'upload' ? $safeUrl($groupButton['icon_image_url'] ?? '') : '';
        @endphp
        @if($groupButtonUrl)
            <a class="store-group-button store-group-button--{{ $buttonStyle }}" href="{{ $groupButtonUrl }}"
               @if($downloadButton) download="{{ $groupButton['file_name'] ?? '' }}" @elseif(($groupButton['target'] ?? '_self') === '_blank') target="_blank" rel="noopener noreferrer" @endif
               style="--bg-background:{{ $appearance['background_color'] }};--bg-color:{{ $appearance['text_color'] }};--bg-icon-color:{{ $appearance['icon_color'] }};--bg-icon-size:{{ $appearance['icon_size'] }}px;--bg-border:{{ $appearance['border_color'] }};--bg-radius:{{ $appearance['border_radius'] }}px;--bg-font:{{ $appearance['font_size'] }}px;--bg-padding-x:{{ $appearance['padding_x'] }}px;--bg-padding-y:{{ $appearance['padding_y'] }}px;--bg-height:{{ $appearance['min_height'] }}px;--bg-shadow:{{ !empty($groupButton['shadow']) ? '0 3px 10px #0003' : 'none' }};">
                @if($uploadedButtonIcon !== '')<span class="bg-icon"><img src="{{ $uploadedButtonIcon }}" alt="" loading="lazy"></span>@elseif($buttonIcon !== '')<span class="bg-icon">{!! $buttonIcon !!}</span>@endif
                <span class="bg-label">{{ $groupButton['text'] ?? '' }}</span>
            </a>
        @endif
    @endforeach
</div>

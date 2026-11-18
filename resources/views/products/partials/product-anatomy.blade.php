@php
    $anatomy=array_replace(\App\Support\ProductAnatomyContent::defaults(),$content);
    $sanitizer=new \App\Support\RichTextSanitizer;
    $lineColor=preg_match('/^#[0-9a-fA-F]{6}$/',(string)$anatomy['line_color'])?$anatomy['line_color']:'#666666';
    $pointColor=preg_match('/^#[0-9a-fA-F]{6}$/',(string)$anatomy['point_color'])?$anatomy['point_color']:'#ff8000';
@endphp
@if($anatomy['left_image']!=='' || $anatomy['right_image']!=='' || count($anatomy['items']) || $anatomy['details_enabled'])
<section class="product-anatomy {{ $anatomy['pulse']?'pa-pulse':'' }}" style="--pa-image-width:{{ max(35,min(75,(int)$anatomy['image_width'])) }}%;--pa-line:{{ $lineColor }};--pa-point:{{ $pointColor }}">
    @if($anatomy['title']!=='')<h3 class="pa-title">{{ $anatomy['title'] }}</h3>@endif
    <div class="pa-main">
        @foreach(['left','right'] as $side)
            @php
                $callouts=collect($anatomy['items'])->filter(fn($item)=>($item['side']??'left')===$side);
                $image=$safeUrl($anatomy[$side.'_image']);
                $mobile=$safeUrl($anatomy[$side.'_mobile_image']);
            @endphp
            <div class="pa-side pa-side--{{ $side }}">
                <div class="pa-text" @if($side==='right') style="grid-column:2;grid-row:1" @endif>
                    @foreach($callouts as $item)
                        <div class="pa-callout" style="left:{{ max(-100,min(100,(float)($item['label_x']??0))) }}%;top:{{ max(0,min(100,(float)$item['label_y'])) }}%">
                            <h4>@if($safeUrl($item['url']??'')!=='')<a href="{{ $safeUrl($item['url']) }}">{{ $item['title'] }}</a>@else{{ $item['title'] }}@endif</h4>
                            <div class="pa-description">{!! $sanitizer->sanitize($item['description']??'') !!}</div>
                        </div>
                    @endforeach
                </div>
                <div class="pa-image" @if($side==='right') style="grid-column:1;grid-row:1" @endif>
                    @if($image!=='')<picture>@if($mobile!=='')<source media="(max-width:600px)" srcset="{{ $mobile }}">@endif<img src="{{ $image }}" alt="{{ $anatomy[$side.'_alt'] }}" loading="lazy"></picture>@else<div class="pa-placeholder" aria-hidden="true"></div>@endif
                    <svg class="pa-lines" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                        @foreach($callouts as $item)<line x1="{{ ($side==='left'?0:100)+max(-100,min(100,(float)($item['label_x']??0)))*(100-max(35,min(75,(int)$anatomy['image_width'])))/max(35,min(75,(int)$anatomy['image_width'])) }}" y1="{{ max(0,min(100,(float)$item['label_y'])) }}" x2="{{ max(0,min(100,(float)$item['x'])) }}" y2="{{ max(0,min(100,(float)$item['y'])) }}"/>@endforeach
                    </svg>
                    @foreach($callouts as $item)<span class="pa-point" aria-hidden="true" style="left:{{ max(0,min(100,(float)$item['x'])) }}%;top:{{ max(0,min(100,(float)$item['y'])) }}%"></span>@endforeach
                </div>
            </div>
        @endforeach
    </div>
    @if($anatomy['details_enabled'])
        <div class="pa-details">
            @if($anatomy['detail_left_image'])<img src="{{ $safeUrl($anatomy['detail_left_image']) }}" alt="" loading="lazy">@else<div aria-hidden="true"></div>@endif
            <div class="pa-detail-copy"><h4>{{ $anatomy['detail_title'] }}</h4><div class="pa-description">{!! $sanitizer->sanitize($anatomy['detail_description']) !!}</div></div>
            @if($anatomy['detail_right_image'])<img src="{{ $safeUrl($anatomy['detail_right_image']) }}" alt="" loading="lazy">@else<div aria-hidden="true"></div>@endif
        </div>
    @endif
</section>
@endif

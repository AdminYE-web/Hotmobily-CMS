@extends('layouts.product')

@php
    $galleryType = (string) $galleryPage->gallery_type;
    $isAcrylicKeyholder = $galleryPage->public_slug === 'acrylic_key' || $galleryType === 'keyholder';
    $isAcrylicHair = $galleryPage->public_slug === 'acrylic_hair' || $galleryType === 'acrylic_hair';
    $isAcrylicStandee = $galleryPage->public_slug === 'acrylic_standee' || $galleryType === 'standee';
    $isWappen = $galleryPage->public_slug === 'wappen' || $galleryType === 'wappen';
    $isAcrylicLegacy = $isAcrylicKeyholder || $isAcrylicHair || $isAcrylicStandee || $isWappen;
    $isKeyholder = $galleryPage->public_slug === 'rubberkeyholder' || $galleryType === 'rubber_keyholder';
    $isCoaster = $galleryPage->public_slug === 'rubbercoaster' || $galleryType === 'rubber_coaster';
    $isStrap = $galleryPage->public_slug === 'rubberstrap' || $galleryType === 'rubber_strap';
    $legacyTagOptions = $isAcrylicLegacy
        ? ['個人', '会社', '赤色', '青色', '黄色', '紫色', 'ピンク色', '緑色', '黒色', '1人', '複数人', '片面', '両面']
        : (($isKeyholder || $isCoaster)
            ? ['個人', '会社', '赤色', '青色', '黄色', '紫色', '緑色', '黒色', '白色', '1人', '複数人']
            : []);
    $availableTags = collect($galleries)
        ->flatMap(static function ($gallery): array {
            $rawTags = str_replace(['、', '，'], ',', (string) $gallery->arr_txt1);

            return array_values(array_filter(array_map('trim', explode(',', $rawTags))));
        })
        ->all();
    $tagOptions = $legacyTagOptions !== []
        ? $legacyTagOptions
        : collect($availableTags)
            ->map(static fn ($tag): string => trim((string) $tag))
            ->filter()
            ->unique()
            ->values()
            ->all();
    $hasTagFilter = (bool) ($galleryPage->show_tags ?? true) && $tagOptions !== [];
    $usesNewText = ! $isWappen;
    $storedHeading = trim((string) ($galleryPage->heading ?? ''));
    $genericProductName = trim((string) ($galleryPage->name ?? '')) ?: '製作事例紹介';
    $productSlug = $isAcrylicLegacy
        ? ($isWappen ? 'wappen' : 'acrylic')
        : ($isKeyholder ? 'rubberkeyholder' : ($isCoaster ? 'rubbercoaster' : ($isStrap ? 'rubberstrap' : (string) $galleryPage->public_slug)));
    $productName = $isAcrylicLegacy
        ? ($isWappen ? 'オリジナルワッペン' : 'アクリルキーホルダー')
        : ($isKeyholder ? 'ラバーキーホルダー' : ($isCoaster ? 'ラバーコースター' : ($isStrap ? 'ラバーストラップ' : $genericProductName)));
    $defaultHeading = $isAcrylicLegacy
        ? ($isWappen ? 'オリジナルワッペン製作事例。' : 'オリジナルアクリルキーホルダー、アクキーの製作事例集です。')
        : '製作事例紹介';
    $customHeading = $isAcrylicLegacy && in_array($storedHeading, ['', '製作事例紹介'], true)
        ? ''
        : $storedHeading;
    $publicHeading = $customHeading !== '' ? $customHeading : $defaultHeading;
    $legacyTitle = $isAcrylicLegacy
        ? ($isWappen ? 'ホットモバイリーのオリジナルワッペン制作事例！' : 'アクリルキーホルダー製作実績集 HOTMOBILYオリジナルグッズ')
        : ($isKeyholder
        ? 'ラバーキーホルダー製作実績集 HOTMOBILYオリジナルグッズ'
        : ($isCoaster ? 'コースター製作実績集 HOTMOBILYオリジナルグッズ' : 'オリジナルラバーストラップの製作事例の紹介'));
    $legacyKeywords = $isAcrylicLegacy
        ? ($isWappen ? 'ワッペン,オリジナルワッペン,制作事例' : 'アクリル,キーホルダー,事例,実績,見本')
        : ($isKeyholder
        ? 'ラバーキーホルダー,ノベルティキーホルダー,オリジナルキーホルダー,ラバー キーホルダー 同人,卒業記念キーホルダー,部活キーホルダー'
        : ($isCoaster
            ? 'ラバーコースター,コースター制作,コースター印刷,オリジナルコースター,コースターラバー,コースター作成'
            : 'ラバーストラップ,オリジナル,携帯ストラップ,ノベルティ,製作,作成'));
    $legacyMetaDescription = $isAcrylicLegacy
        ? ($isWappen
            ? 'ホットモバイリーのオリジナルワッペンの制作事例のページです。オモテ面・ウラ面の両方の写真を掲載しております。法人・個人の両方からご注文を受けております。オリジナルワッペン制作を検討なさっている方は参考にご活用ください。'
            : 'オリジナルアクリルキーホルダー、アクキーの製作事例集です。当店に実際にご注文頂いたお客様で、掲載許可を頂いた製品のみ掲載しております。')
        : ($isKeyholder
        ? 'オリジナルラバーキーホルダーの弊社製作実績紹介。全商品弊社にて製作。全製品完全オーダーメイド。ノベルティー、販促品として最適。半立体構造。ソフトPVC（軟質塩ビ）製。層構造を理解することで、ラバーキーホルダーの作り方が分かります。'
        : ($isCoaster
            ? 'オリジナルラバーコースターの弊社製作実績紹介。全商品弊社にて製作。全製品完全オーダーメイド。ノベルティー、販促品として最適。半立体構造。ソフトPVC（軟質塩ビ）製。層構造を理解することで、ラバーコースターの作り方が分かります。'
            : 'オリジナルラバーストラップの製作事例の紹介。過去にHOTMOBILYオリジナルグッズで製作させて頂いた製品のご紹介。全製品完全オーダーメイド。ノベルティー、販促品として最適。'));
    $publicTitle = $customHeading === ''
        ? $legacyTitle
        : $publicHeading.' - '.$productName.'製作実績集 HOTMOBILYオリジナルグッズ';
    $metaDescription = $galleryPage->description !== null
        ? strip_tags((string) $galleryPage->description)
        : $legacyMetaDescription;
    $legacyDescription = $isWappen
        ? ''
        : ($isAcrylicLegacy || $isKeyholder
        ? '本ページに掲載されている製品は、弊社製作実績の一部です。実際の製品は、お客様からお送り頂いたデザインでの、オリジナル製品となります。詳しくは商品紹介の各製品のページをご覧下さい。製作代金はこちらのページで簡単にご確認いただけます。ご注文方法はこちら。デザイン時のヒントはこちら。オレンジ色のタグボタンをクリックすると、そのタグに類似する製品のみが表示されます。'
        : '本ページに掲載されている製品は、弊社製作実績の一部です。実際の製品は、お客様からお送り頂いたデザインでの、オリジナル製品となります。詳しくは商品紹介の各製品のページをご覧下さい。製作代金はこちらのページで簡単にご確認いただけます。ご注文方法はこちら。デザイン時のヒントはこちら。オレンジ色のタグボタンをクリックすると、そのタグに類似する製品のみが表示されます。');
    $orderPath = $isAcrylicLegacy ? '/howtoorder/acrylic' : '/howtoorder/';
    $designPath = $isAcrylicLegacy ? '/products/data-acrylic' : '/howtodesign/';
    $publicDescription = $galleryPage->description !== null
        ? (string) $galleryPage->description
        : str_replace(
            ['こちらのページ', 'ご注文方法はこちら', 'デザイン時のヒントはこちら'],
            [
                '<a href="/products/'.$productSlug.'/#est-content">こちら</a>のページ',
                'ご注文方法は<a href="'.$orderPath.'">こちら</a>',
                'デザイン時のヒントは<a href="'.$designPath.'">こちら</a>',
            ],
            $legacyDescription
        );
@endphp

@section('head')
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index,follow">
    <meta name="keywords" content="{{ $legacyKeywords }}">
    <meta name="description" content="{{ $metaDescription }}">
    <title>{{ $publicTitle }}</title>

    <link rel="stylesheet" href="/products/css/lightbox.css">
    @include('partials.legacy-head-products')
    <link rel="stylesheet" href="/css/swiper.min.css">
    <link rel="stylesheet" href="/products/css/box-shadow.css?v=1.05">
    <link rel="stylesheet" href="/products/css/product_group.css?v=1.11">
    <link rel="stylesheet" href="/products/acrylic/css/renew_products.css?v=1.163">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/campaign/css/all.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="/products/acrylic/css/acrylic.css?v=1.03">
    <link rel="stylesheet" href="/products/acrylic/ptw/photoswipe.css">
    <link rel="stylesheet" href="/products/acrylic/ptw/default-skin.css">
    <link rel="stylesheet" href="/css/gallery-rubber-keyholder.css?v=1.02">
@endsection

@section('content')
    <div class="rubber-keyholder-gallery {{ $isAcrylicKeyholder ? 'acrylic-key-page' : ($isAcrylicHair ? 'acrylic-hair-page' : ($isAcrylicStandee ? 'acrylic-standee-page' : ($isWappen ? 'wappen-page' : ($isKeyholder ? 'rubber-keyholder-page' : ($isCoaster ? 'rubber-coaster-page' : 'rubber-strap-page'))))) }}" data-rubber-keyholder-gallery>
        <h1>{{ $publicHeading }}</h1>

        <div class="textGallery{{ $usesNewText ? ' new-text' : '' }}">
            {!! $publicDescription !!}
        </div>

        @if ($hasTagFilter)
            <div class="tag-menu" aria-label="制作事例をタグで絞り込む">
                <strong>タグで絞込み：</strong>
                @foreach ($tagOptions as $tag)
                    <a href="javascript:void(0)" class="tag-name" data-gallery-tag="{{ $tag }}">{{ $tag }}</a>
                @endforeach
            </div>
        @endif

        @include('gallery.partials.rubber-keyholder-pagination', ['position' => 'top'])

        <div class="flex-container gallery-items" data-gallery-items>
            @forelse ($galleries as $galleryIndex => $gallery)
                @php
                    $images = collect($gallery->imageNames())
                        ->map(fn (string $image): string => $gallery->imageUrl(
                            $image,
                            $galleryPage->media_directory,
                            (string) $galleryPage->legacy_extension
                        ))
                        ->values();
                    $tags = preg_split('/\s*[,、，]\s*/u', trim((string) $gallery->arr_txt1), -1, PREG_SPLIT_NO_EMPTY) ?: [];
                    $websiteUrl = $galleryPage->show_website ? $gallery->safeWebsiteUrl() : null;
                    $eagerLoad = $galleryIndex < 10;
                @endphp

                <div
                    class="flex-item item gallery-item"
                    data-gallery-item
                    data-tags="{{ implode(',', $tags) }}"
                >
                    @if ($images->isNotEmpty())
                        <div class="preview-container">
                            <div class="preview-top my-gallery" data-tag="{{ implode(',', $tags) }}">
                                @foreach ($images as $imageIndex => $imageUrl)
                                    @php($imageId = 'box-show-'.$galleryIndex.'-'.$imageIndex)
                                    <div
                                        class="rubber @if ($loop->first) is-active @endif"
                                        id="{{ $imageId }}"
                                        @if (! $loop->first) style="display: none;" @endif
                                    >
                                        <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                                            <a
                                                href="{{ $imageUrl }}"
                                                data-lightbox="lightbox-{{ $productSlug }}-{{ $galleryIndex }}"
                                                itemprop="contentUrl"
                                                data-size="600x600"
                                                data-gallery-main-link
                                            >
                                                @if ($eagerLoad)
                                                    <img
                                                        src="{{ $imageUrl }}"
                                                        data-zoom-image="{{ $imageUrl }}"
                                                        data-gallery-main-image
                                                        itemprop="thumbnail"
                                                        alt="{{ $productName }}製作事例 {{ $gallery->id }}"
                                                        loading="lazy"
                                                        decoding="async"
                                                    >
                                                @else
                                                    <img
                                                        class="lazy"
                                                        data-src="{{ $imageUrl }}"
                                                        data-zoom-image="{{ $imageUrl }}"
                                                        data-gallery-main-image
                                                        itemprop="thumbnail"
                                                        alt="{{ $productName }}製作事例 {{ $gallery->id }}"
                                                        loading="lazy"
                                                        decoding="async"
                                                    >
                                                @endif
                                            </a>
                                        </figure>
                                    </div>
                                @endforeach
                            </div>

                            <div class="preview-sub flex-container">
                                @foreach ($images as $imageIndex => $imageUrl)
                                    @php($imageId = 'box-show-'.$galleryIndex.'-'.$imageIndex)
                                    <div class="flex-item rubber">
                                        @if ($eagerLoad)
                                            <img
                                                src="{{ $imageUrl }}"
                                                id="{{ $imageId }}"
                                                data-gallery-thumbnail
                                                loading="lazy"
                                                decoding="async"
                                            >
                                        @else
                                            <img
                                                class="lazy"
                                                data-src="{{ $imageUrl }}"
                                                id="{{ $imageId }}"
                                                data-gallery-thumbnail
                                                loading="lazy"
                                                decoding="async"
                                            >
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="preview-container">
                            <div class="preview-top gallery-no-image">
                                <div class="gallery-empty">画像はまだ登録されていません。</div>
                            </div>
                        </div>
                    @endif

                    <table class="table_rubber">
                            <tbody>
                                <tr>
                                    <td colspan="2" class="td-tag">
                                        <div style="font-size: 12px;" class="camera-preview">📷大きな画像にマウスを合わせると拡大されます</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="td-tag tag-a">
                                        @if (($galleryPage->show_tags ?? true) && $tags !== [])
                                            @foreach ($tags as $tag)
                                                <a href="javascript:void(0)" class="tag-name" data-gallery-tag="{{ $tag }}">{{ $tag }}</a>
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                                @if ($isAcrylicLegacy || $isKeyholder || $isCoaster)
                                    @if ($gallery->arr_txt2)
                                        <tr>
                                            <td class="TableLeft">お客様</td>
                                            <td>{{ $gallery->arr_txt2 }}</td>
                                        </tr>
                                    @endif
                                    @if ($gallery->arr_txt3)
                                        <tr>
                                            <td class="TableLeft">製作年月</td>
                                            <td>{{ $gallery->arr_txt3 }}</td>
                                        </tr>
                                    @endif
                                    @if ($gallery->arr_txt4)
                                        <tr>
                                            <td class="TableLeft">一言コメント</td>
                                            <td class="gallery-comment" data-gallery-comment>{{ $gallery->arr_txt4 }}</td>
                                        </tr>
                                    @endif
                                    @if ($websiteUrl)
                                        <tr>
                                            <td class="TableLeft">Web</td>
                                            <td><a href="{{ $websiteUrl }}" target="_blank" rel="noopener nofollow">{{ $websiteUrl }}</a></td>
                                        </tr>
                                    @endif
                                @else
                                    <tr>
                                        <td class="TableLeft">お客様</td>
                                        <td>
                                            @if ($websiteUrl)
                                                <a href="{{ $websiteUrl }}" target="_blank" rel="noopener nofollow">{{ $gallery->arr_txt2 }}</a>
                                            @else
                                                {{ $gallery->arr_txt2 }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="TableLeft">製作年月</td>
                                        <td>{{ $gallery->arr_txt3 }}</td>
                                    </tr>
                                    <tr>
                                        <td class="TableLeft">一言コメント</td>
                                        <td class="gallery-comment" data-gallery-comment>{{ $gallery->arr_txt4 }}</td>
                                    </tr>
                                @endif
                            </tbody>
                    </table>
                </div>
            @empty
                <p class="gallery-empty" data-gallery-empty>制作事例はまだ登録されていません。</p>
            @endforelse
        </div>

        <p class="gallery-empty gallery-empty-filter" data-gallery-filter-empty hidden>該当する制作事例がありません。</p>

        @include('gallery.partials.rubber-keyholder-pagination', ['position' => 'bottom'])
        @if ($isStrap)
            <div class="gallery-product-link"><a href="/products/rubberstrap/">オリジナルラバーストラップ製品ページに戻る</a></div>
        @endif
        <div class="ptw-container"></div>
        <div class="gallery-clear"></div>
    </div>
@endsection

@push('scripts')
    <script src="/products/js/lightbox.js"></script>
    <script src="/js/swiper.min.js?v=1.00"></script>
    <script src="/js/common.js?v=1.02"></script>
    <script src="/products/acrylic/js/zoom-image.js"></script>
    <script src="/products/acrylic/ptw/photoswipe.min.js?v=1.08"></script>
    <script src="/products/acrylic/ptw/photoswipe-ui-default.min.js"></script>
    <script src="/js/gallery-rubber-keyholder.js?v=1.02"></script>
@endpush

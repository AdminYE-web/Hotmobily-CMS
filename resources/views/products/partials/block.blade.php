@php

    /*
    |--------------------------------------------------------------------------
    | Block Setup
    |--------------------------------------------------------------------------
    */

    $blockId =
        (string)
        (
            $block['id']
            ??
            ''
        );


    $type =
        (string)
        (
            $block['type']
            ??
            ''
        );


    $settings =
        is_array(
            $block['settings']
            ??
            null
        )
            ? $block['settings']
            : [];


    $content =
        is_array(
            $contents[
                $blockId
            ]
            ??
            null
        )
            ? $contents[
                $blockId
            ]
            : (
                is_array($block['content'] ?? null)
                    ? $block['content']
                    : []
            );


    /*
    |--------------------------------------------------------------------------
    | Block HTML ID
    |--------------------------------------------------------------------------
    */

    $customId =
        trim(
            (string)
            (
                $settings['custom_id']
                ??
                ''
            )
        );


    $effectiveId =
        $customId !== ''
            ? $customId
            : $blockId;


    $effectiveId =
        preg_replace(
            '/[^A-Za-z0-9\-_:.]/',
            '-',
            $effectiveId
        );


    /*
    |--------------------------------------------------------------------------
    | Width
    |--------------------------------------------------------------------------
    */

    $contentWidth =
        (int)
        (
            $settings['content_width']
            ??
            100
        );


    $contentWidth =
        max(
            1,
            min(
                100,
                $contentWidth
            )
        );


    /*
    |--------------------------------------------------------------------------
    | Alignment
    |--------------------------------------------------------------------------
    */

    $alignment =
        (string)
        (
            $settings['alignment']
            ??
            'left'
        );


    if (
        !in_array(
            $alignment,
            [
                'left',
                'center',
                'right',
            ],
            true
        )
    ) {

        $alignment =
            'left';

    }


    $justify =
        match (
            $alignment
        ) {

            'center' =>
                'center',

            'right' =>
                'flex-end',

            default =>
                'flex-start',

        };


    /*
    |--------------------------------------------------------------------------
    | Safe URL
    |--------------------------------------------------------------------------
    */

    $safeUrl =
        static function (
            mixed $value
        ): string {

            $url =
                trim(
                    (string)
                    $value
                );


            if (
                $url === ''
            ) {

                return '';

            }


            if (
                str_starts_with(
                    $url,
                    '/'
                )
                ||
                str_starts_with(
                    $url,
                    '#'
                )
                ||
                str_starts_with(
                    $url,
                    '//'
                )
            ) {

                return $url;

            }


            $scheme =
                strtolower(
                    (string)
                    parse_url(
                        $url,
                        PHP_URL_SCHEME
                    )
                );


            if (
                in_array(
                    $scheme,
                    [
                        'http',
                        'https',
                        'mailto',
                        'tel',
                    ],
                    true
                )
            ) {

                return $url;

            }


            return '';
        };

@endphp


<div
    id="{{ $effectiveId }}"
    class="
        store-product-block
        store-product-block-{{ $type }}
    "
>

    <div
        class="store-product-position"
        style="
            justify-content:
            {{ $justify }};
        "
    >

        <div
            class="store-product-inner"
            style="
                width:
                {{ $contentWidth }}%;

                text-align:
                {{ $alignment }};
            "
        >

            {{-- ============================================================
                Product Header
            ============================================================ --}}

            @if(
                $type
                ===
                'product_header'
            )

                @php

                    $title =
                        $content['title']
                        ??
                        $product->name;


                    $updatedDate =
                        $content['updated_date']
                        ??
                        '';


                    $showShare =
                        (bool)
                        (
                            $content['show_share']
                            ??
                            false
                        );

                @endphp


                <div class="store-product-header">

                    <h1 class="store-product-title h1-new">

                        {{ $title }}

                    </h1>


                    @if(
                        $showShare
                        ||
                        $updatedDate
                    )

                        <div class="store-product-meta social-sns">

                            @if(
                                $showShare
                            )

                                <p>シェアする</p>


                                <a
                                    href="https://x.com/GoodsYe"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    <img
                                        src="/products/images/rubberstrap/v2/x-icon.webp"
                                        alt="X"
                                        width="20"
                                        height="20"
                                    >
                                </a>


                                <a
                                    href="https://www.facebook.com/Hotmobily_jp-%E3%83%9B%E3%83%83%E3%83%88%E3%83%A2%E3%83%90%E3%82%A4%E3%83%AA%E3%83%BC-171871399585893"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    <img
                                        src="/products/images/rubberstrap/v2/Facebook-icon.webp"
                                        alt="Facebook"
                                        width="20"
                                        height="20"
                                    >
                                </a>


                                <a
                                    href="https://www.instagram.com/hot.mobily/?hl=ja"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    <img
                                        src="/products/images/rubberstrap/v2/IG_icon.webp"
                                        alt="Instagram"
                                        width="20"
                                        height="20"
                                    >
                                </a>

                            @endif


                            @if(
                                $updatedDate
                            )

                                <p>更新日：{{ $updatedDate }}</p>

                            @endif

                        </div>

                    @endif

                </div>


            {{-- ============================================================
                Product Gallery
            ============================================================ --}}

            @elseif(
                $type
                ===
                'product_gallery'
            )

                @php

                    $images =
                        is_array(
                            $content['images']
                            ??
                            null
                        )
                            ? array_values(
                                array_filter(
                                    $content['images']
                                )
                            )
                            : [];

                @endphp


                @if(
                    count(
                        $images
                    )
                )

                    <div
                        class="store-gallery product-gallery"
                        data-store-gallery
                    >

                        <div class="store-gallery-main main-image">

                            <img
                                src="{{ $safeUrl($images[0]) }}"
                                alt="{{ $product->name }}"
                                data-gallery-main
                            >

                        </div>


                        @if(
                            count(
                                $images
                            )
                            >
                            1
                        )

                            <div class="store-gallery-thumbnails thumbnails">

                                @foreach(
                                    $images
                                    as $index => $image
                                )

                                    <button
                                        type="button"
                                        class="
                                            store-gallery-thumb

                                            {{
                                                $index === 0
                                                    ? 'is-active'
                                                    : ''
                                            }}
                                        "
                                        data-gallery-thumb
                                        data-gallery-src="{{ $safeUrl($image) }}"
                                    >

                                        <img
                                            src="{{ $safeUrl($image) }}"
                                            alt="{{ $product->name }}"
                                            loading="lazy"
                                        >

                                    </button>

                                @endforeach

                            </div>

                        @endif


                        <div
                            class="store-gallery-modal"
                            data-gallery-modal
                        >

                            <span
                                class="store-gallery-modal-close"
                                data-gallery-modal-close
                            >
                                ×
                            </span>


                            <img
                                src=""
                                alt="{{ $product->name }}"
                                data-gallery-modal-image
                            >

                        </div>

                    </div>

                @endif


            {{-- ============================================================
                Product Details
            ============================================================ --}}

            @elseif(
                $type
                ===
                'product_details'
            )

                <div class="store-product-details product-details">

                    @if(
                        !empty(
                            $content[
                                'reference_price'
                            ]
                        )
                    )

                        <div class="store-price-box price-box">

                            <p>

                                <span class="store-price-label">

                                    参考単価：

                                </span>

                                {{
                                    $content[
                                        'reference_price'
                                    ]
                                }}

                            </p>

                        </div>

                    @endif


                    @if(
                        !empty(
                            $content[
                                'total_price'
                            ]
                        )
                    )

                        <div class="store-price-box price-box">

                            <p>

                                <span class="store-price-label">

                                    100個合計金額：

                                </span>

                                {{
                                    $content[
                                        'total_price'
                                    ]
                                }}

                            </p>

                        </div>

                    @endif


                    @if(
                        isset(
                            $content[
                                'shipping_days'
                            ]
                        )
                    )

                        <div class="store-price-box price-box">

                            <p>

                                <span class="store-price-label">

                                    出荷目安（通常納期）：

                                </span>


                                <span
                                    data-shipping-date-days="{{
                                        (int)
                                        $content[
                                            'shipping_days'
                                        ]
                                    }}"
                                >
                                    読み込み中...
                                </span>

                            </p>

                        </div>

                    @endif


                    @if(
                        !empty(
                            $content[
                                'shipping_note'
                            ]
                        )
                    )

                        <div class="store-product-note">

                            {!! nl2br(
                                e(
                                    $content[
                                        'shipping_note'
                                    ]
                                )
                            ) !!}

                        </div>

                    @endif


                    @if(
                        !empty(
                            $content[
                                'highlight_title'
                            ]
                        )
                    )

                        <h2 class="store-highlight-title promo-title">

                            {{
                                $content[
                                    'highlight_title'
                                ]
                            }}

                        </h2>

                    @endif

                </div>


            {{-- ============================================================
                Heading
            ============================================================ --}}

            @elseif(
                $type
                ===
                'heading'
            )

                @php

                    $headingTag =
                        $settings['tag']
                        ??
                        'h2';


                    if (
                        !in_array(
                            $headingTag,
                            [
                                'h1',
                                'h2',
                                'h3',
                                'h4',
                                'h5',
                                'h6',
                            ],
                            true
                        )
                    ) {

                        $headingTag =
                            'h2';

                    }

                @endphp


                <{{ $headingTag }}
                    class="store-heading"
                >

                    {{
                        $content['text']
                        ??
                        ''
                    }}

                </{{ $headingTag }}>


            {{-- ============================================================
                Rich Text
            ============================================================ --}}

            @elseif(
                $type
                ===
                'rich_text'
            )

                @php

                    $textSize =
                        (
                            $content['text_size']
                            ??
                            'normal'
                        )
                        ===
                        'small'
                            ? 'small'
                            : 'normal';


                    $textClass =
                        'store-rich-text new-text';


                    if (
                        $textSize === 'small'
                    ) {

                        $textClass .=
                            ' store-rich-text-small';

                    }

                @endphp

                <div class="{{ $textClass }}">

                    @if(
                        (
                            $content['content_format']
                            ?? 'plain'
                        )
                        === 'html'
                    )

                        {!!
                            $content['content']
                            ??
                            ''
                        !!}

                    @else

                        {!! nl2br(
                            e(
                                $content['content']
                                ??
                                ''
                            )
                        ) !!}

                    @endif

                </div>


            {{-- ============================================================
                Image
            ============================================================ --}}

            @elseif(
                $type
                ===
                'image'
            )

                @php

                    $imageUrl =
                        $safeUrl(
                            $content['url']
                            ??
                            ''
                        );

                @endphp


                @if(
                    $imageUrl
                )

                    <div class="store-image">

                        <img
                            src="{{ $imageUrl }}"
                            alt="{{
                                $content['alt']
                                ??
                                ''
                            }}"
                            loading="lazy"
                        >

                    </div>

                @endif


            {{-- ============================================================
                Button
            ============================================================ --}}

            @elseif(
                $type
                ===
                'button'
            )

                @php

                    $buttonUrl =
                        $safeUrl(
                            $content['url']
                            ??
                            ''
                        );

                @endphp


                @if(
                    $buttonUrl
                )

                    <a
                        href="{{ $buttonUrl }}"
                        class="store-button"
                    >

                        <svg
                            class="store-button-icon"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1.003 1.003 0 0 0 20 4H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z" />
                        </svg>

                        {{
                            $content['text']
                            ??
                            'Button'
                        }}

                    </a>

                @endif


            {{-- ============================================================
                Text Link
            ============================================================ --}}

            @elseif(
                $type
                ===
                'text_link'
            )

                @php

                    $linkUrl =
                        $safeUrl(
                            $content['url']
                            ??
                            ''
                        );


                    $newTab =
                        (bool)
                        (
                            $content['new_tab']
                            ??
                            false
                        );


                    $textColor =
                        strtolower(
                            trim(
                                (string)
                                (
                                    $content['text_color']
                                    ??
                                    ''
                                )
                            )
                        );


                    if (
                        !preg_match(
                            '/^#[0-9a-f]{6}$/',
                            $textColor
                        )
                    ) {

                        $textColor = '#111111';

                    }

                @endphp


                @if(
                    $linkUrl
                )

                    <a
                        href="{{ $linkUrl }}"
                        class="store-text-link"
                        style="color: {{ $textColor }} !important;"

                        @if(
                            $newTab
                        )
                            target="_blank"
                            rel="noopener noreferrer"
                        @endif
                    >

                        {{
                            $content['text']
                            ??
                            ''
                        }}

                    </a>

                @endif


            {{-- ============================================================
                Info Card
            ============================================================ --}}

            @elseif(
                $type
                ===
                'info_card'
            )

                @php

                    $infoImage =
                        $safeUrl(
                            $content[
                                'image_url'
                            ]
                            ??
                            ''
                        );


                    $infoLink =
                        $safeUrl(
                            $content[
                                'link_url'
                            ]
                            ??
                            ''
                        );

                @endphp


                <div class="store-info-card info-card">

                    @if(
                        !empty(
                            $content['title']
                        )
                    )

                        <h3 class="store-info-card-title">

                            {{
                                $content['title']
                            }}

                        </h3>

                    @endif


                    @if(
                        $infoImage
                    )

                        @if(
                            $infoLink
                        )

                            <a
                                href="{{ $infoLink }}"
                                class="store-info-card-image"
                            >

                                <img
                                    src="{{ $infoImage }}"
                                    alt="{{
                                        $content['title']
                                        ??
                                        ''
                                    }}"
                                    loading="lazy"
                                >

                            </a>

                        @else

                            <div class="store-info-card-image">

                                <img
                                    src="{{ $infoImage }}"
                                    alt="{{
                                        $content['title']
                                        ??
                                        ''
                                    }}"
                                    loading="lazy"
                                >

                            </div>

                        @endif

                    @endif


                    @if(
                        !empty(
                            $content[
                                'description'
                            ]
                        )
                    )

                        <div class="store-info-card-description">

                            {!! nl2br(
                                e(
                                    $content[
                                        'description'
                                    ]
                                )
                            ) !!}

                        </div>

                    @endif


                    @if(
                        $infoLink
                        &&
                        !empty(
                            $content[
                                'link_text'
                            ]
                        )
                    )

                        <div class="store-info-card-link">

                            <a href="{{ $infoLink }}">

                                {{
                                    $content[
                                        'link_text'
                                    ]
                                }}

                            </a>

                        </div>

                    @endif

                </div>


            {{-- ============================================================
                Accordion
            ============================================================ --}}

            @elseif(
                $type
                ===
                'accordion'
            )

                @php

                    $accordionToggleId =
                        'store-accordion-toggle-'
                        .
                        (
                            $effectiveId !== ''
                                ? $effectiveId
                                : md5(
                                    json_encode(
                                        $block
                                    )
                                )
                        );

                @endphp


                <div class="store-accordion">

                    <input
                        id="{{ $accordionToggleId }}"
                        class="store-accordion-input"
                        type="checkbox"
                        checked
                    >


                    <label
                        class="store-accordion-summary"
                        for="{{ $accordionToggleId }}"
                    >

                        <span>

                            {{
                                $content['title']
                                ??
                                $settings['title']
                                ??
                                'Accordion'
                            }}

                        </span>


                        <span class="store-accordion-arrow"></span>

                    </label>


                    <div class="store-accordion-content">

                        @foreach(
                            $block['children'] ?? []
                            as $child
                        )

                            @include(
                                'products.partials.block',
                                [
                                    'block' =>
                                        $child,

                                    'contents' =>
                                        $contents,

                                    'product' =>
                                        $product,

                                    'publishedAt' =>
                                        $publishedAt,
                                ]
                            )

                        @endforeach

                    </div>

                </div>


            {{-- ============================================================
                Custom Table
            ============================================================ --}}

            @elseif(
                $type
                ===
                'custom_table'
            )

                @php

                    /*
                     * Custom Table V2 is saved directly in the block content:
                     * { title: ..., rows: [...] }.
                     * Keep accepting the old nested `table` payload as well.
                     */
                    $table =
                        is_array(
                            $content['table']
                            ??
                            null
                        )
                            ? $content['table']
                            : $content;


                    $tableTitle =
                        trim(
                            (string)
                            (
                                $table['title']
                                ??
                                ''
                            )
                        );


                    $rows =
                        is_array(
                            $table['rows']
                            ??
                            null
                        )
                            ? $table['rows']
                            : [];

                @endphp


                @if(
                    count(
                        $rows
                    )
                )

                    <div class="store-table-scroll">

                        @if(
                            $tableTitle
                            !==
                            ''
                        )

                            <h3 class="store-custom-table-title">
                                {{ $tableTitle }}
                            </h3>

                        @endif

                        <table class="store-custom-table">

                            <colgroup>
                                <col
                                    span="200"
                                    style="width: 0.5%;"
                                >
                            </colgroup>

                            <tbody>

                                @foreach(
                                    $rows
                                    as $row
                                )

                                    @php

                                        $cells =
                                            is_array(
                                                $row['cells']
                                                ??
                                                null
                                            )
                                                ? $row['cells']
                                                : [];


                                        $rowHeight =
                                            max(
                                                0,
                                                min(
                                                    1000,
                                                    (int)
                                                    (
                                                        $row['height']
                                                        ??
                                                        0
                                                    )
                                                )
                                            );


                                        $rowBackground =
                                            trim(
                                                (string)
                                                (
                                                    $row[
                                                        'background_color'
                                                    ]
                                                    ??
                                                    ''
                                                )
                                            );


                                        if (
                                            !preg_match(
                                                '/^#[0-9a-fA-F]{6}$/',
                                                $rowBackground
                                            )
                                        ) {

                                            $rowBackground =
                                                '';

                                        }

                                    @endphp


                                    <tr
                                        @if($rowHeight > 0)
                                            style="height: {{ $rowHeight }}px;"
                                        @endif
                                    >

                                        @foreach(
                                            $cells
                                            as $cell
                                        )

                                            @php

                                                $width =
                                                    (float)
                                                    (
                                                        $cell['width']
                                                        ??
                                                        0
                                                    );


                                                $width =
                                                    max(
                                                        0,
                                                        min(
                                                            100,
                                                            $width
                                                        )
                                                    );


                                                $rowspan =
                                                    max(
                                                        1,
                                                        min(
                                                            20,
                                                            (int)
                                                            (
                                                                $cell[
                                                                    'rowspan'
                                                                ]
                                                                ??
                                                                1
                                                            )
                                                        )
                                                    );


                                                $background =
                                                    $rowBackground
                                                    !==
                                                    ''
                                                        ? $rowBackground
                                                        : (
                                                            $cell[
                                                                'background_color'
                                                            ]
                                                            ??
                                                            $cell[
                                                                'background'
                                                            ]
                                                            ??
                                                            '#ffffff'
                                                        );


                                                if (
                                                    !preg_match(
                                                        '/^#[0-9a-fA-F]{6}$/',
                                                        $background
                                                    )
                                                ) {

                                                    $background =
                                                        '#ffffff';

                                                }


                                                $color =
                                                    $cell[
                                                        'text_color'
                                                    ]
                                                    ??
                                                    $cell[
                                                        'color'
                                                    ]
                                                    ??
                                                    '#000000';


                                                if (
                                                    !preg_match(
                                                        '/^#[0-9a-fA-F]{6}$/',
                                                        $color
                                                    )
                                                ) {

                                                    $color =
                                                        '#000000';

                                                }


                                                $cellAlign =
                                                    $cell[
                                                        'align'
                                                    ]
                                                    ??
                                                    'center';


                                                if (
                                                    !in_array(
                                                        $cellAlign,
                                                        [
                                                            'left',
                                                            'center',
                                                            'right',
                                                        ],
                                                        true
                                                    )
                                                ) {

                                                    $cellAlign =
                                                        'center';

                                                }


                                                $bold =
                                                    !empty(
                                                        $cell[
                                                            'bold'
                                                        ]
                                                    );


                                                $colspan =
                                                    $width > 0
                                                        ? max(
                                                            1,
                                                            min(
                                                                200,
                                                                (int)
                                                                round(
                                                                    $width
                                                                    * 2
                                                                )
                                                            )
                                                        )
                                                        : max(
                                                            1,
                                                            min(
                                                                200,
                                                                (int)
                                                                (
                                                                    $cell[
                                                                        'colspan'
                                                                    ]
                                                                    ?? 1
                                                                )
                                                            )
                                                        );


                                                $verticalAlign =
                                                    $cell[
                                                        'vertical_align'
                                                    ]
                                                    ??
                                                    'middle';


                                                if (
                                                    !in_array(
                                                        $verticalAlign,
                                                        [
                                                            'top',
                                                            'middle',
                                                            'bottom',
                                                        ],
                                                        true
                                                    )
                                                ) {

                                                    $verticalAlign =
                                                        'middle';

                                                }


                                                $padding =
                                                    max(
                                                        0,
                                                        min(
                                                            50,
                                                            (int)
                                                            (
                                                                $cell[
                                                                    'padding'
                                                                ]
                                                                ??
                                                                8
                                                            )
                                                        )
                                                    );

                                            @endphp


                                            <td
                                                colspan="{{ $colspan }}"
                                                rowspan="{{ $rowspan }}"
                                                style="
                                                    background:
                                                    {{ $background }};

                                                    color:
                                                    {{ $color }};

                                                    text-align:
                                                    {{ $cellAlign }};

                                                    vertical-align:
                                                    {{ $verticalAlign }};

                                                    padding:
                                                    {{ $padding }}px;

                                                    font-weight:
                                                    {{
                                                        $bold
                                                        ? '700'
                                                        : '400'
                                                    }};
                                                "
                                            >

                                                {!! nl2br(
                                                    e(
                                                        $cell['content']
                                                        ??
                                                        $cell['text']
                                                        ??
                                                        ''
                                                    )
                                                ) !!}

                                            </td>

                                        @endforeach

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @endif


            {{-- ============================================================
                Template Button
            ============================================================ --}}

            @elseif(
                $type
                ===
                'template_button'
            )

                @php

                    $templateUrl =
                        $safeUrl(
                            $content[
                                'template_url'
                            ]
                            ??
                            ''
                        );

                @endphp


                @if(
                    $templateUrl
                )

                    <a
                        href="{{ $templateUrl }}"
                        class="store-template-button"
                        target="_blank"
                        rel="noopener noreferrer"
                        download
                    >

                        {{
                            $content['text']
                            ??
                            'テンプレートダウンロード'
                        }}

                    </a>

                @endif


            {{-- ============================================================
                Shipping Schedule
            ============================================================ --}}

            @elseif(
                $type
                ===
                'shipping_schedule'
            )

                @php

                    $displayType =
                        $content[
                            'display_type'
                        ]
                        ??
                        'stacked';


                    $schedules =
                        is_array(
                            $content[
                                'schedules'
                            ]
                            ??
                            null
                        )
                            ? $content[
                                'schedules'
                            ]
                            : [];


                    $startLabel =
                        $content[
                            'start_label'
                        ]
                        ??
                        '原稿確定日';


                    $shippingLabel =
                        $content[
                            'shipping_label'
                        ]
                        ??
                        '出荷予定';

                @endphp


                <div class="store-shipping-schedule">

                    @if(
                        !empty(
                            $content[
                                'title'
                            ]
                        )
                    )

                        <h2 class="store-shipping-title">

                            {{
                                $content[
                                    'title'
                                ]
                            }}

                        </h2>

                    @endif


                    @if(
                        $displayType
                        ===
                        'grouped'
                        &&
                        !empty(
                            $content[
                                'intro_text'
                            ]
                        )
                    )

                        <div class="store-shipping-intro">

                            {!! nl2br(
                                e(
                                    $content[
                                        'intro_text'
                                    ]
                                )
                            ) !!}

                        </div>

                    @endif


                    {{-- ====================================================
                        GROUPED
                    ==================================================== --}}

                    @if(
                        $displayType
                        ===
                        'grouped'
                    )

                        <div class="store-shipping-group-badges">

                            @foreach(
                                $schedules
                                as $schedule
                            )

                                @php

                                    $theme =
                                        $schedule[
                                            'theme'
                                        ]
                                        ??
                                        'blue';


                                    if (
                                        !in_array(
                                            $theme,
                                            [
                                                'blue',
                                                'pink',
                                                'cyan',
                                                'orange',
                                                'gray',
                                            ],
                                            true
                                        )
                                    ) {

                                        $theme =
                                            'blue';

                                    }

                                @endphp


                                <span
                                    class="
                                        store-shipping-badge
                                        store-theme-{{ $theme }}
                                    "
                                >

                                    {{
                                        $schedule[
                                            'label'
                                        ]
                                        ??
                                        ''
                                    }}

                                    {{
                                        (int)
                                        (
                                            $schedule[
                                                'days'
                                            ]
                                            ??
                                            0
                                        )
                                    }}営業日後出荷

                                </span>

                            @endforeach

                        </div>


                        <table class="store-shipping-table">

                            <tbody>

                                <tr>

                                    <th>

                                        {{ $startLabel }}

                                    </th>

                                    <td colspan="2">

                                        <span data-shipping-start-time>

                                            -

                                        </span>

                                    </td>

                                </tr>


                                @foreach(
                                    $schedules
                                    as $schedule
                                )

                                    <tr>

                                        <th>

                                            {{
                                                $schedule[
                                                    'label'
                                                ]
                                                ??
                                                ''
                                            }}

                                        </th>


                                        <td>

                                            {{ $shippingLabel }}

                                        </td>


                                        <td>

                                            <strong
                                                data-shipping-date-days="{{
                                                    (int)
                                                    (
                                                        $schedule[
                                                            'days'
                                                        ]
                                                        ??
                                                        0
                                                    )
                                                }}"
                                            >

                                                -

                                            </strong>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>


                    {{-- ====================================================
                        STACKED
                    ==================================================== --}}

                    @else

                        @foreach(
                            $schedules
                            as $schedule
                        )

                            @php

                                $theme =
                                    $schedule[
                                        'theme'
                                    ]
                                    ??
                                    'blue';


                                if (
                                    !in_array(
                                        $theme,
                                        [
                                            'blue',
                                            'pink',
                                            'cyan',
                                            'orange',
                                            'gray',
                                        ],
                                        true
                                    )
                                ) {

                                    $theme =
                                        'blue';

                                }


                                $tableMessage =
                                    $schedule[
                                        'message'
                                    ]
                                    ??
                                    (
                                        $content[
                                            'intro_text'
                                        ]
                                        ??
                                        ''
                                    );


                                if (
                                    $theme === 'cyan'
                                    &&
                                    empty(
                                        $schedule[
                                            'message'
                                        ]
                                    )
                                ) {

                                    $tableMessage =
                                        '今、この製品をご注文頂いた場合の出荷予定日を表示中';

                                }

                            @endphp


                            <div
                                class="
                                    store-shipping-item
                                    store-shipping-item-{{ $theme }}
                                "
                            >

                            <div class="store-shipping-heading">

                                <div class="store-shipping-delivery">

                                    <span
                                        class="
                                            store-shipping-badge
                                            store-theme-{{ $theme }}
                                        "
                                    >

                                        {{
                                            $schedule[
                                                'label'
                                            ]
                                            ??
                                            ''
                                        }}

                                    </span>

                                </div>


                                <div class="store-shipping-delivery">

                                <strong class="store-shipping-days">

                                    {{
                                        (int)
                                        (
                                            $schedule[
                                                'days'
                                            ]
                                            ??
                                            0
                                        )
                                    }}営業日後出荷

                                </strong>

                                </div>

                            </div>


                            <table class="store-shipping-table">

                                <tbody>

                                    @if(
                                        !empty($tableMessage)
                                    )

                                        <tr class="store-shipping-message-row">

                                            <td colspan="2">

                                                {!! nl2br(
                                                    e(
                                                        $tableMessage
                                                    )
                                                ) !!}

                                            </td>

                                        </tr>

                                    @endif

                                    <tr class="store-shipping-label-row">

                                        <th>

                                            {{ $startLabel }}

                                        </th>

                                        <th>

                                            {{ $shippingLabel }}

                                        </th>

                                    </tr>

                                    <tr class="store-shipping-date-row">

                                        <td>

                                            <span data-shipping-start-time>

                                                -

                                            </span>

                                        </td>


                                        <td>

                                            <strong
                                                data-shipping-date-days="{{
                                                    (int)
                                                    (
                                                        $schedule[
                                                            'days'
                                                        ]
                                                        ??
                                                        0
                                                    )
                                                }}"
                                            >

                                                -

                                            </strong>

                                        </td>

                                    </tr>

                                </tbody>

                            </table>

                            </div>

                        @endforeach

                    @endif


                    @if(
                        !empty(
                            $content[
                                'footer_note'
                            ]
                        )
                    )

                        <div class="store-shipping-footer">

                            {{
                                $content[
                                    'footer_note'
                                ]
                            }}

                        </div>

                    @endif

                </div>


            {{-- ============================================================
                OptionCardGrid
            ============================================================ --}}

            @elseif(
                $type
                ===
                'option_card_grid'
            )

                @php
                    $title =
                        $content['title']
                        ??
                        (
                            $settings['title']
                            ??
                            ''
                        );

                    $intro =
                        $content['intro']
                        ??
                        '当店ラバーストラップのアタッチメント・加工・オプションのご紹介です。';

                    $cleanBlockId =
                        preg_replace(
                            '/[^A-Za-z0-9\-_]/',
                            '_',
                            $blockId
                        );

                    $tabs =
                        $content['tabs']
                        ?? null;

                    $hasCustomTabs =
                        is_array($tabs) && count($tabs) > 0;

                    $tab1Id =
                        'tab1_' . $cleanBlockId;

                    $tab2Id =
                        'tab2_' . $cleanBlockId;

                    $tab3Id =
                        'tab3_' . $cleanBlockId;
                @endphp

                <div class="store-option-card-grid plan-section">

                    @if(!empty($title))
                        <h3 class="product-d_feature_title">
                            {{ $title }}
                        </h3>
                    @endif

                    @if(!empty($intro))
                        <p class="new-text">
                            {{ $intro }}
                        </p>
                        <br>
                    @endif

                    @if($hasCustomTabs)
                        <div class="tab-container">
                            <div class="tab-menu">
                                @foreach($tabs as $tabIdx => $tab)
                                    @php
                                        $tabKey = !empty($tab['id']) ? $tab['id'] : ('tab_' . $tabIdx);
                                        $tabTargetId = 'opt_tab_' . $cleanBlockId . '_' . preg_replace('/[^A-Za-z0-9\-_]/', '_', $tabKey);
                                    @endphp
                                    <button
                                        type="button"
                                        class="tab-link {{ $loop->first ? 'active' : '' }}"
                                        data-tab-target="{{ $tabTargetId }}"
                                    >
                                        {{ $tab['title'] ?? ('タブ ' . ($tabIdx + 1)) }}
                                    </button>
                                @endforeach
                            </div>

                            @foreach($tabs as $tabIdx => $tab)
                                @php
                                    $tabKey = !empty($tab['id']) ? $tab['id'] : ('tab_' . $tabIdx);
                                    $tabTargetId = 'opt_tab_' . $cleanBlockId . '_' . preg_replace('/[^A-Za-z0-9\-_]/', '_', $tabKey);
                                    $tabType = $tab['type'] ?? 'cards';
                                    $items = is_array($tab['items'] ?? null) ? $tab['items'] : [];
                                @endphp

                                <div
                                    id="{{ $tabTargetId }}"
                                    class="tab-content {{ $loop->first ? 'active' : '' }}"
                                    style="{{ $loop->first ? 'display: block;' : 'display: none;' }}"
                                >
                                    @if($tabType === 'parts')
                                        <div class="grid-layout">
                                            <div class="itemz" style="flex: 1 1 100%;">
                                                <div class="row option-parts-row">
                                                    @foreach($items as $item)
                                                        @php
                                                            $itemImg = $item['image_url'] ?? '';
                                                            $itemTitle = $item['title'] ?? '';
                                                            $itemPrice = $item['price'] ?? '';
                                                            $itemZoom = !empty($item['zoom_url']) ? $item['zoom_url'] : $itemImg;
                                                        @endphp
                                                        <div class="mt-10-part-4">
                                                            @if(!empty($itemZoom))
                                                                <a href="{{ $itemZoom }}" target="_blank" rel="noopener">
                                                                    <img class="picpro" src="{{ $itemImg }}" alt="{{ $itemTitle }}" width="160" height="160" loading="lazy">
                                                                </a>
                                                            @else
                                                                <img class="picpro" src="{{ $itemImg }}" alt="{{ $itemTitle }}" width="160" height="160" loading="lazy">
                                                            @endif
                                                            <br>
                                                            @if($itemPrice !== '')
                                                                <div class="part-price">{{ $itemPrice }}</div>
                                                            @endif
                                                            @if(!empty($itemZoom))
                                                                <a href="{{ $itemZoom }}" target="_blank" rel="noopener" class="part-zoom" style="font-size: 10px; color: black !important;">
                                                                    📷クリックすると拡大します
                                                                </a>
                                                            @endif
                                                        </div>
                                                    @endforeach

                                                    @if(!empty($tab['banner_image_url']))
                                                        <div class="part_link">
                                                            @if(!empty($tab['banner_link_url']))
                                                                <a href="{{ $tab['banner_link_url'] }}">
                                                                    <img src="{{ $tab['banner_image_url'] }}" alt="{{ $tab['title'] ?? '' }}" width="570" height="192" loading="lazy">
                                                                </a>
                                                            @else
                                                                <img src="{{ $tab['banner_image_url'] }}" alt="{{ $tab['title'] ?? '' }}" width="570" height="192" loading="lazy">
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        @php
                                            $chunks = array_chunk($items, 2);
                                        @endphp
                                        @foreach($chunks as $cIdx => $chunk)
                                            @if($cIdx > 0)
                                                <br>
                                            @endif
                                            <div class="grid-layout">
                                                @foreach($chunk as $card)
                                                    @php
                                                        $cardImg = $card['image_url'] ?? '';
                                                        $cardTitle = $card['title'] ?? '';
                                                        $cardDesc = $card['description'] ?? '';
                                                        $cardLinkText = $card['link_text'] ?? '詳細はこちら';
                                                        $cardLinkUrl = $card['link_url'] ?? '';
                                                        $isExternal = str_starts_with($cardLinkUrl, 'http://') || str_starts_with($cardLinkUrl, 'https://');
                                                    @endphp
                                                    <div class="itemz">
                                                        @if(!empty($cardImg))
                                                            <img src="{{ $cardImg }}" alt="{{ $cardTitle }}" loading="lazy">
                                                        @endif
                                                        @if(!empty($cardTitle))
                                                            <p class="new-text" style="font-weight: bold; margin-top: 5px;">{{ $cardTitle }}</p>
                                                        @endif
                                                        @if(!empty($cardDesc))
                                                            <p class="new-text">
                                                                {!! nl2br(e($cardDesc)) !!}
                                                            </p>
                                                        @endif
                                                        @if(!empty($cardLinkUrl))
                                                            <br>
                                                            <div>
                                                                <a href="{{ $cardLinkUrl }}"
                                                                   @if($isExternal) target="_blank" rel="noopener" @endif
                                                                   class="new-text option-more-link" style="color: black;">
                                                                    {{ $cardLinkText }}
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- Fallback default 3 tabs (Rubberstrap) --}}
                        <div class="tab-container">

                        <div class="tab-menu">
                            <button
                                type="button"
                                class="tab-link active"
                                data-tab-target="{{ $tab1Id }}"
                            >
                                アタッチメント
                            </button>

                            <button
                                type="button"
                                class="tab-link"
                                data-tab-target="{{ $tab2Id }}"
                            >
                                加工方法
                            </button>

                            <button
                                type="button"
                                class="tab-link"
                                data-tab-target="{{ $tab3Id }}"
                            >
                                オプション
                            </button>
                        </div>

                        {{-- Tab 1: アタッチメント --}}
                        <div
                            id="{{ $tab1Id }}"
                            class="tab-content active"
                        >
                            <div class="grid-layout">
                                <div class="itemz" style="flex: 1 1 100%;">
                                    <div class="row option-parts-row">

                                        <div class="mt-10-part-4">
                                            <a href="/products/images/HM_part1.webp" target="_blank" rel="noopener">
                                                <img class="picpro" src="/products/images/HM_part1.webp" alt="通常松葉+カニカン" width="160" height="160" loading="lazy">
                                            </a>
                                            <br>
                                            <div class="part-price">+0円</div>
                                            <a href="/products/images/HM_part1.webp" target="_blank" rel="noopener" class="part-zoom" style="font-size: 10px; color: black !important;">
                                                📷クリックすると拡大します
                                            </a>
                                        </div>

                                        <div class="mt-10-part-4">
                                            <a href="/products/images/HM_part2.webp" target="_blank" rel="noopener">
                                                <img class="picpro" src="/products/images/HM_part2.webp" alt="ゴム松葉+カニカン" width="160" height="160" loading="lazy">
                                            </a>
                                            <br>
                                            <div class="part-price">+0円</div>
                                            <a href="/products/images/HM_part2.webp" target="_blank" rel="noopener" class="part-zoom" style="font-size: 10px; color: black !important;">
                                                📷クリックすると拡大します
                                            </a>
                                        </div>

                                        <div class="mt-10-part-4">
                                            <a href="/products/images/HM_part14.webp" target="_blank" rel="noopener">
                                                <img class="picpro" src="/products/images/HM_part14.webp" alt="ボールチェーンシルバー" width="160" height="160" loading="lazy">
                                            </a>
                                            <br>
                                            <div class="part-price">+0円</div>
                                            <a href="/products/images/HM_part14.webp" target="_blank" rel="noopener" class="part-zoom" style="font-size: 10px; color: black !important;">
                                                📷クリックすると拡大します
                                            </a>
                                        </div>

                                        <div class="mt-10-part-4">
                                            <a href="/products/images/HM_part3.webp" target="_blank" rel="noopener">
                                                <img class="picpro" src="/products/images/HM_part3.webp" alt="通常松葉+カニカン+スマホプラグ" width="160" height="160" loading="lazy">
                                            </a>
                                            <br>
                                            <div class="part-price">+11円</div>
                                            <a href="/products/images/HM_part3.webp" target="_blank" rel="noopener" class="part-zoom" style="font-size: 10px; color: black !important;">
                                                📷クリックすると拡大します
                                            </a>
                                        </div>

                                        <div class="mt-10-part-4">
                                            <a href="/products/images/HM_part9.webp" target="_blank" rel="noopener">
                                                <img class="picpro" src="/products/images/HM_part9.webp" alt="ボールチェーン黄色" width="160" height="160" loading="lazy">
                                            </a>
                                            <br>
                                            <div class="part-price">+11円</div>
                                            <a href="/products/images/HM_part9.webp" target="_blank" rel="noopener" class="part-zoom" style="font-size: 10px; color: black !important;">
                                                📷クリックすると拡大します
                                            </a>
                                        </div>

                                        <div class="mt-10-part-4">
                                            <a href="/products/images/HM_part10.webp" target="_blank" rel="noopener">
                                                <img class="picpro" src="/products/images/HM_part10.webp" alt="ボールチェーン赤色" width="160" height="160" loading="lazy">
                                            </a>
                                            <br>
                                            <div class="part-price">+11円</div>
                                            <a href="/products/images/HM_part10.webp" target="_blank" rel="noopener" class="part-zoom" style="font-size: 10px; color: black !important;">
                                                📷クリックすると拡大します
                                            </a>
                                        </div>

                                        <div class="mt-10-part-4">
                                            <a href="/products/images/HM_part11.webp" target="_blank" rel="noopener">
                                                <img class="picpro" src="/products/images/HM_part11.webp" alt="ボールチェーン青色" width="160" height="160" loading="lazy">
                                            </a>
                                            <br>
                                            <div class="part-price">+11円</div>
                                            <a href="/products/images/HM_part11.webp" target="_blank" rel="noopener" class="part-zoom" style="font-size: 10px; color: black !important;">
                                                📷クリックすると拡大します
                                            </a>
                                        </div>

                                        <div class="mt-10-part-4">
                                            <a href="/products/images/HM_part12.webp" target="_blank" rel="noopener">
                                                <img class="picpro" src="/products/images/HM_part12.webp" alt="ボールチェーンピンク色" width="160" height="160" loading="lazy">
                                            </a>
                                            <br>
                                            <div class="part-price">+11円</div>
                                            <a href="/products/images/HM_part12.webp" target="_blank" rel="noopener" class="part-zoom" style="font-size: 10px; color: black !important;">
                                                📷クリックすると拡大します
                                            </a>
                                        </div>

                                        <div class="mt-10-part-4">
                                            <a href="/products/images/HM_part13.webp" target="_blank" rel="noopener">
                                                <img class="picpro" src="/products/images/HM_part13.webp" alt="ボールチェーン緑色" width="160" height="160" loading="lazy">
                                            </a>
                                            <br>
                                            <div class="part-price">+11円</div>
                                            <a href="/products/images/HM_part13.webp" target="_blank" rel="noopener" class="part-zoom" style="font-size: 10px; color: black !important;">
                                                📷クリックすると拡大します
                                            </a>
                                        </div>

                                        <div class="part_link">
                                            <a href="/products/rubberkeyholder/#part_keyholder">
                                                <img src="/products/images/accessories.webp" alt="アタッチメント一覧" width="570" height="192" loading="lazy">
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tab 2: 加工方法 --}}
                        <div
                            id="{{ $tab2Id }}"
                            class="tab-content"
                        >
                            <div class="grid-layout">
                                <div class="itemz">
                                    <img src="/products/images/rubberstrap/v2/rubber_guide02.webp" alt="ぷっくり凹凸タイプ・フラットタイプ" loading="lazy">
                                    <p class="new-text">
                                        あなたのデザインを最高のラバーキーホルダーに！キャラクターに最適な「ぷっくり凹凸タイプ」や、ドット絵・ロゴ向きの「フラットタイプ」が選べます。
                                    </p>
                                    <br>
                                    <div>
                                        <a href="/lp/rubber-guide-structure.php" class="new-text option-more-link" style="color: black;">
                                            詳細はこちら
                                        </a>
                                    </div>
                                </div>

                                <div class="itemz">
                                    <img src="/products/images/rubberstrap/v2/rubber_guide07.webp" alt="特殊加工" loading="lazy">
                                    <p class="new-text">
                                        曲面加工や貼り合わせ半立体、貫通穴（中抜き）加工などの特殊加工もご用意！デザインをより活かす特別なラバーストラップを製作できます。
                                    </p>
                                    <br>
                                    <div>
                                        <a href="/lp/rubber-guide-structure.php?sec=special_processing" class="new-text option-more-link" style="color: black;">
                                            詳細はこちら
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tab 3: オプション --}}
                        <div
                            id="{{ $tab3Id }}"
                            class="tab-content"
                        >
                            <div class="grid-layout">
                                <div class="itemz">
                                    <img src="/products/images/rubberstrap/v2/rubber_strap_protect.webp" alt="汚れ防止加工オプション" loading="lazy">
                                    <p class="new-text">
                                        業界唯一の汚れ防止加工オプションをご用意！あなたの大切なラバーストラップをキレイに保ちます。
                                    </p>
                                    <br>
                                    <div>
                                        <a href="https://hotmobily.jp/faq/details/rubberstrap/q4" target="_blank" rel="noopener" class="new-text option-more-link" style="color: black;">
                                            詳細はこちら
                                        </a>
                                    </div>
                                </div>

                                <div class="itemz">
                                    <img src="/products/images/rubberstrap/v2/rubberstrap_special.webp" alt="特殊素材" loading="lazy">
                                    <p class="new-text">
                                        金銀、蓄光、ラメ、蛍光、半透明素材の5種の特殊素材をご用意！
                                    </p>
                                    <br>
                                    <div>
                                        <a href="/lp/rubber-guide-special.php" class="new-text option-more-link" style="color: black;">
                                            詳細はこちら
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <br>

                            <div class="grid-layout">
                                <div class="itemz">
                                    <img src="/products/images/rubberstrap/v2/rubber_guide11.webp" alt="データ作成代行サービス" loading="lazy">
                                    <p class="new-text">
                                        入稿データをご自身で作成するのが難しい方は、データ作成代行サービスをぜひご利用ください。
                                    </p>
                                    <br>
                                    <div>
                                        <a href="/lp/rubber-guide-data.php" class="new-text option-more-link" style="color: black;">
                                            詳細はこちら
                                        </a>
                                    </div>
                                </div>

                                <div class="itemz">
                                    <img src="/products/images/rubberstrap/v2/daishi_rubberstrap.webp" alt="台紙封入サービス" loading="lazy">
                                    <p class="new-text">
                                        台紙封入サービスをご用意しております。当店のテンプレートデザイン、またはお客様のオリジナルデザインの台紙を封入します。
                                    </p>
                                    <br>
                                    <div>
                                        <a href="https://hotmobily.jp/products/daishi.html" target="_blank" rel="noopener" class="new-text option-more-link" style="color: black;">
                                            詳細はこちら
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    @endif

                </div>


            {{-- ============================================================
                Divider
            ============================================================ --}}

            @elseif(
                $type
                ===
                'divider'
            )

                <hr class="store-divider">


            {{-- ============================================================
                Spacer
            ============================================================ --}}

            @elseif(
                $type
                ===
                'spacer'
            )

                @php

                    $height =
                        (int)
                        (
                            $settings[
                                'height'
                            ]
                            ??
                            30
                        );


                    $height =
                        max(
                            0,
                            min(
                                300,
                                $height
                            )
                        );

                @endphp


                <div
                    style="
                        height:
                        {{ $height }}px;
                    "
                ></div>


            {{-- ============================================================
                System Components
            ============================================================ --}}

            @elseif(
                in_array(
                    $type,
                    [
                        'price_accordion',
                        'production_schedule',
                    ],
                    true
                )
            )

                {{--
                    ยังไม่ Render รอบนี้

                    จะทำเมื่อเชื่อมข้อมูล System Component
                --}}

            @endif

        </div>

    </div>

</div>

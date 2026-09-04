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
            : [];


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

                <div class="store-rich-text new-text">

                    {!! nl2br(
                        e(
                            $content['content']
                            ??
                            ''
                        )
                    ) !!}

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

                @endphp


                @if(
                    $linkUrl
                )

                    <a
                        href="{{ $linkUrl }}"
                        class="store-text-link"

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

                    $table =
                        is_array(
                            $content['table']
                            ??
                            null
                        )
                            ? $content['table']
                            : [];


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

                        <table class="store-custom-table">

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

                                    @endphp


                                    <tr>

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


                                                $colspan =
                                                    max(
                                                        1,
                                                        min(
                                                            20,
                                                            (int)
                                                            (
                                                                $cell[
                                                                    'colspan'
                                                                ]
                                                                ??
                                                                1
                                                            )
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
                                                    $cell[
                                                        'background'
                                                    ]
                                                    ??
                                                    '#ffffff';


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

                                            @endphp


                                            <td
                                                colspan="{{ $colspan }}"
                                                rowspan="{{ $rowspan }}"
                                                style="
                                                    {{
                                                        $width > 0
                                                        ? 'width:' . $width . '%;'
                                                        : ''
                                                    }}

                                                    background:
                                                    {{ $background }};

                                                    color:
                                                    {{ $color }};

                                                    text-align:
                                                    {{ $cellAlign }};

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

                            @endphp


                            <div class="store-shipping-heading">

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


                                <strong>

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


                            <table class="store-shipping-table">

                                <thead>

                                    <tr>

                                        <th>

                                            {{ $startLabel }}

                                        </th>

                                        <th>

                                            {{ $shippingLabel }}

                                        </th>

                                    </tr>

                                </thead>


                                <tbody>

                                    <tr>

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

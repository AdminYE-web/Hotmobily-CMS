@php

    $admin = Auth::guard('admin')->user();

    $username = $admin?->user ?? '';
    $userRank = $admin?->lang ?? '';
    $dept = $admin?->dept ?? '';

    $isShippingMember = $dept === 'shipping';
    $isSalesJpMember = $dept === 'sales_jp';
    $isAdminMember = $dept === 'admin';
    $isCooMember = $dept === 'coo';
    $isDesignerMember = $dept === 'designer';

    $isDesignerUsername = str_starts_with(
        $username,
        'designer_'
    );

@endphp


<div
    class="bg-light border-right"
    id="sidebar-wrapper"
>

    <div class="sidebar-heading">
        Menu
    </div>


    <div class="list-group list-group-flush">

        @if (
            in_array(
                $username,
                [
                    'aum',
                    'may',
                    'irin',
                    'ice',
                    'mook',
                    'ausma'
                ]
            )
            || $isDesignerUsername
            || $isCooMember
            || $isDesignerMember
        )

            <a
                href="/admin/design_lists.php"
                class="list-group-item list-group-item-action bg-light"
            >
                Design making request
            </a>


            <a
                href="/admin/production_lists.php"
                class="list-group-item list-group-item-action bg-light"
            >
                Production request
            </a>


            @if (
                in_array(
                    $username,
                    [
                        'aum',
                        'may',
                        'irin',
                        'ausma',
                        'designer_bew'
                    ]
                )
                || $isCooMember
            )

                <a
                    href="/admin/designer-report.php"
                    class="list-group-item list-group-item-action bg-light"
                >
                    Designer Report
                </a>

            @endif


        @elseif (
            in_array(
                $username,
                [
                    'admin_yecn_1',
                    'admin_hs3',
                    'admin_gzoversold',
                    'zhong',
                    'cy',
                    'dyl',
                    'fang',
                    'zizi',
                    'po',
                    'axin'
                ]
            )
            || $userRank === 'cn'
        )

            <a
                href="/admin/production_lists.php"
                class="list-group-item list-group-item-action bg-light"
            >
                Production request
            </a>

            <a
                href="/admin/production_report_lists.php"
                class="list-group-item list-group-item-action bg-light"
            >
                Report
            </a>

            <a
                href="/admin/cost_management.php"
                class="list-group-item list-group-item-action bg-light"
            >
                Cost Management
            </a>


        @elseif ($username === 'shirai')

            <a
                href="/admin/blog_lists.php"
                class="list-group-item list-group-item-action bg-light"
            >
                Blog
            </a>

            <a
                href="/admin/production_lists.php"
                class="list-group-item list-group-item-action bg-light"
            >
                Production request
            </a>


        @else

            <a
                href="{{ route('admin.dashboard') }}"
                class="list-group-item list-group-item-action bg-light"
            >
                Dashboard
            </a>


            {{-- Review --}}
            <div class="list-group-item list-group-item-action bg-light">

                口コミ

                <ul class="submenu">

                    <li>
                        <a
                            href="{{ route('admin.reviews.index') }}"
                            class="list-group-item list-group-item-action bg-light"
                        >
                            口コミ(参照)
                        </a>
                    </li>

                    <li>
                        <a
                            href="{{ route('admin.review-answers.index') }}"
                            class="list-group-item list-group-item-action bg-light"
                        >
                            口コミ(返答)
                        </a>
                    </li>

                </ul>

            </div>


            {{-- Estimate / Orders --}}
            <div class="list-group-item list-group-item-action bg-light">

                見積&ご注文

                <ul class="submenu">

                    <li>
                        <a
                            href="/admin/estimate.php"
                            class="list-group-item list-group-item-action bg-light"
                        >
                            HM見積
                        </a>
                    </li>

                    <li>
                        <a
                            href="{{ route('admin.orders.index') }}"
                            class="list-group-item list-group-item-action bg-light"
                        >
                            HMご注文
                        </a>
                    </li>

                    <li>
                        <a
                            href="/admin/order_payment"
                            class="list-group-item list-group-item-action bg-light"
                        >
                            HM Transaction
                        </a>
                    </li>

                </ul>

            </div>


            <a
                href="/admin/orders_lost.php"
                class="list-group-item list-group-item-action bg-light"
            >
                Lost Orders

                <span class="badge badge-danger total-lost"></span>
            </a>


            {{-- Design / Production --}}
            <div class="list-group-item list-group-item-action bg-light">

                Design and Production request

                <ul class="submenu">

                    <li>
                        <a
                            href="/admin/design-making-request.php"
                            class="list-group-item list-group-item-action bg-light"
                        >
                            Design making request - Create
                        </a>
                    </li>

                    <li>
                        <a
                            href="/admin/design_lists.php"
                            class="list-group-item list-group-item-action bg-light"
                        >
                            Design making request - Lists
                        </a>
                    </li>

                    <li>
                        <a
                            href="/admin/production-request.php"
                            class="list-group-item list-group-item-action bg-light"
                        >
                            Production request - Create
                        </a>
                    </li>

                    <li>
                        <a
                            href="/admin/production_lists.php"
                            class="list-group-item list-group-item-action bg-light"
                        >
                            Production request - Lists
                        </a>
                    </li>

                    <li>
                        <a
                            href="/admin/production_coating_lists.php"
                            class="list-group-item list-group-item-action bg-light"
                        >
                            Production request - Coating Lists
                        </a>
                    </li>

                </ul>

            </div>


            <a
                href="/admin/simulator_monitor.php"
                class="list-group-item list-group-item-action bg-light"
            >
                Simulator Monitor
            </a>


            {{-- Management --}}
            <div class="list-group-item list-group-item-action bg-light">

                Management

                <ul class="submenu">

                    <li>
                        <a
                            href="/admin/blog_lists.php"
                            class="list-group-item list-group-item-action bg-light"
                        >
                            Blog
                        </a>
                    </li>

                    <li>
                        <a
                            href="/admin/history.php"
                            class="list-group-item list-group-item-action bg-light"
                        >
                            HM Log
                        </a>
                    </li>

                    <li>
                        <a
                            href="/admin/domain_instraction.php"
                            class="list-group-item list-group-item-action bg-light"
                        >
                            Billing Instruction
                        </a>
                    </li>


                    @if (
                        in_array(
                            $username,
                            [
                                'admin_hs2',
                                'sudo',
                                'ome',
                                'takaseki',
                                'aoki',
                                'koizumi'
                            ]
                        )
                        || $isAdminMember
                    )

                        <li>
                            <a
                                href="/admin/blacklists.php"
                                class="list-group-item list-group-item-action bg-light"
                            >
                                Blacklists
                            </a>
                        </li>

                        <li>
                            <a
                                href="/admin/customer_existing.php"
                                class="list-group-item list-group-item-action bg-light"
                            >
                                Existing customer
                            </a>
                        </li>

                        <li>
                            <a
                                href="{{ route('admin.gallery-pages.index') }}"
                                class="list-group-item list-group-item-action bg-light font-weight-bold"
                            >
                                Gallery Page Settings
                            </a>
                        </li>

                        @foreach ($adminGalleryPages ?? collect() as $galleryPage)
                            <li>
                                <a
                                    href="{{ route('admin.gallery-items.index', $galleryPage) }}"
                                    class="list-group-item list-group-item-action bg-light"
                                >
                                    {{ $galleryPage->name }}
                                </a>
                            </li>
                        @endforeach

                    @endif

                </ul>

            </div>
            <a
                href="{{ route('admin.template-products.index') }}"
                class="list-group-item list-group-item-action bg-light"
            >
                Template Management
            </a>

            <div class="list-group-item list-group-item-action bg-light">

    Product Settings

    <ul class="submenu">

        <li>
            <a
                href="{{ route('admin.product-layouts.index') }}"
                class="list-group-item list-group-item-action bg-light"
            >
                Product Layouts
            </a>
        </li>

        <li>
            <a
                href="{{ route('admin.products.index') }}"
                class="list-group-item list-group-item-action bg-light"
            >
                Products
            </a>
        </li>

        <li>
            <a
                href="{{ route('admin.option-groups.index') }}"
                class="list-group-item list-group-item-action bg-light"
            >
                Option Groups
            </a>
        </li>

        <li>
            <a
                href="{{ route('admin.product-options.index') }}"
                class="list-group-item list-group-item-action bg-light"
            >
                Product Options
            </a>
        </li>

        <li>
            <a
                href="{{ route('admin.option-dependencies.index') }}"
                class="list-group-item list-group-item-action bg-light"
            >
                Option Dependencies
            </a>
        </li>

        <li>
            <a
                href="{{ route('admin.option-price-rules.index') }}"
                class="list-group-item list-group-item-action bg-light"
            >
                Option Price Rules
            </a>
        </li>

        <li>
            <a
                href="{{ route('admin.product-price-rules.index') }}"
                class="list-group-item list-group-item-action bg-light"
            >
                Product Price Rules
            </a>
        </li>

    </ul>

</div>

<div class="list-group-item list-group-item-action bg-light">

    Product data setting

    <ul class="submenu">

        <li>
            <a
                href="{{ route('admin.product-data-layouts.index') }}"
                class="list-group-item list-group-item-action bg-light"
            >
                Product Data Layouts
            </a>
        </li>

        <li>
            <a
                href="{{ route('admin.product-data.index') }}"
                class="list-group-item list-group-item-action bg-light"
            >
                Product Data
            </a>
        </li>

    </ul>

</div>

<div class="list-group-item list-group-item-action bg-light">

    Custom Page Setting

    <ul class="submenu">

        <li>
            <a
                href="{{ route('admin.custom-page-layouts.index') }}"
                class="list-group-item list-group-item-action bg-light"
            >
                Custom Page Layouts
            </a>
        </li>

        <li>
            <a
                href="{{ route('admin.custom-pages.index') }}"
                class="list-group-item list-group-item-action bg-light"
            >
                Custom Pages
            </a>
        </li>

    </ul>

</div>


            <a
                href="/admin/contact.php"
                class="list-group-item list-group-item-action bg-light"
            >
                Contact/Inquire
            </a>

            <a
                href="/admin/delivery.php"
                class="list-group-item list-group-item-action bg-light"
            >
                HM Sample Tracking
            </a>


            @if (
                in_array(
                    $username,
                    [
                        'admin_hs2',
                        'sudo',
                        'ome',
                        'takaseki',
                        'aoki',
                        'koizumi'
                    ]
                )
                || $isAdminMember
            )

                <a
                    href="/admin/wappen-category.php"
                    class="list-group-item list-group-item-action bg-light"
                >
                    Wappen Category
                </a>

                <a
                    href="/admin/wappen.php"
                    class="list-group-item list-group-item-action bg-light"
                >
                    Wappen Template
                </a>

            @endif


            @if (
                in_array(
                    $username,
                    [
                        'admin_hs2',
                        'takemura',
                        'kadota',
                        'kagayama',
                        'sudo',
                        'ome',
                        'takaseki',
                        'aoki',
                        'koizumi'
                    ]
                )
                || $isAdminMember
            )

                <a
                    href="/admin/designer-report.php"
                    class="list-group-item list-group-item-action bg-light"
                >
                    Designer Report
                </a>

                <a
                    href="/admin/announce.php"
                    class="list-group-item list-group-item-action bg-light"
                >
                    Announce
                </a>

            @endif


            @if (
                in_array(
                    $username,
                    [
                        'admin_hs2',
                        'sudo',
                        'kadota',
                        'ome',
                        'takaseki',
                        'jung',
                        'aoki',
                        'koizumi'
                    ]
                )
                || $isAdminMember
            )

               <a
                href="{{ route('admin.faqs.index') }}"
                class="list-group-item list-group-item-action bg-light"
            >
                FAQ
            </a>

                <a
                    href="/admin/news.php"
                    class="list-group-item list-group-item-action bg-light"
                >
                    News
                </a>

            @endif


            <a
                href="/admin/sales-orders/"
                class="list-group-item list-group-item-action bg-light"
            >
                Sales order
            </a>

            <a
                href="/admin/cost_management.php"
                class="list-group-item list-group-item-action bg-light"
            >
                Cost Management
            </a>

            <a
                href="/admin/po_number_lists.php"
                class="list-group-item list-group-item-action bg-light"
            >
                PO running number
            </a>

            <a
                href="http://purchase.hotstrap.jp/login.php"
                target="_blank"
                class="list-group-item list-group-item-action bg-light"
            >
                YE China Purchase order
            </a>

            <a
                href="/admin/coating-purchase-request.php"
                class="list-group-item list-group-item-action bg-light"
            >
                Coating Purchase Request
            </a>

            <a
                href="/admin/coating-process.php"
                class="list-group-item list-group-item-action bg-light"
            >
                Coating Process
            </a>
            <li>
    <a
        href="{{ route('admin.holidays.index') }}"
        class="list-group-item list-group-item-action bg-light"
    >
        Holiday Calendar
    </a>
</li>


        @endif

    </div>
    

</div>


<style>

    .submenu {
        display: none;
        position: absolute;
        top: 0;
        left: 100%;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        z-index: 100;
        width: max-content !important;
        list-style: none;
        padding: 0;
    }

    .list-group-item {
        position: relative;
    }

    .list-group-item:hover .submenu {
        display: block;
    }

    div.list-group-item-action {
        display: flex;
        justify-content: space-between;
    }

    div.list-group-item-action:after {
        content: '>';
        font-weight: 900;
    }

</style>

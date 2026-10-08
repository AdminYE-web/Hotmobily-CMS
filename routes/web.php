<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AcrylicGalleryController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CustomPageMenuController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryPageController;
use App\Http\Controllers\Admin\GalleryMenuController;
use App\Http\Controllers\Admin\HomeBannerSettingController;
use App\Http\Controllers\Admin\HomeNotificationSettingController;
use App\Http\Controllers\Admin\HomeProductSettingController;
use App\Http\Controllers\Admin\MeetingDateController as AdminMeetingDateController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\OtpController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\OptionGroupController;
use App\Http\Controllers\Admin\OptionDependencyController;
use App\Http\Controllers\Admin\OptionPriceRuleController;
use App\Http\Controllers\Admin\ProductOptionController;
use App\Http\Controllers\Admin\ProductOptionManagerController;
use App\Http\Controllers\Admin\ProductPriceRuleController;
use App\Http\Controllers\Admin\ProductDataMenuController;
use App\Http\Controllers\Admin\ProductSideMenuController;
use App\Http\Controllers\Admin\SideMenuLinkController;
use App\Http\Controllers\Admin\UserManualMenuController;
use App\Http\Controllers\Admin\ReviewAnswerController as AdminReviewAnswerController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\TemplateProductController as AdminTemplateProductController;
use App\Http\Controllers\Storefront\CustomPageController as StorefrontCustomPageController;
use App\Http\Controllers\Storefront\ContactController as StorefrontContactController;
use App\Http\Controllers\Storefront\GuideController as StorefrontGuideController;
use App\Http\Controllers\Storefront\MeetingDateController as StorefrontMeetingDateController;
use App\Http\Controllers\Storefront\FaqController;
use App\Http\Controllers\Storefront\GalleryController as StorefrontGalleryController;
use App\Http\Controllers\Storefront\ProductController as StorefrontProductController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\HomeNotificationController;
use App\Http\Controllers\Web\LegacyMockController;
use App\Http\Controllers\Web\NewsController as StorefrontNewsController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\ReviewController;
use App\Http\Controllers\Web\ReviewImportController;
use App\Http\Controllers\Web\TemplateController;
use App\Models\Product;
use App\Models\ProductDataLayout;
use App\Models\ProductDataPage;
use App\Models\ProductLayout;
use App\Models\CustomPage;
use App\Models\CustomPageLayout;
use App\Models\GuideLayout;
use App\Models\GuidePage;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get(
    '/',
    HomeController::class
)->name('home');

/*
|--------------------------------------------------------------------------
| Design templates
|--------------------------------------------------------------------------
*/

Route::get('/template', TemplateController::class)
    ->name('template.index');

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Guest
        |--------------------------------------------------------------------------
        */

        Route::middleware('guest:admin')
            ->group(function () {

                /*
                |--------------------------------------------------------------------------
                | Login
                |--------------------------------------------------------------------------
                */

                Route::get(
                    '/login',
                    [
                        AuthController::class,
                        'showLogin',
                    ]
                )
                    ->name('login');

                Route::post(
                    '/login',
                    [
                        AuthController::class,
                        'login',
                    ]
                )
                    ->name('login.submit');

                /*
                |--------------------------------------------------------------------------
                | OTP
                |--------------------------------------------------------------------------
                */

                Route::get(
                    '/login/verify',
                    [
                        OtpController::class,
                        'show',
                    ]
                )
                    ->name('otp');

                Route::post(
                    '/login/verify',
                    [
                        OtpController::class,
                        'verify',
                    ]
                )
                    ->name('otp.verify');

            });

        /*
        |--------------------------------------------------------------------------
        | Authenticated Admin
        |--------------------------------------------------------------------------
        */

        Route::middleware('auth:admin')
            ->group(function () {

                /*
                |--------------------------------------------------------------------------
                | Dashboard
                |--------------------------------------------------------------------------
                */

                Route::get(
                    '/dashboard',
                    [
                        DashboardController::class,
                        'index',
                    ]
                )
                    ->name('dashboard');

                /*
                |--------------------------------------------------------------------------
                | HM Orders
                |--------------------------------------------------------------------------
                */

                Route::get('/orders', [OrderController::class, 'index'])
                    ->name('orders.index');

                Route::get('/orders/export', [OrderController::class, 'export'])
                    ->name('orders.export');

                Route::get('/orders/{order}', [OrderController::class, 'show'])
                    ->name('orders.show');

                /*
                |--------------------------------------------------------------------------
                | HM Contact / Inquire
                |--------------------------------------------------------------------------
                */

                Route::get('/contact', [ContactController::class, 'index'])
                    ->name('contact.index');

                Route::get('/contact.php', [ContactController::class, 'index'])
                    ->name('contact.legacy.index');

                Route::get('/contact_details.php', [ContactController::class, 'legacyShow'])
                    ->name('contact.legacy.show');

                Route::get('/contact/{contact}/attachments/{filename}', [ContactController::class, 'downloadAttachment'])
                    ->where('filename', '[^/]+')
                    ->name('contact.attachment');

                Route::post('/contact/{contact}/reply/confirm', [ContactController::class, 'replyConfirm'])
                    ->name('contact.reply.confirm');

                Route::post('/contact/{contact}/reply/send', [ContactController::class, 'replySend'])
                    ->name('contact.reply.send');

                Route::put('/contact/{contact}/status', [ContactController::class, 'updateStatus'])
                    ->name('contact.status.update');

                Route::get('/contact/{contact}', [ContactController::class, 'show'])
                    ->name('contact.show');

                /*
                |--------------------------------------------------------------------------
                | Meeting Date requests
                |--------------------------------------------------------------------------
                */

                Route::get('/meeting-date', [AdminMeetingDateController::class, 'index'])
                    ->name('meeting-date.index');

                Route::get('/meeting_date', [AdminMeetingDateController::class, 'index'])
                    ->name('meeting-date.legacy.index');

                Route::get('/meeting_date/index.php', [AdminMeetingDateController::class, 'index'])
                    ->name('meeting-date.legacy.php');

                Route::get('/meeting-date/{meetingDate}', [AdminMeetingDateController::class, 'show'])
                    ->name('meeting-date.show');

                Route::put('/meeting-date/{meetingDate}/status', [AdminMeetingDateController::class, 'updateStatus'])
                    ->name('meeting-date.status.update');

                /*
                |--------------------------------------------------------------------------
                | Design template manager
                |--------------------------------------------------------------------------
                */

                Route::post('/template-products/import-legacy', [AdminTemplateProductController::class, 'import'])
                    ->name('template-products.import-legacy');

                Route::post('/template-products/reorder', [AdminTemplateProductController::class, 'reorder'])
                    ->name('template-products.reorder');

                Route::resource('template-products', AdminTemplateProductController::class)
                    ->except('show');

                /*
                |--------------------------------------------------------------------------
                | Banner Settings
                |--------------------------------------------------------------------------
                */

                Route::get('/banner', [BannerController::class, 'edit'])
                    ->name('banner.edit');

                Route::put('/banner', [BannerController::class, 'update'])
                    ->name('banner.update');

                /*
                |--------------------------------------------------------------------------
                | Product galleries
                |--------------------------------------------------------------------------
                */

                Route::resource('gallery-pages', GalleryPageController::class)
                    ->except('show');

                Route::get('/galleries/{galleryPage}', [AcrylicGalleryController::class, 'index'])
                    ->name('gallery-items.index');

                Route::get('/galleries/{galleryPage}/create', [AcrylicGalleryController::class, 'create'])
                    ->name('gallery-items.create');

                Route::post('/galleries/{galleryPage}', [AcrylicGalleryController::class, 'store'])
                    ->name('gallery-items.store');

                Route::get('/galleries/{galleryPage}/{acrylicGallery}/edit', [AcrylicGalleryController::class, 'edit'])
                    ->name('gallery-items.edit');

                Route::put('/galleries/{galleryPage}/{acrylicGallery}', [AcrylicGalleryController::class, 'update'])
                    ->name('gallery-items.update');

                Route::delete('/galleries/{galleryPage}/{acrylicGallery}', [AcrylicGalleryController::class, 'destroy'])
                    ->name('gallery-items.destroy');

                $registerGalleryRoutes = function (
                    string $path,
                    string $galleryPage,
                    string $routeName
                ): void {
                    Route::get('/'.$path, [AcrylicGalleryController::class, 'index'])
                        ->defaults('galleryPage', $galleryPage)
                        ->name($routeName.'.index');

                    Route::get('/'.$path.'/create', [AcrylicGalleryController::class, 'create'])
                        ->defaults('galleryPage', $galleryPage)
                        ->name($routeName.'.create');

                    Route::post('/'.$path, [AcrylicGalleryController::class, 'store'])
                        ->defaults('galleryPage', $galleryPage)
                        ->name($routeName.'.store');

                    Route::get('/'.$path.'/{acrylicGallery}/edit', [AcrylicGalleryController::class, 'edit'])
                        ->defaults('galleryPage', $galleryPage)
                        ->name($routeName.'.edit');

                    Route::put('/'.$path.'/{acrylicGallery}', [AcrylicGalleryController::class, 'update'])
                        ->defaults('galleryPage', $galleryPage)
                        ->name($routeName.'.update');

                    Route::delete('/'.$path.'/{acrylicGallery}', [AcrylicGalleryController::class, 'destroy'])
                        ->defaults('galleryPage', $galleryPage)
                        ->name($routeName.'.destroy');
                };

                $registerGalleryRoutes('acrylic-gallery', 'acrylic-keyholder', 'acrylic-gallery');
                $registerGalleryRoutes('acrylic-coaster-gallery', 'acrylic-coaster', 'acrylic-coaster-gallery');
                $registerGalleryRoutes('acrylic-standee-gallery', 'acrylic-standee', 'acrylic-standee-gallery');
                $registerGalleryRoutes('acrylic-hair-gallery', 'acrylic-hair', 'acrylic-hair-gallery');
                $registerGalleryRoutes('acrylic-strap-gallery', 'acrylic-strap', 'acrylic-strap-gallery');
                $registerGalleryRoutes('rubber-strap-gallery', 'rubber-strap', 'rubber-strap-gallery');
                $registerGalleryRoutes('rubber-keyholder-gallery', 'rubber-keyholder', 'rubber-keyholder-gallery');
                $registerGalleryRoutes('rubber-coaster-gallery', 'rubber-coaster', 'rubber-coaster-gallery');
                $registerGalleryRoutes('wappen-gallery', 'wappen', 'wappen-gallery');

                /*
                |--------------------------------------------------------------------------
                | Holidays
                |--------------------------------------------------------------------------
                */

                Route::view(
                    '/holidays',
                    'admin.holidays.index'
                )
                    ->name('holidays.index');

                /*
                |--------------------------------------------------------------------------
                | FAQs
                |--------------------------------------------------------------------------
                */

                Route::view(
                    '/faqs',
                    'admin.faqs.index'
                )
                    ->name('faqs.index');

                /*
                |--------------------------------------------------------------------------
                | News Management
                |--------------------------------------------------------------------------
                */

                Route::get('/news', [AdminNewsController::class, 'index'])
                    ->name('news.index');

                Route::get('/news/create', [AdminNewsController::class, 'create'])
                    ->name('news.create');

                Route::post('/news', [AdminNewsController::class, 'store'])
                    ->name('news.store');

                Route::post('/news/upload-image', [AdminNewsController::class, 'uploadImage'])
                    ->name('news.upload-image');

                Route::get('/news/{news}/edit', [AdminNewsController::class, 'edit'])
                    ->name('news.edit');

                Route::put('/news/{news}', [AdminNewsController::class, 'update'])
                    ->name('news.update');

                Route::delete('/news/{news}', [AdminNewsController::class, 'destroy'])
                    ->name('news.destroy');

                // Preserve the paths used by the old PHP admin menu and edit links.
                Route::get('/news.php', fn () => redirect()->route('admin.news.index'))
                    ->name('news.legacy.index');

                Route::get('/news-create.php', [AdminNewsController::class, 'legacyEdit'])
                    ->name('news.legacy.create');

                Route::get('/news-create', [AdminNewsController::class, 'legacyEdit'])
                    ->name('news.legacy.edit');

                /*
                |--------------------------------------------------------------------------
                | Reviews
                |--------------------------------------------------------------------------
                */

                Route::get('/reviews', [AdminReviewController::class, 'index'])
                    ->name('reviews.index');

                Route::get('/reviews/create', [AdminReviewController::class, 'create'])
                    ->name('reviews.create');

                Route::post('/reviews', [AdminReviewController::class, 'store'])
                    ->name('reviews.store');

                Route::get('/reviews/{review}/edit', [AdminReviewController::class, 'edit'])
                    ->name('reviews.edit');

                Route::put('/reviews/{review}', [AdminReviewController::class, 'update'])
                    ->name('reviews.update');

                Route::get('/reviews/{review}/answer', [AdminReviewAnswerController::class, 'create'])
                    ->name('review-answers.create');

                Route::post('/reviews/{review}/answer', [AdminReviewAnswerController::class, 'store'])
                    ->name('review-answers.store');

                Route::get('/review-answers', [AdminReviewAnswerController::class, 'index'])
                    ->name('review-answers.index');

                Route::get('/review-answers/{answer}/edit', [AdminReviewAnswerController::class, 'edit'])
                    ->name('review-answers.edit');

                Route::put('/review-answers/{answer}', [AdminReviewAnswerController::class, 'update'])
                    ->name('review-answers.update');

                /*
                |--------------------------------------------------------------------------
                | Production
                |--------------------------------------------------------------------------
                */

                Route::get(
                    '/production-lists',
                    function () {

                        return view(
                            'admin.production-lists'
                        );

                    }
                )
                    ->name('production');

                /*
                |--------------------------------------------------------------------------
                | Design
                |--------------------------------------------------------------------------
                */

                Route::get(
                    '/design-lists',
                    function () {

                        return view(
                            'admin.design-lists'
                        );

                    }
                )
                    ->name('design');

                /*
                |--------------------------------------------------------------------------
                | Products
                |--------------------------------------------------------------------------
                */

                Route::view(
                    '/products',
                    'admin.products.index'
                )
                    ->name('products.index');

                Route::get('/products/{product}/options', [ProductOptionManagerController::class, 'edit'])
                    ->name('products.options.edit');

                Route::put('/products/{product}/options', [ProductOptionManagerController::class, 'update'])
                    ->name('products.options.update');

                /*
                |--------------------------------------------------------------------------
                | Option Groups
                |--------------------------------------------------------------------------
                */

                Route::get('/option-groups', [OptionGroupController::class, 'index'])
                    ->name('option-groups.index');

                Route::get('/option-groups/create', [OptionGroupController::class, 'create'])
                    ->name('option-groups.create');

                Route::post('/option-groups', [OptionGroupController::class, 'store'])
                    ->name('option-groups.store');

                Route::get('/option-groups/{optionGroup}/edit', [OptionGroupController::class, 'edit'])
                    ->name('option-groups.edit');

                Route::put('/option-groups/{optionGroup}', [OptionGroupController::class, 'update'])
                    ->name('option-groups.update');

                /*
                |--------------------------------------------------------------------------
                | Product Options
                |--------------------------------------------------------------------------
                */

                Route::get('/product-options', [ProductOptionController::class, 'index'])
                    ->name('product-options.index');

                Route::get('/product-options/create', [ProductOptionController::class, 'create'])
                    ->name('product-options.create');

                Route::post('/product-options', [ProductOptionController::class, 'store'])
                    ->name('product-options.store');

                Route::get('/product-options/{productOption}/edit', [ProductOptionController::class, 'edit'])
                    ->name('product-options.edit');

                Route::put('/product-options/{productOption}', [ProductOptionController::class, 'update'])
                    ->name('product-options.update');

                Route::delete('/product-options/{productOption}', [ProductOptionController::class, 'destroy'])
                    ->name('product-options.destroy');

                /*
                |--------------------------------------------------------------------------
                | Option Dependencies
                |--------------------------------------------------------------------------
                */

                Route::get('/option-dependencies', [OptionDependencyController::class, 'index'])
                    ->name('option-dependencies.index');

                Route::get('/option-dependencies/create', [OptionDependencyController::class, 'create'])
                    ->name('option-dependencies.create');

                Route::post('/option-dependencies', [OptionDependencyController::class, 'store'])
                    ->name('option-dependencies.store');

                Route::get('/option-dependencies/{optionDependency}/edit', [OptionDependencyController::class, 'edit'])
                    ->name('option-dependencies.edit');

                Route::put('/option-dependencies/{optionDependency}', [OptionDependencyController::class, 'update'])
                    ->name('option-dependencies.update');

                /*
                |--------------------------------------------------------------------------
                | Option Price Rules
                |--------------------------------------------------------------------------
                */

                Route::get('/option-price-rules', [OptionPriceRuleController::class, 'index'])
                    ->name('option-price-rules.index');

                Route::get('/option-price-rules/create', [OptionPriceRuleController::class, 'create'])
                    ->name('option-price-rules.create');

                Route::post('/option-price-rules', [OptionPriceRuleController::class, 'store'])
                    ->name('option-price-rules.store');

                Route::get('/option-price-rules/{optionPriceRule}/edit', [OptionPriceRuleController::class, 'edit'])
                    ->name('option-price-rules.edit');

                Route::put('/option-price-rules/{optionPriceRule}', [OptionPriceRuleController::class, 'update'])
                    ->name('option-price-rules.update');

                /*
                |--------------------------------------------------------------------------
                | Product Price Rules
                |--------------------------------------------------------------------------
                */

                Route::get('/product-price-rules', [ProductPriceRuleController::class, 'index'])
                    ->name('product-price-rules.index');

                Route::get('/product-price-rules/create', [ProductPriceRuleController::class, 'create'])
                    ->name('product-price-rules.create');

                Route::post('/product-price-rules', [ProductPriceRuleController::class, 'store'])
                    ->name('product-price-rules.store');

                Route::get('/product-price-rules/{productPriceRule}/edit', [ProductPriceRuleController::class, 'edit'])
                    ->name('product-price-rules.edit');

                Route::put('/product-price-rules/{productPriceRule}', [ProductPriceRuleController::class, 'update'])
                    ->name('product-price-rules.update');

                /*
                |--------------------------------------------------------------------------
                | Legacy / Old Product Builder
                |--------------------------------------------------------------------------
                |
                | ถ้ายังใช้อยู่เก็บไว้ก่อน
                |
                */

                Route::get(
                    '/products/{product}/builder',
                    function (
                        Product $product
                    ) {

                        return view(
                            'admin.products.builder',
                            compact(
                                'product'
                            )
                        );

                    }
                )
                    ->name('products.builder');

                /*
                |--------------------------------------------------------------------------
                | Product Content Editor
                |--------------------------------------------------------------------------
                |
                | Example:
                |
                | /admin/products/3/content
                |
                */

                Route::get(
                    '/products/{product}/content',
                    function (
                        Product $product
                    ) {

                        return view(
                            'admin.products.content',
                            compact(
                                'product'
                            )
                        );

                    }
                )
                    ->name('products.content');

                Route::post('/products/{product}/content/preview', \App\Http\Controllers\Admin\ProductContentPreviewController::class)
                    ->name('products.content.preview');

                /*
                |--------------------------------------------------------------------------
                | Product Layouts
                |--------------------------------------------------------------------------
                */

                Route::view(
                    '/product-layouts',
                    'admin.product-layouts.index'
                )
                    ->name('product-layouts.index');

                /*
                |--------------------------------------------------------------------------
                | Product Layout Builder
                |--------------------------------------------------------------------------
                |
                | Example:
                |
                | /admin/product-layouts/1/builder
                |
                */

                Route::get(
                    '/product-layouts/{productLayout}/builder',
                    function (
                        ProductLayout $productLayout
                    ) {

                        return view(
                            'admin.product-layouts.builder',
                            compact(
                                'productLayout'
                            )
                        );

                    }
                )
                    ->name('product-layouts.builder');

                /*
                |--------------------------------------------------------------------------
                | Product Data Layouts
                |--------------------------------------------------------------------------
                */

                Route::get(
                    '/product-data-layouts',
                    function () {
                        return view('admin.product-layouts.index', [
                            'layoutManagerTitle' => 'Product Data Layouts',
                            'layoutManagerDescription' => 'Create reusable layouts for product data and artwork guides.',
                            'layoutManagerApiBase' => '/api/v1/admin/product-data-layouts',
                            'layoutManagerBuilderBase' => '/admin/product-data-layouts',
                            'layoutManagerUsageLabel' => 'Product Data',
                            'layoutManagerUsageField' => 'pages_count',
                            'layoutManagerPlaceholder' => 'Layout for product data guides',
                        ]);
                    }
                )
                    ->name('product-data-layouts.index');

                Route::get(
                    '/product-data-layouts/{productDataLayout}/builder',
                    function (ProductDataLayout $productDataLayout) {
                        return view('admin.product-layouts.builder', [
                            'productLayout' => $productDataLayout,
                            'layoutBuilderMode' => 'product_data',
                            'layoutBuilderApiBase' => '/api/v1/admin/product-data-layouts',
                            'layoutBuilderIndexUrl' => route('admin.product-data-layouts.index'),
                        ]);
                    }
                )
                    ->name('product-data-layouts.builder');

                Route::view(
                    '/product-data',
                    'admin.product-data.index'
                )
                    ->name('product-data.index');

                Route::get('/product-data-menu', [ProductDataMenuController::class, 'index'])
                    ->name('product-data-menu.index');

                Route::get('/product-data-menu/create', [ProductDataMenuController::class, 'create'])
                    ->name('product-data-menu.create');

                Route::post('/product-data-menu', [ProductDataMenuController::class, 'store'])
                    ->name('product-data-menu.store');

                Route::post('/product-data-menu/reorder', [ProductDataMenuController::class, 'reorder'])
                    ->name('product-data-menu.reorder');

                Route::get('/product-data-menu/{productDataMenuItem}/edit', [ProductDataMenuController::class, 'edit'])
                    ->name('product-data-menu.edit');

                Route::put('/product-data-menu/{productDataMenuItem}', [ProductDataMenuController::class, 'update'])
                    ->name('product-data-menu.update');

                Route::delete('/product-data-menu/{productDataMenuItem}', [ProductDataMenuController::class, 'destroy'])
                    ->name('product-data-menu.destroy');

                Route::get('/gallery-menu', [GalleryMenuController::class, 'index'])
                    ->name('gallery-menu.index');

                Route::get('/gallery-menu/create', [GalleryMenuController::class, 'create'])
                    ->name('gallery-menu.create');

                Route::post('/gallery-menu', [GalleryMenuController::class, 'store'])
                    ->name('gallery-menu.store');

                Route::post('/gallery-menu/reorder', [GalleryMenuController::class, 'reorder'])
                    ->name('gallery-menu.reorder');

                Route::get('/gallery-menu/{galleryMenuItem}/edit', [GalleryMenuController::class, 'edit'])
                    ->name('gallery-menu.edit');

                Route::put('/gallery-menu/{galleryMenuItem}', [GalleryMenuController::class, 'update'])
                    ->name('gallery-menu.update');

                Route::delete('/gallery-menu/{galleryMenuItem}', [GalleryMenuController::class, 'destroy'])
                    ->name('gallery-menu.destroy');

                Route::get('/custom-page-menu', [CustomPageMenuController::class, 'index'])
                    ->name('custom-page-menu.index');

                Route::get('/custom-page-menu/create', [CustomPageMenuController::class, 'create'])
                    ->name('custom-page-menu.create');

                Route::post('/custom-page-menu', [CustomPageMenuController::class, 'store'])
                    ->name('custom-page-menu.store');

                Route::post('/custom-page-menu/reorder', [CustomPageMenuController::class, 'reorder'])
                    ->name('custom-page-menu.reorder');

                Route::get('/custom-page-menu/{customPageMenuItem}/edit', [CustomPageMenuController::class, 'edit'])
                    ->name('custom-page-menu.edit');

                Route::put('/custom-page-menu/{customPageMenuItem}', [CustomPageMenuController::class, 'update'])
                    ->name('custom-page-menu.update');

                Route::delete('/custom-page-menu/{customPageMenuItem}', [CustomPageMenuController::class, 'destroy'])
                    ->name('custom-page-menu.destroy');

                Route::get('/user-manual-menu', [UserManualMenuController::class, 'index'])
                    ->name('user-manual-menu.index');

                Route::get('/user-manual-menu/create', [UserManualMenuController::class, 'create'])
                    ->name('user-manual-menu.create');

                Route::post('/user-manual-menu', [UserManualMenuController::class, 'store'])
                    ->name('user-manual-menu.store');

                Route::post('/user-manual-menu/reorder', [UserManualMenuController::class, 'reorder'])
                    ->name('user-manual-menu.reorder');

                Route::get('/user-manual-menu/{userManualMenuItem}/edit', [UserManualMenuController::class, 'edit'])
                    ->name('user-manual-menu.edit');

                Route::put('/user-manual-menu/{userManualMenuItem}', [UserManualMenuController::class, 'update'])
                    ->name('user-manual-menu.update');

                Route::delete('/user-manual-menu/{userManualMenuItem}', [UserManualMenuController::class, 'destroy'])
                    ->name('user-manual-menu.destroy');

                Route::get('/side-menu/products', [ProductSideMenuController::class, 'index'])
                    ->name('side-menu.products.index');

                Route::get('/side-menu/products/create', [ProductSideMenuController::class, 'create'])
                    ->name('side-menu.products.create');

                Route::post('/side-menu/products', [ProductSideMenuController::class, 'store'])
                    ->name('side-menu.products.store');

                Route::post('/side-menu/products/reorder', [ProductSideMenuController::class, 'reorder'])
                    ->name('side-menu.products.reorder');

                Route::get('/side-menu/products/{productSideMenuItem}/edit', [ProductSideMenuController::class, 'edit'])
                    ->name('side-menu.products.edit');

                Route::put('/side-menu/products/{productSideMenuItem}', [ProductSideMenuController::class, 'update'])
                    ->name('side-menu.products.update');

                Route::delete('/side-menu/products/{productSideMenuItem}', [ProductSideMenuController::class, 'destroy'])
                    ->name('side-menu.products.destroy');

                Route::get('/side-menu/links', [SideMenuLinkController::class, 'index'])
                    ->name('side-menu.links.index');

                Route::get('/side-menu/links/create', [SideMenuLinkController::class, 'create'])
                    ->name('side-menu.links.create');

                Route::post('/side-menu/links', [SideMenuLinkController::class, 'store'])
                    ->name('side-menu.links.store');

                Route::post('/side-menu/links/reorder', [SideMenuLinkController::class, 'reorder'])
                    ->name('side-menu.links.reorder');

                Route::get('/side-menu/links/{sideMenuLink}/edit', [SideMenuLinkController::class, 'edit'])
                    ->name('side-menu.links.edit');

                Route::put('/side-menu/links/{sideMenuLink}', [SideMenuLinkController::class, 'update'])
                    ->name('side-menu.links.update');

                Route::delete('/side-menu/links/{sideMenuLink}', [SideMenuLinkController::class, 'destroy'])
                    ->name('side-menu.links.destroy');

                Route::get('/home-settings/products', [HomeProductSettingController::class, 'index'])
                    ->name('home-settings.products.index');

                Route::get('/home-settings/products/create', [HomeProductSettingController::class, 'create'])
                    ->name('home-settings.products.create');

                Route::post('/home-settings/products', [HomeProductSettingController::class, 'store'])
                    ->name('home-settings.products.store');

                Route::post('/home-settings/products/reorder', [HomeProductSettingController::class, 'reorder'])
                    ->name('home-settings.products.reorder');

                Route::get('/home-settings/products/{homeProductCard}/edit', [HomeProductSettingController::class, 'edit'])
                    ->name('home-settings.products.edit');

                Route::put('/home-settings/products/{homeProductCard}', [HomeProductSettingController::class, 'update'])
                    ->name('home-settings.products.update');

                Route::delete('/home-settings/products/{homeProductCard}', [HomeProductSettingController::class, 'destroy'])
                    ->name('home-settings.products.destroy');

                Route::get('/home-settings/banners', [HomeBannerSettingController::class, 'index'])
                    ->name('home-settings.banners.index');

                Route::get('/home-settings/banners/create', [HomeBannerSettingController::class, 'create'])
                    ->name('home-settings.banners.create');

                Route::post('/home-settings/banners', [HomeBannerSettingController::class, 'store'])
                    ->name('home-settings.banners.store');

                Route::post('/home-settings/banners/reorder', [HomeBannerSettingController::class, 'reorder'])
                    ->name('home-settings.banners.reorder');

                Route::get('/home-settings/banners/{homeBanner}/edit', [HomeBannerSettingController::class, 'edit'])
                    ->name('home-settings.banners.edit');

                Route::put('/home-settings/banners/{homeBanner}', [HomeBannerSettingController::class, 'update'])
                    ->name('home-settings.banners.update');

                Route::delete('/home-settings/banners/{homeBanner}', [HomeBannerSettingController::class, 'destroy'])
                    ->name('home-settings.banners.destroy');

                Route::get('/home-settings/notification', [HomeNotificationSettingController::class, 'edit'])
                    ->name('home-settings.notification.edit');

                Route::put('/home-settings/notification', [HomeNotificationSettingController::class, 'update'])
                    ->name('home-settings.notification.update');

                Route::get(
                    '/product-data/{productDataPage}/content',
                    function (ProductDataPage $productDataPage) {
                        return view('admin.products.content', [
                            'product' => $productDataPage,
                            'contentEditorMode' => 'product_data',
                            'contentApiBase' => '/api/v1/admin/product-data',
                            'contentIndexUrl' => route('admin.product-data.index'),
                        ]);
                    }
                )
                    ->name('product-data.content');

                Route::post('/product-data/{productDataPage}/content/preview', \App\Http\Controllers\Admin\ProductDataContentPreviewController::class)
                    ->name('product-data.content.preview');

                /*
                |--------------------------------------------------------------------------
                | Custom Page Layouts and Pages
                |--------------------------------------------------------------------------
                */

                Route::get(
                    '/custom-page-layouts',
                    function () {
                        return view('admin.product-layouts.index', [
                            'layoutManagerTitle' => 'Custom Page Layouts',
                            'layoutManagerDescription' => 'Create reusable layouts for standalone custom pages.',
                            'layoutManagerApiBase' => '/api/v1/admin/custom-page-layouts',
                            'layoutManagerBuilderBase' => '/admin/custom-page-layouts',
                            'layoutManagerUsageLabel' => 'Custom Pages',
                            'layoutManagerUsageField' => 'pages_count',
                            'layoutManagerPlaceholder' => 'Layout for custom pages',
                        ]);
                    }
                )
                    ->name('custom-page-layouts.index');

                Route::get(
                    '/custom-page-layouts/{customPageLayout}/builder',
                    function (CustomPageLayout $customPageLayout) {
                        return view('admin.product-layouts.builder', [
                            'productLayout' => $customPageLayout,
                            'layoutBuilderMode' => 'custom_page',
                            'layoutBuilderApiBase' => '/api/v1/admin/custom-page-layouts',
                            'layoutBuilderIndexUrl' => route('admin.custom-page-layouts.index'),
                        ]);
                    }
                )
                    ->name('custom-page-layouts.builder');

                Route::view(
                    '/custom-pages',
                    'admin.product-data.index',
                    [
                        'pageManagerEntity' => 'Custom Page',
                        'pageManagerEntityPlural' => 'Custom Pages',
                        'pageManagerTitle' => 'Custom Pages',
                        'pageManagerDescription' => 'Manage standalone pages and assign a Custom Page Layout.',
                        'pageManagerApiBase' => '/api/v1/admin/custom-pages',
                        'pageManagerLayoutApiBase' => '/api/v1/admin/custom-page-layouts',
                        'pageManagerLayoutBuilderBase' => '/admin/custom-page-layouts',
                        'pageManagerContentBase' => '/admin/custom-pages',
                        'pageManagerPreviewBase' => '',
                        'pageManagerLayoutField' => 'custom_page_layout_id',
                        'pageManagerSlugPlaceholder' => '/howtodesign',
                        'pageManagerSlugHelp' => 'Public path, for example /howtodesign. Leading and trailing slashes are normalized automatically.',
                    ]
                )
                    ->name('custom-pages.index');

                Route::get(
                    '/custom-pages/{customPage}/content',
                    function (CustomPage $customPage) {
                        return view('admin.products.content', [
                            'product' => $customPage,
                            'contentEditorMode' => 'custom_page',
                            'contentApiBase' => '/api/v1/admin/custom-pages',
                            'contentIndexUrl' => route('admin.custom-pages.index'),
                        ]);
                    }
                )
                    ->name('custom-pages.content');

                Route::post('/custom-pages/{customPage}/content/preview', \App\Http\Controllers\Admin\CustomPageContentPreviewController::class)
                    ->name('custom-pages.content.preview');

                /*
                |--------------------------------------------------------------------------
                | Guide Layouts and Pages
                |--------------------------------------------------------------------------
                */

                Route::get(
                    '/guide-main',
                    function () {
                        return view('admin.guides.main');
                    }
                )
                    ->name('guide-main.index');

                Route::get(
                    '/guide-layouts',
                    function () {
                        return view('admin.product-layouts.index', [
                            'layoutManagerTitle' => 'Guide Layouts',
                            'layoutManagerDescription' => 'Create reusable layouts for guide pages.',
                            'layoutManagerApiBase' => '/api/v1/admin/guide-layouts',
                            'layoutManagerBuilderBase' => '/admin/guide-layouts',
                            'layoutManagerUsageLabel' => 'Guides',
                            'layoutManagerUsageField' => 'pages_count',
                            'layoutManagerPlaceholder' => 'Layout for guide pages',
                        ]);
                    }
                )
                    ->name('guide-layouts.index');

                Route::get(
                    '/guide-layouts/{guideLayout}/builder',
                    function (GuideLayout $guideLayout) {
                        return view('admin.product-layouts.builder', [
                            'productLayout' => $guideLayout,
                            'layoutBuilderMode' => 'guide',
                            'layoutBuilderApiBase' => '/api/v1/admin/guide-layouts',
                            'layoutBuilderIndexUrl' => route('admin.guide-layouts.index'),
                        ]);
                    }
                )
                    ->name('guide-layouts.builder');

                Route::view(
                    '/guides',
                    'admin.product-data.index',
                    [
                        'pageManagerEntity' => 'Guide',
                        'pageManagerEntityPlural' => 'Guides',
                        'pageManagerTitle' => 'Guides',
                        'pageManagerDescription' => 'Manage guide pages and assign a Guide Layout.',
                        'pageManagerApiBase' => '/api/v1/admin/guides',
                        'pageManagerLayoutApiBase' => '/api/v1/admin/guide-layouts',
                        'pageManagerLayoutBuilderBase' => '/admin/guide-layouts',
                        'pageManagerContentBase' => '/admin/guides',
                        'pageManagerPreviewBase' => '/guide',
                        'pageManagerLayoutField' => 'guide_layout_id',
                        'pageManagerSlugPlaceholder' => 'how-to-design',
                        'pageManagerSlugHelp' => 'Public path: /guide/{slug}. Leading and trailing slashes are normalized automatically.',
                    ]
                )
                    ->name('guides.index');

                Route::get(
                    '/guides/{guidePage}/content',
                    function (GuidePage $guidePage) {
                        return view('admin.products.content', [
                            'product' => $guidePage,
                            'contentEditorMode' => 'guide',
                            'contentApiBase' => '/api/v1/admin/guides',
                            'contentIndexUrl' => route('admin.guides.index'),
                        ]);
                    }
                )
                    ->name('guides.content');

                Route::post('/guides/{guidePage}/content/preview', \App\Http\Controllers\Admin\GuideContentPreviewController::class)
                    ->name('guides.content.preview');

                /*
                |--------------------------------------------------------------------------
                | Logout
                |--------------------------------------------------------------------------
                */

                Route::post(
                    '/logout',
                    [
                        AuthController::class,
                        'logout',
                    ]
                )
                    ->name('logout');

            });

    });

Route::get('/gallery/{galleryPage}', [StorefrontGalleryController::class, 'show'])
    ->where('galleryPage', '[a-z0-9]+(?:[_-][a-z0-9]+)*')
    ->name('gallery.show');

/*
|--------------------------------------------------------------------------
| Legacy Product Endpoints
|--------------------------------------------------------------------------
|
| Endpoint พวกนี้ยังเก็บไว้ก่อน
|
| เพราะอาจจะยังถูกใช้งานโดย:
|
| - Shipping Schedule
| - Holiday
| - Sample Date
| - Paper Preview
| - Order Form
|
| แต่ Route:
|
| /products/rubberstrap
|
| ตัวเก่าจะไม่ใช้อีกแล้ว
|
*/

/*
|--------------------------------------------------------------------------
| Rubber Strap Delivery Schedule
|--------------------------------------------------------------------------
*/

Route::get(
    '/products/getdate_disp2023-rubber',
    [
        ProductController::class,
        'deliveryScheduleRubber',
    ]
)
    ->name('products.rubberstrap.schedule');

/*
|--------------------------------------------------------------------------
| Holiday
|--------------------------------------------------------------------------
*/

Route::match(
    [
        'get',
        'post',
    ],
    '/products/check_holiday.php',
    [
        ProductController::class,
        'checkHoliday',
    ]
)
    ->name('products.holiday');

/*
|--------------------------------------------------------------------------
| Sample Date
|--------------------------------------------------------------------------
*/

Route::match(
    [
        'get',
        'post',
    ],
    '/products/get_sample_date.php',
    [
        ProductController::class,
        'getSampleDate',
    ]
)
    ->name('products.sample-date');

/*
|--------------------------------------------------------------------------
| Paper Preview
|--------------------------------------------------------------------------
*/

Route::get(
    '/products/paper_preview.php',
    [
        ProductController::class,
        'paperPreview',
    ]
)
    ->name('products.paper-preview');

/*
|--------------------------------------------------------------------------
| Rubber Strap Part
|--------------------------------------------------------------------------
|
| ตอนทำ Order Form ค่อยกลับมาดูว่าตัวนี้
| ยังจำเป็นต้องใช้หรือสามารถย้ายเข้า Laravel ใหม่ได้
|
*/

Route::get(
    '/products/rubberstrap/part.php',
    [
        ProductController::class,
        'rubberstrapPart',
    ]
)
    ->name('products.rubberstrap.part');

/*
|--------------------------------------------------------------------------
| Temporary Legacy Endpoints
|--------------------------------------------------------------------------
*/

Route::get(
    '/info/index.php',
    [HomeNotificationController::class, 'show']
)
    ->name('home-notification.show');

Route::get(
    '/get_data_review.php',
    ReviewImportController::class
)
    ->name('reviews.import');

Route::get(
    '/reviews',
    [
        ReviewController::class,
        'index',
    ]
)
    ->name('reviews.index');

Route::get(
    '/get_review.php',
    [
        ReviewController::class,
        'feed',
    ]
)
    ->name('reviews.feed');

Route::get(
    '/getLang',
    [
        LegacyMockController::class,
        'language',
    ]
)
    ->name('legacy-mock.language');

/*
|--------------------------------------------------------------------------
| Storefront Products
|--------------------------------------------------------------------------
|
| Dynamic Product Page
|
| ใช้ Product.slug
|
| Examples:
|
| /products/rubberstrap
| /products/acrylickeyholder
| /products/candy-seal
| /products/xxxxx
|
| สำคัญ:
|
| Route นี้ต้องอยู่หลัง Specific Product Routes
| เพราะเป็น Dynamic Route
|
*/

/*
|--------------------------------------------------------------------------
| Dynamic Storefront Product
|--------------------------------------------------------------------------
|
| รองรับ:
|
| /products/rubberstrap
| /products/acrylic/figure
| /products/acrylic/keyholder
| /products/category/subcategory/product
|
| ต้องอยู่ท้าย Product Routes
|
*/

Route::post(
    '/products/{productPath}/estimate/pdf',
    [
        StorefrontProductController::class,
        'estimatePdf',
    ]
)
    ->where(
        'productPath',
        '.+'
    )
    ->name(
        'products.estimate.pdf'
    );

Route::post(
    '/products/{productPath}/order/customer',
    [
        StorefrontProductController::class,
        'storeCustomerOrder',
    ]
)
    ->where(
        'productPath',
        '.+'
    )
    ->name(
        'products.customer.store'
    );

Route::post(
    '/products/{productPath}/order/customer/details',
    [
        StorefrontProductController::class,
        'storeCustomerDetails',
    ]
)
    ->where(
        'productPath',
        '.+'
    )
    ->name(
        'products.customer.submit'
    );

Route::get(
    '/products/{productPath}/order/customer',
    [
        StorefrontProductController::class,
        'customerDetails',
    ]
)
    ->where(
        'productPath',
        '.+'
    )
    ->name(
        'products.customer'
    );

Route::get(
    '/products/{productPath}/order/confirm',
    [
        StorefrontProductController::class,
        'confirmOrder',
    ]
)
    ->where(
        'productPath',
        '.+'
    )
    ->name(
        'products.confirm'
    );

Route::post(
    '/products/{productPath}/order/complete',
    [
        StorefrontProductController::class,
        'completeOrder',
    ]
)
    ->where(
        'productPath',
        '.+'
    )
    ->name(
        'products.complete'
    );

Route::get(
    '/products/{productPath}',
    [
        StorefrontProductController::class,
        'show',
    ]
)
    ->where(
        'productPath',
        '.+'
    )
    ->name(
        'products.show'
    );

Route::view('/faq', 'faq.index')
    ->name('faq.index');

Route::get(
    '/faq/{category}',
    [
        FaqController::class,
        'categoryShow',
    ]
)
    ->where(
        'category',
        'order|delivery|payment'
    )
    ->name('faq.category.show');

Route::get(
    '/faq/product',
    [
        FaqController::class,
        'productIndex',
    ]
)
    ->name('faq.product');

Route::get(
    '/faq/product/{product:slug}',
    [
        FaqController::class,
        'productShow',
    ]
)
    ->name('faq.product.show');

Route::get(
    '/guide',
    [
        StorefrontGuideController::class,
        'index',
    ]
)
    ->name('guides.index');

Route::get('/news', [StorefrontNewsController::class, 'index'])
    ->name('news.index');

Route::get('/news.php', [StorefrontNewsController::class, 'index'])
    ->name('news.legacy.index');

Route::get('/acrylic_news.php', [StorefrontNewsController::class, 'acrylicIndex'])
    ->name('news.acrylic.legacy');

Route::get('/news-detail.php', [StorefrontNewsController::class, 'legacyShow'])
    ->name('news.legacy.show');

Route::get('/news/{news}', [StorefrontNewsController::class, 'show'])
    ->whereNumber('news')
    ->name('news.show');

Route::get(
    '/meeting_date',
    [StorefrontMeetingDateController::class, 'index']
)
    ->name('meeting-date.index');

Route::get(
    '/meeting_date/index.php',
    [StorefrontMeetingDateController::class, 'index']
)
    ->name('meeting-date.legacy.index');

Route::post(
    '/meeting_date/confirm',
    [StorefrontMeetingDateController::class, 'confirm']
)
    ->name('meeting-date.confirm');

Route::post(
    '/meeting_date/complete',
    [StorefrontMeetingDateController::class, 'complete']
)
    ->name('meeting-date.complete');

Route::get(
    '/contact',
    [
        StorefrontContactController::class,
        'index',
    ]
)
    ->name('contact.index');

Route::get(
    '/contact/index.php',
    [
        StorefrontContactController::class,
        'index',
    ]
)
    ->name('contact.legacy.index');

Route::get(
    '/contact.php',
    [
        StorefrontContactController::class,
        'index',
    ]
)
    ->name('contact.legacy');

Route::post(
    '/contact/confirm',
    [
        StorefrontContactController::class,
        'confirm',
    ]
)
    ->name('contact.confirm');

Route::post(
    '/contact/complete',
    [
        StorefrontContactController::class,
        'complete',
    ]
)
    ->name('contact.complete');

Route::get(
    '/guide/{guidePath}',
    [
        StorefrontGuideController::class,
        'show',
    ]
)
    ->where('guidePath', '[A-Za-z0-9][A-Za-z0-9_.-]*(?:/[A-Za-z0-9][A-Za-z0-9_.-]*)*')
    ->name('guides.show');

Route::get(
    '/{customPagePath}',
    [
        StorefrontCustomPageController::class,
        'show',
    ]
)
    ->where('customPagePath', '[A-Za-z0-9][A-Za-z0-9_.-]*(?:/[A-Za-z0-9][A-Za-z0-9_.-]*)*')
    ->name('custom-pages.show');

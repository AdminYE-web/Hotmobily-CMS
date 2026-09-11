<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OtpController;
use App\Http\Controllers\Admin\OptionGroupController;
use App\Http\Controllers\Admin\OptionDependencyController;
use App\Http\Controllers\Admin\OptionPriceRuleController;
use App\Http\Controllers\Admin\ProductOptionController;
use App\Http\Controllers\Admin\ProductOptionManagerController;
use App\Http\Controllers\Admin\ProductPriceRuleController;
use App\Http\Controllers\Admin\ReviewAnswerController as AdminReviewAnswerController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Storefront\FaqController;
use App\Http\Controllers\Storefront\ProductController as StorefrontProductController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\LegacyMockController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\ReviewController;
use App\Http\Controllers\Web\ReviewImportController;
use App\Models\Product;
use App\Models\ProductLayout;
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
    [
        LegacyMockController::class,
        'info',
    ]
)
    ->name('legacy-mock.info');

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

<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\OtpController;
use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\LegacyMockController;
use App\Http\Controllers\Web\ProductController;

use App\Http\Controllers\Storefront\ProductController as StorefrontProductController;

use App\Models\Product;
use App\Models\ProductLayout;


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
                        'showLogin'
                    ]
                )
                ->name('login');


                Route::post(
                    '/login',
                    [
                        AuthController::class,
                        'login'
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
                        'show'
                    ]
                )
                ->name('otp');


                Route::post(
                    '/login/verify',
                    [
                        OtpController::class,
                        'verify'
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
                        'index'
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
                        'logout'
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
        'deliveryScheduleRubber'
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
        'post'
    ],
    '/products/check_holiday.php',
    [
        ProductController::class,
        'checkHoliday'
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
        'post'
    ],
    '/products/get_sample_date.php',
    [
        ProductController::class,
        'getSampleDate'
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
        'paperPreview'
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
        'rubberstrapPart'
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
        'info'
    ]
)
->name('legacy-mock.info');


Route::get(
    '/get_review.php',
    [
        LegacyMockController::class,
        'reviews'
    ]
)
->name('legacy-mock.reviews');


Route::get(
    '/getLang',
    [
        LegacyMockController::class,
        'language'
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
        'show'
    ]
)
->where(
    'productPath',
    '.+'
)
->name(
    'products.show'
);
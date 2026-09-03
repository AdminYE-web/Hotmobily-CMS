<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\OtpController;
use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\LegacyMockController;
use App\Http\Controllers\Web\ProductController;

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


                Route::get(
                    '/login',
                    [AuthController::class, 'showLogin']
                )
                ->name('login');


                Route::post(
                    '/login',
                    [AuthController::class, 'login']
                )
                ->name('login.submit');


                Route::get(
                    '/login/verify',
                    [OtpController::class, 'show']
                )
                ->name('otp');


                Route::post(
                    '/login/verify',
                    [OtpController::class, 'verify']
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
                    [DashboardController::class, 'index']
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
                 * Legacy / old Product Builder
                 *
                 * ถ้ายังใช้อยู่เก็บไว้ได้
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
                | URL:
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
                | URL:
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
                    [AuthController::class, 'logout']
                )
                ->name('logout');


            });


    });


/*
|--------------------------------------------------------------------------
| Products: Rubber Strap
|--------------------------------------------------------------------------
*/

Route::get(
    '/products/rubberstrap',
    [ProductController::class, 'rubberstrap']
)
->name('products.rubberstrap');


Route::get(
    '/products/getdate_disp2023-rubber',
    [ProductController::class, 'deliveryScheduleRubber']
)
->name('products.rubberstrap.schedule');


Route::match(
    ['get', 'post'],
    '/products/check_holiday.php',
    [ProductController::class, 'checkHoliday']
)
->name('products.holiday');


Route::match(
    ['get', 'post'],
    '/products/get_sample_date.php',
    [ProductController::class, 'getSampleDate']
)
->name('products.sample-date');


Route::get(
    '/products/paper_preview.php',
    [ProductController::class, 'paperPreview']
)
->name('products.paper-preview');


Route::get(
    '/products/rubberstrap/part.php',
    [ProductController::class, 'rubberstrapPart']
)
->name('products.rubberstrap.part');


/*
|--------------------------------------------------------------------------
| Temporary Legacy Endpoints
|--------------------------------------------------------------------------
*/

Route::get(
    '/info/index.php',
    [LegacyMockController::class, 'info']
)
->name('legacy-mock.info');


Route::get(
    '/get_review.php',
    [LegacyMockController::class, 'reviews']
)
->name('legacy-mock.reviews');


Route::get(
    '/getLang',
    [LegacyMockController::class, 'language']
)
->name('legacy-mock.language');
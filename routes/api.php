<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Api\V1\AdminAuthController;
use App\Http\Controllers\Api\V1\HolidayController;

use App\Http\Controllers\Api\V1\Admin\ProductController;
use App\Http\Controllers\Api\V1\Admin\ProductPageController;
use App\Http\Controllers\Api\V1\Admin\ProductLayoutController;
use App\Http\Controllers\Api\V1\Admin\FaqController;
use App\Http\Controllers\Api\V1\Admin\FaqImageController;


/*
|--------------------------------------------------------------------------
| API Version 1
|--------------------------------------------------------------------------
|
| Base URL:
|
| /api/v1/...
|
*/

Route::prefix('v1')->group(function () {


    /*
    |--------------------------------------------------------------------------
    | Public API
    |--------------------------------------------------------------------------
    |
    | API กลุ่มนี้ไม่ต้อง Login
    |
    */


    /*
    |--------------------------------------------------------------------------
    | Public Product
    |--------------------------------------------------------------------------
    |
    | GET /api/v1/products/rubberstrap
    |
    | คืนข้อมูล Product
    |
    */

    Route::get(
        '/products/{productPath}',
        [
            ProductController::class,
            'show'
        ]
    )
        ->where(
            'productPath',
            '.+'
        );


    /*
    |--------------------------------------------------------------------------
    | Public Product Page
    |--------------------------------------------------------------------------
    |
    | GET /api/v1/products/rubberstrap/page
    |
    | คืน:
    |
    | - Product
    | - Product Layout ที่ Publish แล้ว
    | - Product Content ที่ Publish แล้ว
    |
    */

    Route::get(
        '/products/{product:slug}/page',
        [
            ProductPageController::class,
            'show'
        ]
    );


    /*
    |--------------------------------------------------------------------------
    | Public Holiday
    |--------------------------------------------------------------------------
    |
    | GET /api/v1/holidays
    |
    | ตัวอย่าง:
    |
    | /api/v1/holidays
    |
    | /api/v1/holidays
    | ?from=2026-09-01
    | &to=2026-10-31
    | &calendar_type=normal
    |
    */

    Route::get(
        '/holidays',
        [
            HolidayController::class,
            'index'
        ]
    );


    /*
    |--------------------------------------------------------------------------
    | Admin Login
    |--------------------------------------------------------------------------
    |
    | POST /api/v1/admin/login
    |
    | ใช้ได้สำหรับ Mobile App ในอนาคต
    |
    */

    Route::post(
        '/admin/login',
        [
            AdminAuthController::class,
            'login'
        ]
    );


    /*
    |--------------------------------------------------------------------------
    | Protected API
    |--------------------------------------------------------------------------
    |
    | ต้อง Login ผ่าน Sanctum
    |
    | Web Admin:
    |   Session / Cookie
    |
    | Mobile App:
    |   Bearer Token
    |
    */

    Route::middleware('auth:sanctum')
        ->group(function () {

            /*
            |--------------------------------------------------------------------------
            | Admin Logout
            |--------------------------------------------------------------------------
            */

            Route::post(
                '/admin/logout',
                [
                    AdminAuthController::class,
                    'logout'
                ]
            );


            /*
            |--------------------------------------------------------------------------
            | Holiday Management
            |--------------------------------------------------------------------------
            |
            | เราคง URL เดิมไว้
            | เพราะหน้า Holiday Admin ใช้อยู่แล้ว
            |
            */


            /*
             * Create Holiday
             *
             * POST /api/v1/holidays
             */
            Route::post(
                '/holidays',
                [
                    HolidayController::class,
                    'store'
                ]
            );


            /*
             * Holiday Detail
             *
             * GET /api/v1/holidays/1
             */
            Route::get(
                '/holidays/{holiday}',
                [
                    HolidayController::class,
                    'show'
                ]
            );


            /*
             * Update Holiday
             *
             * PUT /api/v1/holidays/1
             */
            Route::put(
                '/holidays/{holiday}',
                [
                    HolidayController::class,
                    'update'
                ]
            );


            /*
             * Delete Holiday
             *
             * DELETE /api/v1/holidays/1
             */
            Route::delete(
                '/holidays/{holiday}',
                [
                    HolidayController::class,
                    'destroy'
                ]
            );


            /*
            |--------------------------------------------------------------------------
            | Admin API
            |--------------------------------------------------------------------------
            |
            | ทุกอย่างด้านล่างจะขึ้นต้นด้วย
            |
            | /api/v1/admin/...
            |
            */

            Route::prefix('admin')
                ->group(function () {

                /*
|--------------------------------------------------------------------------
| FAQ Management
|--------------------------------------------------------------------------
|
| GET     /api/v1/admin/faqs
| POST    /api/v1/admin/faqs
| GET     /api/v1/admin/faqs/1
| PUT     /api/v1/admin/faqs/1
| DELETE  /api/v1/admin/faqs/1
|
*/


/*
 * FAQ List
 *
 * GET /api/v1/admin/faqs
 */
Route::get(
    '/faqs',
    [
        FaqController::class,
        'index'
    ]
);


/*
 * Create FAQ
 *
 * POST /api/v1/admin/faqs
 */
Route::post(
    '/faqs',
    [
        FaqController::class,
        'store'
    ]
);


/*
 * Upload FAQ Image
 *
 * POST /api/v1/admin/faqs/upload-image
 */
Route::post(
    '/faqs/upload-image',
    [
        FaqImageController::class,
        'store'
    ]
);


/*
 * FAQ Detail
 *
 * GET /api/v1/admin/faqs/1
 */
Route::get(
    '/faqs/{faq}',
    [
        FaqController::class,
        'show'
    ]
);


/*
 * Update FAQ
 *
 * PUT /api/v1/admin/faqs/1
 */
Route::put(
    '/faqs/{faq}',
    [
        FaqController::class,
        'update'
    ]
);


/*
 * Delete FAQ
 *
 * DELETE /api/v1/admin/faqs/1
 */
Route::delete(
    '/faqs/{faq}',
    [
        FaqController::class,
        'destroy'
    ]
);
                    /*
             |--------------------------------------------------------------------------
             | Product Image Upload
              |--------------------------------------------------------------------------
              |
               | POST /api/v1/admin/products/1/images
                 |
                */

                    Route::post(
                        '/products/{product}/images',
                        [
                            ProductPageController::class,
                            'uploadImage'
                        ]
                    );


                    Route::post(
                        '/products/{product}/templates',
                        [
                            ProductPageController::class,
                            'uploadTemplate'
                        ]
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Product Layout Management
                    |--------------------------------------------------------------------------
                    |
                    | Layout = โครงสร้างหน้า
                    |
                    | ตัวอย่าง:
                    |
                    | Product Default
                    | ├── Product Header
                    | ├── Gallery 50%
                    | ├── Product Detail 50%
                    | ├── Info Card
                    | ├── Shipping
                    | └── Production
                    |
                    */


                    /*
                     * Layout List
                     *
                     * GET /api/v1/admin/product-layouts
                     */
                    Route::get(
                        '/product-layouts',
                        [
                            ProductLayoutController::class,
                            'index'
                        ]
                    );


                    /*
                     * Create Layout
                     *
                     * POST /api/v1/admin/product-layouts
                     */
                    Route::post(
                        '/product-layouts',
                        [
                            ProductLayoutController::class,
                            'store'
                        ]
                    );


                    /*
                     * Get Layout
                     *
                     * GET /api/v1/admin/product-layouts/1
                     */
                    Route::get(
                        '/product-layouts/{productLayout}',
                        [
                            ProductLayoutController::class,
                            'show'
                        ]
                    );


                    /*
                     * Update Layout Information
                     *
                     * เช่น:
                     *
                     * name
                     * slug
                     * description
                     *
                     * PUT /api/v1/admin/product-layouts/1
                     */
                    Route::put(
                        '/product-layouts/{productLayout}',
                        [
                            ProductLayoutController::class,
                            'update'
                        ]
                    );


                    /*
                     * Delete Layout
                     *
                     * DELETE /api/v1/admin/product-layouts/1
                     */
                    Route::delete(
                        '/product-layouts/{productLayout}',
                        [
                            ProductLayoutController::class,
                            'destroy'
                        ]
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Product Layout Builder
                    |--------------------------------------------------------------------------
                    */


                    /*
                     * Save Layout Draft
                     *
                     * PUT
                     * /api/v1/admin/product-layouts/1/layout
                     *
                     * Body:
                     *
                     * {
                     *     "blocks": [...]
                     * }
                     */
                    Route::put(
                        '/product-layouts/{productLayout}/layout',
                        [
                            ProductLayoutController::class,
                            'saveLayout'
                        ]
                    );


                    /*
                     * Publish Layout
                     *
                     * POST
                     * /api/v1/admin/product-layouts/1/publish
                     */
                    Route::post(
                        '/product-layouts/{productLayout}/publish',
                        [
                            ProductLayoutController::class,
                            'publish'
                        ]
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Product Management
                    |--------------------------------------------------------------------------
                    |
                    | Product จะเลือก Product Layout
                    |
                    | products.product_layout_id
                    |
                    */


                    /*
                     * Product List
                     *
                     * GET /api/v1/admin/products
                     */
                    Route::get(
                        '/products',
                        [
                            ProductController::class,
                            'index'
                        ]
                    );


                    /*
                     * Create Product
                     *
                     * POST /api/v1/admin/products
                     */
                    Route::post(
                        '/products',
                        [
                            ProductController::class,
                            'store'
                        ]
                    );


                    /*
                     * Product Detail
                     *
                     * GET /api/v1/admin/products/1
                     */
                    Route::get(
                        '/products/{product}',
                        [
                            ProductController::class,
                            'edit'
                        ]
                    );


                    /*
                     * Update Product
                     *
                     * PUT /api/v1/admin/products/1
                     */
                    Route::put(
                        '/products/{product}',
                        [
                            ProductController::class,
                            'update'
                        ]
                    );


                    /*
                     * Delete Product
                     *
                     * DELETE /api/v1/admin/products/1
                     */
                    Route::delete(
                        '/products/{product}',
                        [
                            ProductController::class,
                            'destroy'
                        ]
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Product Page Content
                    |--------------------------------------------------------------------------
                    |
                    | ตรงนี้ไม่ได้เก็บ Layout
                    |
                    | Layout อยู่ใน:
                    |
                    | product_layouts
                    |
                    | ตรงนี้เก็บข้อมูลของ Product เช่น:
                    |
                    | - Title
                    | - Gallery
                    | - Description
                    | - Banner
                    | - Link
                    | - Text
                    |
                    */


                    /*
                     * Load Product Content
                     *
                     * GET
                     * /api/v1/admin/products/1/page
                     */
                    Route::get(
                        '/products/{product}/page',
                        [
                            ProductPageController::class,
                            'edit'
                        ]
                    );


                    /*
                     * Save Product Content Draft
                     *
                     * PUT
                     * /api/v1/admin/products/1/page
                     */
                    Route::put(
                        '/products/{product}/page',
                        [
                            ProductPageController::class,
                            'update'
                        ]
                    );


                    /*
                     * Publish Product Content
                     *
                     * POST
                     * /api/v1/admin/products/1/page/publish
                     */
                    Route::post(
                        '/products/{product}/page/publish',
                        [
                            ProductPageController::class,
                            'publish'
                        ]
                    );
                });
        });
});

<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Product Page
    |--------------------------------------------------------------------------
    |
    | Example:
    |
    | /products/rubberstrap
    |
    | ใช้เฉพาะ:
    |
    | - Active Product
    | - Published Layout
    | - Published Content
    |
    | Draft จะไม่ถูกนำมาแสดงหน้าบ้าน
    |
    */

    public function show(
        Product $product
    ) {

        /*
        |--------------------------------------------------------------------------
        | Product Status
        |--------------------------------------------------------------------------
        */

        if (
            $product->status
            !==
            'active'
        ) {

            abort(404);

        }


        /*
        |--------------------------------------------------------------------------
        | Load Relations
        |--------------------------------------------------------------------------
        */

        $product->load([
            'layout',
            'page',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Published Layout
        |--------------------------------------------------------------------------
        */

        if (
            !$product->layout
            ||
            empty(
                $product
                    ->layout
                    ->published_layout_json
            )
        ) {

            abort(404);

        }


        /*
        |--------------------------------------------------------------------------
        | Published Content
        |--------------------------------------------------------------------------
        */

        if (
            !$product->page
            ||
            empty(
                $product
                    ->page
                    ->published_content_json
            )
        ) {

            abort(404);

        }


        /*
        |--------------------------------------------------------------------------
        | Data
        |--------------------------------------------------------------------------
        */

        $layout =
            $product
                ->layout
                ->published_layout_json;


        $content =
            $product
                ->page
                ->published_content_json;


        $blocks =
            $content['blocks']
            ??
            [];


        /*
        |--------------------------------------------------------------------------
        | Render
        |--------------------------------------------------------------------------
        */

        return view(
            'products.show',
            [
                'product' =>
                    $product,

                'layout' =>
                    $layout,

                'contents' =>
                    $blocks,

                'publishedAt' =>
                    $product
                        ->page
                        ->published_at,
            ]
        );
    }
}
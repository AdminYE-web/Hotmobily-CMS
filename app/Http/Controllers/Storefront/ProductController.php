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
    | Examples:
    |
    | /products/rubberstrap
    |
    | /products/acrylic/figure
    |
    | /products/acrylic/keyholder
    |
    */

    public function show(
        string $productPath
    ) {

        /*
        |--------------------------------------------------------------------------
        | Normalize Product Path
        |--------------------------------------------------------------------------
        */

        $productPath =
            trim(
                $productPath,
                '/'
            );


        /*
        |--------------------------------------------------------------------------
        | Find Product
        |--------------------------------------------------------------------------
        */

        $product = Product::query()
            ->where(
                'slug',
                $productPath
            )
            ->where(
                'status',
                'active'
            )
            ->firstOrFail();


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
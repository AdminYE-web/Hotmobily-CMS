<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductPage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Admin Product List
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $products = Product::query()
            ->with([
                'layout:id,name,slug,status',
                'page:id,product_id,published_at',
            ])
            ->latest()
            ->get();


        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $data = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | Slug / Product Path
            |--------------------------------------------------------------------------
            |
            | รองรับ:
            |
            | rubberstrap
            | acrylic/figure
            | acrylic/keyholder
            | printed/rubber/strap
            |
            | ไม่รองรับ:
            |
            | /acrylic/figure
            | acrylic//figure
            | acrylic/figure/
            | https://...
            |
            */

            'slug' => [
                'required',
                'string',
                'max:255',

                'regex:/^[a-zA-Z0-9][a-zA-Z0-9_-]*(\/[a-zA-Z0-9][a-zA-Z0-9_-]*)*$/',

                'unique:products,slug',
            ],

            'product_code' => [
                'nullable',
                'string',
                'max:100',
            ],

            'product_layout_id' => [
                'nullable',
                'integer',
                'exists:product_layouts,id',
            ],

            'status' => [
                'required',

                Rule::in([
                    'draft',
                    'active',
                    'inactive',
                ]),
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Normalize Slug
        |--------------------------------------------------------------------------
        */

        $data['slug'] =
            $this->normalizeProductSlug(
                $data['slug']
            );


        $product = Product::create(
            $data
        );


        ProductPage::create([

            'product_id' =>
                $product->id,

            'draft_content_json' => [
                'version' => 1,
                'blocks' => [],
            ],

        ]);


        return response()->json([

            'success' => true,

            'data' =>
                $product->load('layout'),

        ], 201);
    }


    /*
    |--------------------------------------------------------------------------
    | Admin Product Detail
    |--------------------------------------------------------------------------
    */

    public function edit(Product $product)
    {
        return response()->json([

            'success' => true,

            'data' =>
                $product->load([
                    'layout',
                    'page',
                ]),

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Product $product
    ) {
        $data = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [

                'required',
                'string',
                'max:255',

                'regex:/^[a-zA-Z0-9][a-zA-Z0-9_-]*(\/[a-zA-Z0-9][a-zA-Z0-9_-]*)*$/',

                Rule::unique(
                    'products',
                    'slug'
                )->ignore(
                    $product->id
                ),

            ],

            'product_code' => [
                'nullable',
                'string',
                'max:100',
            ],

            'product_layout_id' => [
                'nullable',
                'integer',
                'exists:product_layouts,id',
            ],

            'status' => [
                'required',

                Rule::in([
                    'draft',
                    'active',
                    'inactive',
                ]),
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Normalize Slug
        |--------------------------------------------------------------------------
        */

        $data['slug'] =
            $this->normalizeProductSlug(
                $data['slug']
            );


        $product->update(
            $data
        );


        $product->page()->firstOrCreate(
            [],
            [
                'draft_content_json' => [
                    'version' => 1,
                    'blocks' => [],
                ],
            ]
        );


        return response()->json([

            'success' => true,

            'data' =>
                $product
                    ->fresh()
                    ->load([
                        'layout',
                        'page',
                    ]),

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Product $product
    ) {
        $product->delete();


        return response()->json([
            'success' => true,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Public Product
    |--------------------------------------------------------------------------
    |
    | ตัวนี้ใช้ Product Path แทน Route Model Binding
    |
    | Example:
    |
    | /api/v1/products/rubberstrap
    | /api/v1/products/acrylic/figure
    |
    */

    public function show(
        string $productPath
    ) {
        $productPath =
            $this->normalizeProductSlug(
                $productPath
            );


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


        return response()->json([

            'success' => true,

            'data' => [

                'id' =>
                    $product->id,

                'name' =>
                    $product->name,

                'slug' =>
                    $product->slug,

                'url' =>
                    url(
                        '/products/'
                        .
                        $product->slug
                    ),

                'product_code' =>
                    $product->product_code,

            ],

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Normalize Product Slug
    |--------------------------------------------------------------------------
    */

    private function normalizeProductSlug(
        string $slug
    ): string {

        $slug =
            trim(
                $slug
            );


        /*
         * เผื่อ Admin กรอก:
         *
         * /products/acrylic/figure
         * products/acrylic/figure
         *
         * จะเก็บจริงเป็น:
         *
         * acrylic/figure
         */

        $slug =
            trim(
                $slug,
                '/'
            );


        if (
            str_starts_with(
                $slug,
                'products/'
            )
        ) {

            $slug =
                substr(
                    $slug,
                    strlen(
                        'products/'
                    )
                );

        }


        return trim(
            $slug,
            '/'
        );
    }
}
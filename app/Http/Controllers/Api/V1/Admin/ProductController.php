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

            'slug' => [
                'required',
                'alpha_dash',
                'max:255',
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
                'alpha_dash',
                'max:255',

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
    */

    public function show(Product $product)
    {
        if (
            $product->status !== 'active'
        ) {
            abort(404);
        }


        return response()->json([

            'success' => true,

            'data' => [

                'id' =>
                    $product->id,

                'name' =>
                    $product->name,

                'slug' =>
                    $product->slug,

                'product_code' =>
                    $product->product_code,

            ],

        ]);
    }
}
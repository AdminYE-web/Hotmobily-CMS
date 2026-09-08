<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductLayout;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductLayoutController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | List
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $layouts =
            ProductLayout::query()
                ->withCount('products')
                ->latest()
                ->get();


        return response()->json([
            'success' => true,
            'data' => $layouts,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request
    ) {
        $data =
            $request->validate([

                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'slug' => [
                    'required',
                    'alpha_dash',
                    'max:255',
                    'unique:product_layouts,slug',
                ],

                'description' => [
                    'nullable',
                    'string',
                    'max:500',
                ],

            ]);


        $layout =
            ProductLayout::create([

                'name' =>
                    $data['name'],

                'slug' =>
                    $data['slug'],

                'description' =>
                    $data['description']
                    ?? null,

                'status' =>
                    'draft',

                'draft_layout_json' => [

                    'version' =>
                        2,

                    'rows' =>
                        [],

                ],

            ]);


        return response()->json([

            'success' =>
                true,

            'data' =>
                $layout,

        ], 201);
    }


    /*
    |--------------------------------------------------------------------------
    | Show
    |--------------------------------------------------------------------------
    */

    public function show(
        ProductLayout $productLayout
    ) {
        return response()->json([

            'success' =>
                true,

            'data' =>
                $productLayout,

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Update Layout Information
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        ProductLayout $productLayout
    ) {
        $data =
            $request->validate([

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
                        'product_layouts',
                        'slug'
                    )->ignore(
                        $productLayout->id
                    ),

                ],

                'description' => [
                    'nullable',
                    'string',
                    'max:500',
                ],

            ]);


        $productLayout->update(
            $data
        );


        return response()->json([

            'success' =>
                true,

            'data' =>
                $productLayout->fresh(),

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Save Layout
    |--------------------------------------------------------------------------
    */

    public function saveLayout(
        Request $request,
        ProductLayout $productLayout
    ) {
        /*
        |--------------------------------------------------------------------------
        | Allowed top-level components
        |--------------------------------------------------------------------------
        */

        $allowedTypes = [

            'heading',

            'rich_text',

            'image',

            'button',

            /*
             * NEW
             */
            'text_link',

            /*
             * NEW
             */
            'custom_table',

            'info_card',

            'accordion',

            'option_card_grid',

            'product_header',

            'product_gallery',

            'product_details',

            'template_button',

            'price_accordion',

            'shipping_schedule',

            'production_schedule',

            'divider',

            'spacer',

        ];


        /*
        |--------------------------------------------------------------------------
        | Accordion child components
        |--------------------------------------------------------------------------
        |
        | Accordion ซ้อน Accordion ไม่ได้
        |
        */

        $allowedChildTypes = [

            'heading',

            'rich_text',

            'image',

            'button',

            /*
             * NEW
             */
            'text_link',

            /*
             * NEW
             */
            'custom_table',

            'info_card',

            'option_card_grid',

            'product_header',

            'product_gallery',

            'product_details',

            'template_button',

            'price_accordion',

            'shipping_schedule',

            'production_schedule',

            'divider',

            'spacer',

        ];


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $data =
            $request->validate([

                'rows' => [
                    'present',
                    'array',
                ],


                'rows.*.id' => [
                    'required',
                    'string',
                    'max:100',
                ],


                'rows.*.region' => [
                    'nullable',
                    Rule::in([
                        'before_order',
                        'after_order',
                    ]),
                ],


                'rows.*.columns' => [
                    'present',
                    'array',
                    'min:1',
                    'max:3',
                ],


                'rows.*.columns.*.id' => [
                    'required',
                    'string',
                    'max:100',
                ],


                'rows.*.columns.*.width' => [

                    'required',

                    'integer',

                    Rule::in([
                        4,
                        6,
                        8,
                        12,
                    ]),

                ],


                'rows.*.columns.*.blocks' => [
                    'present',
                    'array',
                ],


                'rows.*.columns.*.blocks.*.id' => [
                    'required',
                    'string',
                    'max:100',
                ],


                'rows.*.columns.*.blocks.*.type' => [

                    'required',

                    'string',

                    Rule::in(
                        $allowedTypes
                    ),

                ],


                'rows.*.columns.*.blocks.*.settings' => [
                    'present',
                    'array',
                ],


                'rows.*.columns.*.blocks.*.settings.custom_id' => [

                    'nullable',

                    'string',

                    'max:100',

                    'regex:/^[A-Za-z][A-Za-z0-9_-]*$/',

                ],


                'rows.*.columns.*.blocks.*.settings.content_width' => [

                    'nullable',

                    'integer',

                    Rule::in([
                        33,
                        50,
                        75,
                        100,
                    ]),

                ],


                'rows.*.columns.*.blocks.*.settings.alignment' => [

                    'nullable',

                    Rule::in([
                        'left',
                        'center',
                        'right',
                    ]),

                ],


                'rows.*.columns.*.blocks.*.settings.tag' => [

                    'nullable',

                    Rule::in([
                        'h1',
                        'h2',
                        'h3',
                    ]),

                ],


                'rows.*.columns.*.blocks.*.settings.height' => [

                    'nullable',

                    'integer',

                    'min:0',

                    'max:500',

                ],


                'rows.*.columns.*.blocks.*.settings.open_default' => [

                    'nullable',

                    'boolean',

                ],


                'rows.*.columns.*.blocks.*.settings.title' => [

                    'nullable',

                    'string',

                    'max:255',

                ],


                /*
                |--------------------------------------------------------------------------
                | Children
                |--------------------------------------------------------------------------
                */

                'rows.*.columns.*.blocks.*.children' => [

                    'nullable',

                    'array',

                    'max:50',

                ],


                'rows.*.columns.*.blocks.*.children.*.id' => [

                    'required',

                    'string',

                    'max:100',

                ],


                'rows.*.columns.*.blocks.*.children.*.type' => [

                    'required',

                    'string',

                    Rule::in(
                        $allowedChildTypes
                    ),

                ],


                'rows.*.columns.*.blocks.*.children.*.settings' => [

                    'present',

                    'array',

                ],


                'rows.*.columns.*.blocks.*.children.*.settings.custom_id' => [

                    'nullable',

                    'string',

                    'max:100',

                    'regex:/^[A-Za-z][A-Za-z0-9_-]*$/',

                ],


                'rows.*.columns.*.blocks.*.children.*.settings.content_width' => [

                    'nullable',

                    'integer',

                    Rule::in([
                        33,
                        50,
                        75,
                        100,
                    ]),

                ],


                'rows.*.columns.*.blocks.*.children.*.settings.alignment' => [

                    'nullable',

                    Rule::in([
                        'left',
                        'center',
                        'right',
                    ]),

                ],


                'rows.*.columns.*.blocks.*.children.*.settings.tag' => [

                    'nullable',

                    Rule::in([
                        'h1',
                        'h2',
                        'h3',
                    ]),

                ],


                'rows.*.columns.*.blocks.*.children.*.settings.height' => [

                    'nullable',

                    'integer',

                    'min:0',

                    'max:500',

                ],

            ]);


        $data['rows'] =
            array_map(
                static function (array $row): array {
                    $row['region'] =
                        ($row['region'] ?? null)
                        === 'after_order'
                            ? 'after_order'
                            : 'before_order';


                    return $row;
                },
                $data['rows']
            );


        /*
        |--------------------------------------------------------------------------
        | ID validation
        |--------------------------------------------------------------------------
        */

        $rowIds =
            [];


        $columnIds =
            [];


        $internalBlockIds =
            [];


        $effectiveBlockIds =
            [];


        foreach (
            $data['rows']
            as $row
        ) {

            /*
            |--------------------------------------------------------------------------
            | Row ID
            |--------------------------------------------------------------------------
            */

            if (
                isset(
                    $rowIds[
                        $row['id']
                    ]
                )
            ) {

                return response()->json([

                    'success' =>
                        false,

                    'message' =>
                        'Duplicate Row ID found: '
                        .
                        $row['id'],

                ], 422);

            }


            $rowIds[
                $row['id']
            ] =
                true;


            /*
            |--------------------------------------------------------------------------
            | Row width
            |--------------------------------------------------------------------------
            */

            $totalWidth =
                0;


            foreach (
                $row['columns']
                as $column
            ) {

                $totalWidth +=
                    (int)
                    $column['width'];


                /*
                |--------------------------------------------------------------------------
                | Column ID
                |--------------------------------------------------------------------------
                */

                if (
                    isset(
                        $columnIds[
                            $column['id']
                        ]
                    )
                ) {

                    return response()->json([

                        'success' =>
                            false,

                        'message' =>
                            'Duplicate Column ID found: '
                            .
                            $column['id'],

                    ], 422);

                }


                $columnIds[
                    $column['id']
                ] =
                    true;


                /*
                |--------------------------------------------------------------------------
                | Blocks
                |--------------------------------------------------------------------------
                */

                foreach (
                    $column['blocks']
                    as $block
                ) {

                    $error =
                        $this->registerBlockIds(

                            $block,

                            $internalBlockIds,

                            $effectiveBlockIds

                        );


                    if (
                        $error
                    ) {

                        return response()->json([

                            'success' =>
                                false,

                            'message' =>
                                $error,

                        ], 422);

                    }


                    /*
                     * Only accordion can contain children.
                     */
                    if (
                        $block['type']
                        !== 'accordion'
                        &&
                        !empty(
                            $block['children']
                            ?? []
                        )
                    ) {

                        return response()->json([

                            'success' =>
                                false,

                            'message' =>
                                'Only Accordion components may contain child components.',

                        ], 422);

                    }


                    foreach (
                        $block['children']
                        ?? []
                        as $child
                    ) {

                        $error =
                            $this->registerBlockIds(

                                $child,

                                $internalBlockIds,

                                $effectiveBlockIds

                            );


                        if (
                            $error
                        ) {

                            return response()->json([

                                'success' =>
                                    false,

                                'message' =>
                                    $error,

                            ], 422);

                        }

                    }

                }

            }


            /*
            |--------------------------------------------------------------------------
            | Bootstrap 12-grid
            |--------------------------------------------------------------------------
            */

            if (
                $totalWidth
                !== 12
            ) {

                return response()->json([

                    'success' =>
                        false,

                    'message' =>
                        'Each row must have a total column width of 12.',

                ], 422);

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Save JSON
        |--------------------------------------------------------------------------
        */

        $layoutJson = [

            'version' =>
                2,

            'rows' =>
                $data['rows'],

        ];


        $productLayout->update([

            'draft_layout_json' =>
                $layoutJson,

        ]);


        return response()->json([

            'success' =>
                true,

            'message' =>
                'Layout draft saved.',

            'data' => [

                'draft_layout_json' =>
                    $productLayout
                        ->fresh()
                        ->draft_layout_json,

            ],

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Register Block IDs
    |--------------------------------------------------------------------------
    */

    private function registerBlockIds(
        array $block,
        array &$internalBlockIds,
        array &$effectiveBlockIds
    ): ?string {

        $internalId =
            $block['id'];


        /*
        |--------------------------------------------------------------------------
        | Internal ID
        |--------------------------------------------------------------------------
        */

        if (
            isset(
                $internalBlockIds[
                    $internalId
                ]
            )
        ) {

            return (
                'Duplicate internal Block ID found: '
                .
                $internalId
            );

        }


        $internalBlockIds[
            $internalId
        ] =
            true;


        /*
        |--------------------------------------------------------------------------
        | Effective HTML ID
        |--------------------------------------------------------------------------
        */

        $customId =
            trim(
                (string)
                (
                    $block['settings']
                        ['custom_id']
                    ?? ''
                )
            );


        $effectiveId =
            $customId !== ''
                ? $customId
                : $internalId;


        $effectiveKey =
            mb_strtolower(
                $effectiveId
            );


        if (
            isset(
                $effectiveBlockIds[
                    $effectiveKey
                ]
            )
        ) {

            return (
                'Duplicate Block ID found: '
                .
                $effectiveId
            );

        }


        $effectiveBlockIds[
            $effectiveKey
        ] =
            true;


        return null;
    }


    /*
    |--------------------------------------------------------------------------
    | Publish
    |--------------------------------------------------------------------------
    */

    public function publish(
        ProductLayout $productLayout
    ) {
        $draft =
            $productLayout
                ->draft_layout_json;


        if (
            empty(
                $draft
            )
        ) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Layout draft not found.',

            ], 422);

        }


        $rows =
            $draft['rows']
            ?? [];


        $blockCount =
            0;


        foreach (
            $rows
            as $row
        ) {

            foreach (
                $row['columns']
                ?? []
                as $column
            ) {

                foreach (
                    $column['blocks']
                    ?? []
                    as $block
                ) {

                    $blockCount++;


                    if (
                        $block['type']
                        === 'accordion'
                    ) {

                        $blockCount +=
                            count(
                                $block['children']
                                ?? []
                            );

                    }

                }

            }

        }


        if (
            $blockCount
            === 0
        ) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Please add at least one component before publishing.',

            ], 422);

        }


        $productLayout->update([

            'published_layout_json' =>
                $draft,

            'status' =>
                'published',

            'published_at' =>
                now(),

        ]);


        return response()->json([

            'success' =>
                true,

            'message' =>
                'Layout published successfully.',

            'data' => [

                'published_at' =>
                    $productLayout
                        ->fresh()
                        ->published_at,

            ],

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function destroy(
        ProductLayout $productLayout
    ) {
        if (
            $productLayout
                ->products()
                ->exists()
        ) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'This layout is currently used by products.',

            ], 422);

        }


        $productLayout->delete();


        return response()->json([

            'success' =>
                true,

            'message' =>
                'Layout deleted.',

        ]);
    }
}

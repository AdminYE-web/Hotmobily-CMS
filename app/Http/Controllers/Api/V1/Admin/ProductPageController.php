<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ProductPageController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Admin Editor
    |--------------------------------------------------------------------------
    */

    public function edit(
        Product $product
    ) {
        $product->load([
            'layout',
            'page',
        ]);


        if (
            !$product->layout
        ) {

            return response()->json([

                'success' => false,

                'message' =>
                    'Please select a Product Layout first.',

            ], 422);

        }


        $page =
            $product
                ->page()
                ->firstOrCreate(
                    [],
                    [
                        'draft_content_json' => [

                            'version' => 1,

                            'blocks' => [],

                        ],
                    ]
                );


        $layout =
            $product
                ->layout
                ->draft_layout_json
            ??
            $product
                ->layout
                ->published_layout_json;


        return response()->json([

            'success' => true,

            'data' => [

                'product' => [

                    'id' =>
                        $product->id,

                    'name' =>
                        $product->name,

                    'slug' =>
                        $product->slug,

                    'product_code' =>
                        $product->product_code,

                    'status' =>
                        $product->status,

                ],


                'product_layout' => [

                    'id' =>
                        $product->layout->id,

                    'name' =>
                        $product->layout->name,

                    'status' =>
                        $product->layout->status,

                    'layout' =>
                        $layout,

                ],


                'content' =>
                    $page->draft_content_json
                    ??
                    [
                        'version' => 1,
                        'blocks' => [],
                    ],


                'published_at' =>
                    $page->published_at,

            ],

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Save Draft
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Product $product
    ) {
        $product->load(
            'layout'
        );


        if (
            !$product->layout
        ) {

            return response()->json([

                'success' => false,

                'message' =>
                    'Please select a Product Layout first.',

            ], 422);

        }


        $layout =
            $product
                ->layout
                ->draft_layout_json
            ??
            $product
                ->layout
                ->published_layout_json;


        if (
            empty(
                $layout['rows']
                ?? []
            )
        ) {

            return response()->json([

                'success' => false,

                'message' =>
                    'Selected layout is empty.',

            ], 422);

        }


        $request->validate([

            'blocks' => [
                'present',
                'array',
            ],

        ]);


        $layoutBlocks =
            $this->collectLayoutBlocks(
                $layout
            );


        $incoming =
            $request->input(
                'blocks',
                []
            );


        $cleanContent =
            [];


        foreach (
            $layoutBlocks
            as $blockId => $blockType
        ) {

            if (
                !array_key_exists(
                    $blockId,
                    $incoming
                )
            ) {

                continue;

            }


            $cleanContent[
                $blockId
            ] =
                $this->sanitizeBlockContent(

                    $blockType,

                    $incoming[
                        $blockId
                    ]

                );

        }


        $page =
            $product
                ->page()
                ->firstOrCreate();


        $page->update([

            'draft_content_json' => [

                'version' => 1,

                'blocks' =>
                    $cleanContent,

            ],

        ]);


        return response()->json([

            'success' => true,

            'message' =>
                'Product content draft saved.',


            'data' => [

                'draft_content_json' =>
                    $page
                        ->fresh()
                        ->draft_content_json,

            ],

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Publish
    |--------------------------------------------------------------------------
    */

    public function publish(
        Product $product
    ) {
        $product->load([
            'layout',
            'page',
        ]);


        if (
            !$product->layout
        ) {

            return response()->json([

                'success' => false,

                'message' =>
                    'Product Layout is not selected.',

            ], 422);

        }


        if (
            empty(
                $product
                    ->layout
                    ->published_layout_json
            )
        ) {

            return response()->json([

                'success' => false,

                'message' =>
                    'Please publish the Product Layout first.',

            ], 422);

        }


        $page =
            $product->page;


        if (
            !$page
            ||
            empty(
                $page->draft_content_json
            )
        ) {

            return response()->json([

                'success' => false,

                'message' =>
                    'Product content draft not found.',

            ], 422);

        }


        $page->update([

            'published_content_json' =>
                $page->draft_content_json,

            'published_at' =>
                now(),

        ]);


        return response()->json([

            'success' => true,

            'message' =>
                'Product page published.',


            'data' => [

                'published_at' =>
                    $page
                        ->fresh()
                        ->published_at,

            ],

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Public API
    |--------------------------------------------------------------------------
    */

    public function show(
        Product $product
    ) {
        if (
            $product->status
            !== 'active'
        ) {

            abort(
                404
            );

        }


        $product->load([
            'layout',
            'page',
        ]);


        if (
            !$product->layout
            ||
            empty(
                $product
                    ->layout
                    ->published_layout_json
            )
        ) {

            abort(
                404
            );

        }


        if (
            !$product->page
            ||
            empty(
                $product
                    ->page
                    ->published_content_json
            )
        ) {

            abort(
                404
            );

        }


        return response()->json([

            'success' => true,


            'data' => [

                'product' => [

                    'id' =>
                        $product->id,

                    'name' =>
                        $product->name,

                    'slug' =>
                        $product->slug,

                    'product_code' =>
                        $product->product_code,

                ],


                'layout' =>
                    $product
                        ->layout
                        ->published_layout_json,


                'content' =>
                    $product
                        ->page
                        ->published_content_json,


                'published_at' =>
                    $product
                        ->page
                        ->published_at,

            ],

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Collect Layout Blocks
    |--------------------------------------------------------------------------
    */

    private function collectLayoutBlocks(
        array $layout
    ): array {
        $result =
            [];


        foreach (
            $layout['rows']
            ?? []
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

                    $this->collectBlock(
                        $block,
                        $result
                    );

                }

            }

        }


        return $result;
    }


    private function collectBlock(
        array $block,
        array &$result
    ): void {
        if (
            isset(
                $block['id'],
                $block['type']
            )
        ) {

            $result[
                $block['id']
            ] =
                $block['type'];

        }


        if (
            (
                $block['type']
                ?? null
            )
            === 'accordion'
        ) {

            foreach (
                $block['children']
                ?? []
                as $child
            ) {

                $this->collectBlock(
                    $child,
                    $result
                );

            }

        }
    }


    /*
    |--------------------------------------------------------------------------
    | Sanitize Block Content
    |--------------------------------------------------------------------------
    */

    private function sanitizeBlockContent(
        string $type,
        mixed $content
    ): array {
        if (
            !is_array(
                $content
            )
        ) {

            return [];

        }


        return match (
            $type
        ) {

            /*
             * Product Header
             */
            'product_header' => [

                'title' =>
                    $this->stringValue(
                        $content['title']
                        ?? null,
                        255
                    ),

                'updated_date' =>
                    $this->stringValue(
                        $content['updated_date']
                        ?? null,
                        20
                    ),

                'show_share' =>
                    (bool)
                    (
                        $content['show_share']
                        ?? false
                    ),

            ],


            /*
             * Gallery
             */
            'product_gallery' => [

                'images' =>
                    $this->stringArray(
                        $content['images']
                        ?? []
                    ),

            ],


            /*
             * Product Details
             */
            'product_details' => [

                'reference_price' =>
                    $this->stringValue(
                        $content['reference_price']
                        ?? null,
                        255
                    ),

                'total_price' =>
                    $this->stringValue(
                        $content['total_price']
                        ?? null,
                        255
                    ),

                'shipping_days' =>
                    $this->integerValue(
                        $content['shipping_days']
                        ?? null,
                        0,
                        365
                    ),

                'shipping_note' =>
                    $this->stringValue(
                        $content['shipping_note']
                        ?? null,
                        2000
                    ),

                'highlight_title' =>
                    $this->stringValue(
                        $content['highlight_title']
                        ?? null,
                        1000
                    ),

            ],


            /*
             * Heading
             */
            'heading' => [

                'text' =>
                    $this->stringValue(
                        $content['text']
                        ?? null,
                        1000
                    ),

            ],


            /*
             * Rich Text
             */
            'rich_text' => [

                'content' =>
                    $this->stringValue(
                        $content['content']
                        ?? null,
                        20000
                    ),

            ],


            /*
             * Image
             */
            'image' => [

                'url' =>
                    $this->stringValue(
                        $content['url']
                        ?? null,
                        2000
                    ),

                'alt' =>
                    $this->stringValue(
                        $content['alt']
                        ?? null,
                        500
                    ),

            ],


            /*
             * Button
             */
            'button' => [

                'text' =>
                    $this->stringValue(
                        $content['text']
                        ?? null,
                        255
                    ),

                'url' =>
                    $this->stringValue(
                        $content['url']
                        ?? null,
                        2000
                    ),

            ],


            /*
             * Downloadable Template Button
             */
            'template_button' => [

                'text' =>
                    $this->stringValue(
                        $content['text']
                        ?? null,
                        255
                    ),

                'template_url' =>
                    $this->stringValue(
                        $content['template_url']
                        ?? null,
                        2000
                    ),

                'template_name' =>
                    $this->stringValue(
                        $content['template_name']
                        ?? null,
                        255
                    ),

            ],


            /*
             * Text Link
             */
            'text_link' => [

                'text' =>
                    $this->stringValue(
                        $content['text']
                        ?? null,
                        1000
                    ),

                'url' =>
                    $this->stringValue(
                        $content['url']
                        ?? null,
                        2000
                    ),

                'target' =>
                    $this->enumValue(

                        $content['target']
                        ?? null,

                        [
                            '_self',
                            '_blank',
                        ],

                        '_self'

                    ),

            ],


            /*
             * Flexible Custom Table V2
             */
            'custom_table' => [

                'title' =>
                    $this->stringValue(
                        $content['title']
                        ?? null,
                        1000
                    ),

                'rows' =>
                    $this->sanitizeFlexibleTableRows(
                        $content['rows']
                        ?? []
                    ),

            ],


            /*
             * Info Card
             */
            'info_card' => [

                'title' =>
                    $this->stringValue(
                        $content['title']
                        ?? null,
                        1000
                    ),

                'image_url' =>
                    $this->stringValue(
                        $content['image_url']
                        ?? null,
                        2000
                    ),

                'description' =>
                    $this->stringValue(
                        $content['description']
                        ?? null,
                        10000
                    ),

                'link_text' =>
                    $this->stringValue(
                        $content['link_text']
                        ?? null,
                        255
                    ),

                'link_url' =>
                    $this->stringValue(
                        $content['link_url']
                        ?? null,
                        2000
                    ),

            ],


            /*
             * Accordion
             */
            'accordion' => [

                'title' =>
                    $this->stringValue(
                        $content['title']
                        ?? null,
                        1000
                    ),

            ],


            /*
             * Shipping Schedule
             */
            'shipping_schedule' => [

                'title' =>
                    $this->stringValue(
                        $content['title']
                        ?? null,
                        1000
                    ),

                'display_type' =>
                    $this->enumValue(

                        $content['display_type']
                        ?? null,

                        [
                            'stacked',
                            'grouped',
                        ],

                        'stacked'

                    ),

                'intro_text' =>
                    $this->stringValue(
                        $content['intro_text']
                        ?? null,
                        2000
                    ),

                'start_label' =>
                    $this->stringValue(
                        $content['start_label']
                        ?? null,
                        500
                    ),

                'shipping_label' =>
                    $this->stringValue(
                        $content['shipping_label']
                        ?? null,
                        500
                    ),

                'footer_note' =>
                    $this->stringValue(
                        $content['footer_note']
                        ?? null,
                        10000
                    ),

                'schedules' =>
                    $this->sanitizeShippingSchedules(
                        $content['schedules']
                        ?? []
                    ),

            ],


            /*
             * System Components
             */
            'price_accordion',
            'production_schedule',
            'divider',
            'spacer' => [],


            default => [],

        };
    }


    /*
    |--------------------------------------------------------------------------
    | Flexible Table Sanitizer
    |--------------------------------------------------------------------------
    */

    private function sanitizeFlexibleTableRows(
        mixed $rows
    ): array {
        if (
            !is_array(
                $rows
            )
        ) {

            return [];

        }


        /*
         * จำกัด 100 Rows
         */
        $rows =
            array_slice(
                $rows,
                0,
                100
            );


        $cleanRows =
            [];


        foreach (
            $rows
            as $row
        ) {

            if (
                !is_array(
                    $row
                )
            ) {

                continue;

            }


            $cells =
                is_array(
                    $row['cells']
                    ?? null
                )
                    ? array_slice(
                        $row['cells'],
                        0,
                        30
                    )
                    : [];


            $cleanCells =
                [];


            foreach (
                $cells
                as $cell
            ) {

                if (
                    !is_array(
                        $cell
                    )
                ) {

                    continue;

                }


                $cleanCells[] = [

                    'id' =>
                        $this->stringValue(
                            $cell['id']
                            ?? null,
                            100
                        ),

                    'content' =>
                        $this->stringValue(
                            $cell['content']
                            ?? null,
                            20000
                        ),

                    /*
                     * 0.5% steps
                     */
                    'width' =>
                        $this->tableWidthValue(
                            $cell['width']
                            ?? null
                        ),

                    /*
                     * NEW
                     */
                    'rowspan' =>
                        $this->integerValue(
                            $cell['rowspan']
                            ?? 1,
                            1,
                            20
                        )
                        ?? 1,

                    'background_color' =>
                        $this->hexColorValue(
                            $cell['background_color']
                            ?? null,
                            '#ffffff'
                        ),

                    'text_color' =>
                        $this->hexColorValue(
                            $cell['text_color']
                            ?? null,
                            '#000000'
                        ),

                    'align' =>
                        $this->enumValue(

                            $cell['align']
                            ?? null,

                            [
                                'left',
                                'center',
                                'right',
                            ],

                            'center'

                        ),

                    'vertical_align' =>
                        $this->enumValue(

                            $cell['vertical_align']
                            ?? null,

                            [
                                'top',
                                'middle',
                                'bottom',
                            ],

                            'middle'

                        ),

                    'bold' =>
                        (bool)
                        (
                            $cell['bold']
                            ?? false
                        ),

                    'padding' =>
                        $this->integerValue(
                            $cell['padding']
                            ?? null,
                            0,
                            50
                        )
                        ?? 8,

                ];

            }


            $cleanRows[] = [

                'id' =>
                    $this->stringValue(
                        $row['id']
                        ?? null,
                        100
                    ),

                'cells' =>
                    $cleanCells,

            ];

        }


        /*
         * Validate Width + Rowspan
         */
        $this->validateFlexibleTableStructure(
            $cleanRows
        );


        return $cleanRows;
    }


    /*
    |--------------------------------------------------------------------------
    | Validate Flexible Table Structure
    |--------------------------------------------------------------------------
    |
    | 200 Units = 100%
    |
    | 1 Unit = 0.5%
    |
    */

    private function validateFlexibleTableStructure(
        array $rows
    ): void {
        if (
            count(
                $rows
            )
            === 0
        ) {

            throw ValidationException::withMessages([

                'blocks' => [
                    'Custom Table must have at least one row.',
                ],

            ]);

        }


        $totalUnits =
            200;


        /*
         * Rowspan จาก Row ก่อน
         */
        $spans =
            [];


        $totalRows =
            count(
                $rows
            );


        foreach (
            $rows
            as $rowIndex => $row
        ) {

            /*
             * Span ที่ยัง active ใน Row นี้
             */
            $inherited =
                array_values(
                    array_filter(
                        $spans,
                        fn (array $span) =>
                            $span['start_row']
                            <
                            $rowIndex
                            &&
                            $span['end_row']
                            >=
                            $rowIndex
                    )
                );


            $occupied =
                array_map(
                    fn (array $span) => [

                        'start' =>
                            $span['start'],

                        'end' =>
                            $span['end'],

                    ],
                    $inherited
                );


            foreach (
                $row['cells']
                ?? []
                as $cellIndex => $cell
            ) {

                $widthUnits =
                    (int)
                    round(
                        (
                            (float)
                            $cell['width']
                        )
                        *
                        2
                    );


                $rowspan =
                    (int)
                    (
                        $cell['rowspan']
                        ?? 1
                    );


                /*
                 * Row Span เกิน Table
                 */
                if (
                    $rowIndex
                    +
                    $rowspan
                    >
                    $totalRows
                ) {

                    throw ValidationException::withMessages([

                        'blocks' => [

                            sprintf(

                                'Custom Table Row #%d Cell #%d rowspan exceeds the last row.',

                                $rowIndex + 1,

                                $cellIndex + 1

                            ),

                        ],

                    ]);

                }


                $start =
                    $this->findFirstFreeTablePosition(

                        $occupied,

                        $widthUnits,

                        $totalUnits

                    );


                if (
                    $start === null
                ) {

                    throw ValidationException::withMessages([

                        'blocks' => [

                            sprintf(

                                'Custom Table Row #%d Cell #%d cannot fit because of rowspan from a previous row.',

                                $rowIndex + 1,

                                $cellIndex + 1

                            ),

                        ],

                    ]);

                }


                $end =
                    $start
                    +
                    $widthUnits;


                $occupied[] = [

                    'start' =>
                        $start,

                    'end' =>
                        $end,

                ];


                if (
                    $rowspan > 1
                ) {

                    $spans[] = [

                        'start' =>
                            $start,

                        'end' =>
                            $end,

                        'start_row' =>
                            $rowIndex,

                        'end_row' =>
                            $rowIndex
                            +
                            $rowspan
                            -
                            1,

                    ];

                }

            }


            $coveredUnits =
                $this->sumOccupiedTableUnits(
                    $occupied
                );


            if (
                $coveredUnits
                !==
                $totalUnits
            ) {

                throw ValidationException::withMessages([

                    'blocks' => [

                        sprintf(

                            'Custom Table Row #%d width is %.1f%%. The row including rowspan cells must equal 100%%.',

                            $rowIndex + 1,

                            $coveredUnits / 2

                        ),

                    ],

                ]);

            }

        }
    }


    /*
    |--------------------------------------------------------------------------
    | Find Free Position
    |--------------------------------------------------------------------------
    */

    private function findFirstFreeTablePosition(
        array $occupied,
        int $widthUnits,
        int $totalUnits
    ): ?int {
        if (
            $widthUnits <= 0
            ||
            $widthUnits > $totalUnits
        ) {

            return null;

        }


        usort(
            $occupied,
            fn (
                array $a,
                array $b
            ) =>
                $a['start']
                <=>
                $b['start']
        );


        $candidate =
            0;


        foreach (
            $occupied
            as $range
        ) {

            if (
                $candidate
                +
                $widthUnits
                <=
                $range['start']
            ) {

                return $candidate;

            }


            $candidate =
                max(
                    $candidate,
                    $range['end']
                );

        }


        if (
            $candidate
            +
            $widthUnits
            <=
            $totalUnits
        ) {

            return $candidate;

        }


        return null;
    }


    /*
    |--------------------------------------------------------------------------
    | Sum Occupied Units
    |--------------------------------------------------------------------------
    */

    private function sumOccupiedTableUnits(
        array $ranges
    ): int {
        if (
            count(
                $ranges
            )
            === 0
        ) {

            return 0;

        }


        usort(
            $ranges,
            fn (
                array $a,
                array $b
            ) =>
                $a['start']
                <=>
                $b['start']
        );


        $currentStart =
            $ranges[0]['start'];


        $currentEnd =
            $ranges[0]['end'];


        $total =
            0;


        for (
            $index = 1;
            $index < count($ranges);
            $index++
        ) {

            $range =
                $ranges[
                    $index
                ];


            if (
                $range['start']
                <=
                $currentEnd
            ) {

                $currentEnd =
                    max(
                        $currentEnd,
                        $range['end']
                    );


                continue;

            }


            $total +=
                $currentEnd
                -
                $currentStart;


            $currentStart =
                $range['start'];


            $currentEnd =
                $range['end'];

        }


        $total +=
            $currentEnd
            -
            $currentStart;


        return $total;
    }


    /*
    |--------------------------------------------------------------------------
    | Table Width
    |--------------------------------------------------------------------------
    */

    private function tableWidthValue(
        mixed $value
    ): float {
        if (
            !is_numeric(
                $value
            )
        ) {

            return 100.0;

        }


        $number =
            (float)
            $value;


        /*
         * 0.5% step
         */
        $number =
            round(
                $number
                *
                2
            )
            /
            2;


        return min(

            100,

            max(
                0.5,
                $number
            )

        );
    }


    /*
    |--------------------------------------------------------------------------
    | Shipping Schedule
    |--------------------------------------------------------------------------
    */

    private function sanitizeShippingSchedules(
        mixed $schedules
    ): array {
        if (
            !is_array(
                $schedules
            )
        ) {

            return [];

        }


        $clean =
            [];


        foreach (
            array_slice(
                $schedules,
                0,
                20
            )
            as $schedule
        ) {

            if (
                !is_array(
                    $schedule
                )
            ) {

                continue;

            }


            $clean[] = [

                'id' =>
                    $this->stringValue(
                        $schedule['id']
                        ?? null,
                        100
                    ),

                'label' =>
                    $this->stringValue(
                        $schedule['label']
                        ?? null,
                        1000
                    ),

                'days' =>
                    $this->integerValue(
                        $schedule['days']
                        ?? null,
                        0,
                        365
                    )
                    ?? 0,

                'theme' =>
                    $this->enumValue(

                        $schedule['theme']
                        ?? null,

                        [
                            'blue',
                            'pink',
                            'cyan',
                            'orange',
                            'gray',
                        ],

                        'blue'

                    ),

            ];

        }


        return $clean;
    }


    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    private function integerValue(
        mixed $value,
        int $min = 0,
        int $max = 365
    ): ?int {
        if (
            $value === null
            ||
            $value === ''
        ) {

            return null;

        }


        if (
            filter_var(
                $value,
                FILTER_VALIDATE_INT
            )
            === false
        ) {

            return null;

        }


        return max(

            $min,

            min(
                $max,
                (int)
                $value
            )

        );
    }


    private function enumValue(
        mixed $value,
        array $allowed,
        string $default
    ): string {
        $value =
            (string)
            (
                $value
                ?? ''
            );


        return in_array(
            $value,
            $allowed,
            true
        )
            ? $value
            : $default;
    }


    private function hexColorValue(
        mixed $value,
        string $default
    ): string {
        $color =
            strtolower(
                trim(
                    (string)
                    $value
                )
            );


        return preg_match(
            '/^#[0-9a-f]{6}$/',
            $color
        )
        === 1
            ? $color
            : $default;
    }


    private function stringValue(
        mixed $value,
        int $maxLength
    ): ?string {
        if (
            $value === null
        ) {

            return null;

        }


        return mb_substr(

            trim(
                (string)
                $value
            ),

            0,

            $maxLength

        );
    }


    private function stringArray(
        mixed $values
    ): array {
        if (
            !is_array(
                $values
            )
        ) {

            return [];

        }


        return collect(
            $values
        )
        ->map(
            fn ($value) =>
                trim(
                    (string)
                    $value
                )
        )
        ->filter()
        ->take(
            20
        )
        ->values()
        ->all();
    }


    /*
    |--------------------------------------------------------------------------
    | Upload Product Image
    |--------------------------------------------------------------------------
    */

    public function uploadImage(
        Request $request,
        Product $product
    ) {
        $request->validate([

            'image' => [
                'required',
                'file',
                'image',
                'mimes:jpg,jpeg,png,webp,gif',
                'max:10240',
            ],

        ]);


        $file =
            $request->file(
                'image'
            );


        /*
         * Verify actual image
         */
        if (
            @getimagesize(
                $file->getRealPath()
            )
            === false
        ) {

            return response()->json([

                'success' => false,

                'message' =>
                    'The uploaded file is not a valid image.',

            ], 422);

        }


        $mime =
            $file->getMimeType();


        $extensionMap = [

            'image/jpeg' =>
                'jpg',

            'image/png' =>
                'png',

            'image/webp' =>
                'webp',

            'image/gif' =>
                'gif',

        ];


        if (
            !isset(
                $extensionMap[
                    $mime
                ]
            )
        ) {

            return response()->json([

                'success' => false,

                'message' =>
                    'Unsupported image type.',

            ], 422);

        }


        $filename =
            Str::uuid()
            .
            '.'
            .
            $extensionMap[
                $mime
            ];


        $path =
            $file->storeAs(

                'products/'
                .
                $product->id,

                $filename,

                'public'

            );


        $url =
            Storage::disk(
                'public'
            )
            ->url(
                $path
            );


        return response()->json([

            'success' => true,


            'data' => [

                'path' =>
                    $path,

                'url' =>
                    $url,

                'filename' =>
                    $filename,

                'original_name' =>
                    $file
                        ->getClientOriginalName(),

                'mime_type' =>
                    $mime,

            ],

        ], 201);
    }


    /*
    |--------------------------------------------------------------------------
    | Upload Product Template
    |--------------------------------------------------------------------------
    */

    public function uploadTemplate(
        Request $request,
        Product $product
    ) {
        $request->validate([

            'template' => [
                'required',
                'file',
                'mimes:pdf,zip,ai,psd,eps,svg,doc,docx,xls,xlsx,ppt,pptx',
                'max:51200',
            ],

        ]);


        $file =
            $request->file(
                'template'
            );


        $extension =
            strtolower(
                $file->getClientOriginalExtension()
            );


        $filename =
            Str::uuid()
            .
            '.'
            .
            $extension;


        $path =
            $file->storeAs(

                'products/'
                .
                $product->id
                .
                '/templates',

                $filename,

                'public'

            );


        $url =
            Storage::disk(
                'public'
            )
            ->url(
                $path
            );


        return response()->json([

            'success' => true,

            'data' => [

                'path' =>
                    $path,

                'url' =>
                    $url,

                'filename' =>
                    $filename,

                'original_name' =>
                    $file
                        ->getClientOriginalName(),

                'mime_type' =>
                    $file->getMimeType(),

            ],

        ], 201);
    }
}

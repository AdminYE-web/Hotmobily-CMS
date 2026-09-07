<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use Tests\TestCase;

class DynamicProductViewTest extends TestCase
{
    public function test_dynamic_product_view_uses_legacy_shell_and_renders_cms_blocks(): void
    {
        $product = new Product([
            'name' => 'Rubber Strap',
            'slug' => 'rubberstrap',
            'status' => 'active',
        ]);

        $layout = [
            'rows' => [
                [
                    'columns' => [
                        [
                            'width' => 12,
                            'blocks' => [
                                [
                                    'id' => 'product-title',
                                    'type' => 'heading',
                                    'settings' => [
                                        'tag' => 'h2',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $view = $this->view('products.show', [
            'product' => $product,
            'layout' => $layout,
            'contents' => [
                'product-title' => [
                    'text' => 'Dynamic product heading',
                ],
            ],
            'publishedAt' => null,
        ]);

        $view
            ->assertSee('/products/css/base_5th.css', false)
            ->assertSee('/css/header.css', false)
            ->assertSee('/products/css/product_group.css', false)
            ->assertSee('product-cms-page', false)
            ->assertSee('Dynamic product heading');
    }

    public function test_dynamic_product_view_renders_custom_table_v2_content(): void
    {
        $product = new Product([
            'name' => 'Custom Table Product',
            'slug' => 'custom-table-product',
            'status' => 'active',
        ]);

        $layout = [
            'rows' => [
                [
                    'columns' => [
                        [
                            'width' => 12,
                            'blocks' => [
                                [
                                    'id' => 'specification-table',
                                    'type' => 'custom_table',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $view = $this->view('products.show', [
            'product' => $product,
            'layout' => $layout,
            'contents' => [
                'specification-table' => [
                    'title' => 'Product specifications',
                    'rows' => [
                        [
                            'id' => 'row-1',
                            'height' => 36,
                            'background_color' => '#ffeecc',
                            'cells' => [
                                [
                                    'id' => 'cell-1',
                                    'content' => 'Material',
                                    'width' => 70,
                                    'rowspan' => 1,
                                    'background_color' => '#d9e7f3',
                                    'text_color' => '#123456',
                                    'align' => 'left',
                                    'vertical_align' => 'top',
                                    'bold' => true,
                                    'padding' => 12,
                                ],
                                [
                                    'id' => 'cell-2',
                                    'content' => 'Soft PVC',
                                    'width' => 30,
                                ],
                            ],
                        ],
                        [
                            'id' => 'row-2',
                            'cells' => [
                                [
                                    'id' => 'cell-3',
                                    'content' => 'Equal left',
                                    'width' => 50,
                                ],
                                [
                                    'id' => 'cell-4',
                                    'content' => 'Equal right',
                                    'width' => 50,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'publishedAt' => null,
        ]);

        $view
            ->assertSee('Product specifications')
            ->assertSee('Material')
            ->assertSee('Soft PVC')
            ->assertSee('#ffeecc', false)
            ->assertSee('#123456', false)
            ->assertSee('colspan="140"', false)
            ->assertSee('colspan="60"', false)
            ->assertSee('colspan="100"', false)
            ->assertSee('height: 36px', false)
            ->assertSee('12px', false);
    }
}

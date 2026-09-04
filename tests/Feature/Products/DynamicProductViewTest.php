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
}

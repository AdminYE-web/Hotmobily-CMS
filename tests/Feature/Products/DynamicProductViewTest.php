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
                                [
                                    'id' => 'formatted-copy',
                                    'type' => 'rich_text',
                                ],
                                [
                                    'id' => 'colored-link',
                                    'type' => 'text_link',
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
                'formatted-copy' => [
                    'content' => '<strong>Bold copy</strong> <font color="#ff0000" size="5">Red copy</font>',
                    'content_format' => 'html',
                    'text_size' => 'small',
                ],
                'colored-link' => [
                    'text' => 'Colored link',
                    'url' => 'https://example.test/colored-link',
                    'target' => '_self',
                    'text_color' => '#ff6600',
                ],
            ],
            'publishedAt' => null,
        ]);

        $view
            ->assertSee('/products/css/base_5th.css', false)
            ->assertSee('/css/header.css', false)
            ->assertSee('/products/css/product_group.css', false)
            ->assertSee('product-cms-page', false)
            ->assertSee('Dynamic product heading')
            ->assertSee('<strong>Bold copy</strong>', false)
            ->assertSee('<font color="#ff0000" size="5">Red copy</font>', false)
            ->assertSee('store-rich-text-small', false);

        $view->assertSee('color: #ff6600 !important;', false);
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

    public function test_dynamic_product_view_renders_legacy_style_shipping_schedule(): void
    {
        $product = new Product([
            'name' => 'Shipping Schedule Product',
            'slug' => 'shipping-schedule-product',
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
                                    'id' => 'shipping-schedule',
                                    'type' => 'shipping_schedule',
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
                'shipping-schedule' => [
                    'display_type' => 'stacked',
                    'intro_text' => '今、この製品を製作開始した場合の出荷日を表示中',
                    'start_label' => '原稿確定日',
                    'shipping_label' => '出荷予定',
                    'footer_note' => '※営業日には、土日祝日を含みません。',
                    'schedules' => [
                        [
                            'label' => '通常納期',
                            'days' => 10,
                            'theme' => 'blue',
                        ],
                        [
                            'label' => 'スピード納期',
                            'days' => 7,
                            'theme' => 'pink',
                        ],
                        [
                            'label' => '試作納期',
                            'days' => 6,
                            'theme' => 'cyan',
                        ],
                    ],
                ],
            ],
            'publishedAt' => null,
        ]);

        $view
            ->assertSee('store-shipping-item-blue', false)
            ->assertSee('store-shipping-item-pink', false)
            ->assertSee('store-shipping-message-row', false)
            ->assertSee('store-shipping-label-row', false)
            ->assertSee('store-shipping-date-row', false)
            ->assertSee('今、この製品を製作開始した場合の出荷日を表示中')
            ->assertSee('10営業日後出荷')
            ->assertSee('7営業日後出荷')
            ->assertSee('6営業日後出荷')
            ->assertSee('今、この製品をご注文頂いた場合の出荷予定日を表示中')
            ->assertSee('data-shipping-date-days="10"', false)
            ->assertSee('data-shipping-date-days="7"', false)
            ->assertSee('data-shipping-start-time', false);
    }
}

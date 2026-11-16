<?php

namespace Tests\Feature\Products;

use App\Http\Controllers\Api\V1\Admin\ProductPageController;
use App\Models\Product;
use ReflectionMethod;
use Tests\TestCase;

class ProductGalleryColumnsTest extends TestCase
{
    public function test_gallery_column_setting_survives_sanitization_and_renders(): void
    {
        $sanitize = new ReflectionMethod(ProductPageController::class, 'sanitizeBlockContent');
        foreach ([2, 3, '3', null, 4, '3; color:red'] as $value) {
            $expected = in_array($value, [3, '3'], true) ? 3 : 2;
            $content = $sanitize->invoke(new ProductPageController, 'product_gallery', [
                'columns' => $value,
                'images' => ['/img/gallery-one.jpg', '/img/gallery-two.jpg'],
                'image_alts' => ['First image', 'Second image'],
            ]);

            $this->assertSame($expected, $content['columns']);
            $this->assertSame(['First image', 'Second image'], $content['image_alts']);
            $this->view('products.show', [
                'product' => new Product(['name' => 'Gallery product', 'slug' => 'gallery-product']),
                'layout' => ['rows' => [['columns' => [['width' => 12, 'blocks' => [
                    ['id' => 'gallery', 'type' => 'product_gallery'],
                ]]]]]],
                'contents' => ['gallery' => $content],
                'publishedAt' => null,
            ])->assertSee('--gallery-columns: '.$expected, false)
                ->assertSee('alt="First image"', false)
                ->assertSee('alt="Second image"', false);
        }
    }

    public function test_existing_gallery_without_setting_defaults_to_two_columns(): void
    {
        $this->view('products.show', [
            'product' => new Product(['name' => 'Gallery product', 'slug' => 'gallery-product']),
            'layout' => ['rows' => [['columns' => [['width' => 12, 'blocks' => [
                ['id' => 'gallery', 'type' => 'product_gallery'],
            ]]]]]],
            'contents' => ['gallery' => ['images' => ['/img/one.jpg', '/img/two.jpg']]],
            'publishedAt' => null,
        ])->assertSee('--gallery-columns: 2', false);
    }
}

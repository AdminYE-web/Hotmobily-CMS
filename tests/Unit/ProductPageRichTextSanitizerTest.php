<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\V1\Admin\ProductPageController;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

class ProductPageRichTextSanitizerTest extends TestCase
{
    public function test_rich_text_html_keeps_formatting_and_removes_unsafe_markup(): void
    {
        $controller = new ProductPageController();

        $sanitize = new ReflectionMethod(
            ProductPageController::class,
            'sanitizeRichTextHtml'
        );

        $html = $sanitize->invoke(
            $controller,
            '<strong onclick="alert(1)">Safe</strong>'
            . '<script>alert(2)</script>'
            . '<font color="#FF0000" size="5" face="Arial" onmouseover="alert(3)">Red</font>'
            . '<a href="javascript:alert(4)">Link</a>'
        );

        $this->assertStringContainsString('<strong>Safe</strong>', $html);
        $this->assertStringContainsString(
            '<font color="#ff0000" size="5" face="Arial">Red</font>',
            $html
        );
        $this->assertStringContainsString('Link', $html);
        $this->assertStringNotContainsString('onclick', $html);
        $this->assertStringNotContainsString('onmouseover', $html);
        $this->assertStringNotContainsString('<script', $html);
        $this->assertStringNotContainsString('<a ', $html);
        $this->assertStringNotContainsString('javascript:', $html);
    }

    public function test_text_link_color_is_normalized_to_a_safe_hex_value(): void
    {
        $controller = new ProductPageController();

        $sanitize = new ReflectionMethod(
            ProductPageController::class,
            'sanitizeBlockContent'
        );

        $valid = $sanitize->invoke(
            $controller,
            'text_link',
            [
                'text' => 'Link',
                'url' => '/products/example',
                'text_color' => '#ABCDEF',
            ]
        );

        $invalid = $sanitize->invoke(
            $controller,
            'text_link',
            [
                'text_color' => 'red; background:url(javascript:alert(1))',
            ]
        );

        $this->assertSame('#abcdef', $valid['text_color']);
        $this->assertSame('#111111', $invalid['text_color']);
    }

    public function test_rich_text_size_allows_only_normal_or_small(): void
    {
        $controller = new ProductPageController();

        $sanitize = new ReflectionMethod(
            ProductPageController::class,
            'sanitizeBlockContent'
        );

        $small = $sanitize->invoke(
            $controller,
            'rich_text',
            [
                'content' => 'Small copy',
                'text_size' => 'small',
            ]
        );

        $default = $sanitize->invoke(
            $controller,
            'rich_text',
            [
                'content' => 'Normal copy',
            ]
        );

        $invalid = $sanitize->invoke(
            $controller,
            'rich_text',
            [
                'text_size' => 'large',
            ]
        );

        $this->assertSame('small', $small['text_size']);
        $this->assertSame('normal', $default['text_size']);
        $this->assertSame('normal', $invalid['text_size']);
    }
}

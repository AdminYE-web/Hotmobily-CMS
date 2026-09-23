<?php

namespace Tests\Unit;

use App\Support\RichTextSanitizer;
use PHPUnit\Framework\TestCase;

class RichTextSanitizerTest extends TestCase
{
    public function test_ckeditor_images_are_kept_and_unsafe_attributes_are_removed(): void
    {
        $html = '<figure class="image image_resized">'
            . '<img src="/storage/product-notices/example.jpg" alt="Example" onerror="alert(1)">'
            . '</figure>';

        $sanitized = (new RichTextSanitizer())->sanitize($html);

        $this->assertStringContainsString(
            '<figure class="image"><img src="/storage/product-notices/example.jpg" alt="Example"></figure>',
            $sanitized
        );
        $this->assertStringNotContainsString('image_resized', $sanitized);
        $this->assertStringNotContainsString('onerror', $sanitized);
    }

    public function test_unsafe_image_sources_are_removed(): void
    {
        $sanitized = (new RichTextSanitizer())->sanitize(
            '<img src="javascript:alert(1)"><img src="//unsafe.example/image.jpg">'
        );

        $this->assertSame('', $sanitized);
    }

    public function test_download_file_link_keeps_button_marker_and_download_attribute(): void
    {
        $sanitized = (new RichTextSanitizer())->sanitize(
            '<a class="rich-text-file-link" href="/storage/product-data/1/content-files/file.pdf" download onclick="alert(1)">Download PDF</a>'
        );

        $this->assertSame(
            '<a href="/storage/product-data/1/content-files/file.pdf" class="rich-text-file-link" download="">Download PDF</a>',
            $sanitized
        );
    }
}

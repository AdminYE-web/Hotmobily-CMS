<?php

namespace Tests\Unit;

use App\Support\RichTextSanitizer;
use PHPUnit\Framework\TestCase;

class RichTextSanitizerTest extends TestCase
{
    public function test_text_alignment_is_preserved_with_only_allowed_values(): void
    {
        $html = (new RichTextSanitizer())->sanitize('<p style="text-align:center;position:fixed">Center</p><div style="text-align:right">Right</div><p style="text-align:left">Left</p><p style="text-align:invalid">Invalid</p>');
        foreach (['left', 'center', 'right'] as $alignment) $this->assertStringContainsString('style="text-align:'.$alignment.'"', $html);
        $this->assertStringNotContainsString('position', $html);
        $this->assertStringNotContainsString('text-align:invalid', $html);
    }

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

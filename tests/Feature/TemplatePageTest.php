<?php

namespace Tests\Feature;

use Tests\TestCase;

class TemplatePageTest extends TestCase
{
    public function test_template_page_contains_the_original_selector_and_download_catalog(): void
    {
        $this->get('/template/')
            ->assertOk()
            ->assertSee('id="prd_name"', false)
            ->assertSee('id="result"', false)
            ->assertSee('template-Rubberstrap_final_20260119.zip', false)
            ->assertSee('template-acrylic_50mm_20250320.ai', false);
    }

    public function test_legacy_temp_alias_is_kept_for_deep_links(): void
    {
        $this->get('/template/?temp=acrylic_keyholder')
            ->assertOk()
            ->assertSee('acrylic_keyholder', false)
            ->assertSee('initialProduct', false);
    }
}

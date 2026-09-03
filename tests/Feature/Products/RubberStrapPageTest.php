<?php

namespace Tests\Feature\Products;

use Tests\TestCase;

class RubberStrapPageTest extends TestCase
{
    public function test_rubber_strap_page_renders_successfully(): void
    {
        $response = $this->get('/products/rubberstrap');

        $response
            ->assertOk()
            ->assertSee('オリジナルラバーストラップ')
            ->assertSee('pdp-v2-main-viewport', false)
            ->assertSee('id="order-form"', false)
            ->assertSee('class="repeat"', false)
            ->assertSee('style="display:none;"', false)
            ->assertSee('id="sidemenu"', false)
            ->assertSee('sns-footer', false)
            ->assertSee('price-toggle', false)
            ->assertSeeInOrder([
                'id="header"',
                'id="tab_menu"',
                'id="wrapper"',
                'id="sidemenu"',
                'id="content_wrapper"',
                'id="order-form"',
                'id="footerbox"',
                '/js/_setToInput_2026.js?v=1.01',
            ], false);
    }

    public function test_rubber_strap_page_supports_trailing_slash(): void
    {
        $response = $this->get('/products/rubberstrap/');

        $response->assertOk();
    }

    public function test_rubber_strap_delivery_schedule_endpoint_returns_table(): void
    {
        $response = $this->get('/products/getdate_disp2023-rubber');

        $response
            ->assertOk()
            ->assertSee('tbl_price_deli', false)
            ->assertSee('スタンダード')
            ->assertSee('プレミアム');
    }

    public function test_holiday_and_sample_date_endpoints_return_json(): void
    {
        $this->postJson('/products/check_holiday.php', ['product' => 'ラバーストラップ'])
            ->assertOk()
            ->assertJsonCount(2);

        $this->postJson('/products/get_sample_date.php', ['days' => '7', 'format_cal' => '12'])
            ->assertOk()
            ->assertJsonCount(3);
    }

    public function test_paper_preview_and_parts_endpoints(): void
    {
        $this->get('/products/paper_preview.php')
            ->assertOk()
            ->assertSee('paper-patternA-1', false);

        $this->get('/products/rubberstrap/part.php')
            ->assertOk()
            ->assertJsonFragment(['part_name' => '通常松葉（カニカン）']);
    }
}

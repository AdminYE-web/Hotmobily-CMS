<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_home_page_renders_the_legacy_structure_with_mock_news(): void
    {
        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertSee('ホットモバイリー')
            ->assertSee('オリジナルラバーストラップ')
            ->assertSee('id="sidemenu"', false)
            ->assertSee('id="calendar"', false)
            ->assertSee('News!')
            ->assertSee('【モック】ホームページのリニューアル準備を進めています。')
            ->assertSee('class="slider_review"', false)
            ->assertSee('お客様対応:', false)
            ->assertSee('竹村');
    }

    public function test_legacy_database_endpoints_return_mock_content(): void
    {
        $this->get('/info/index.php')
            ->assertOk()
            ->assertSee('data-mock="announcement"', false);

        $this->get('/get_review.php')
            ->assertOk()
            ->assertSee('data-mock="review"', false);

        $this->get('/getLang')
            ->assertOk()
            ->assertSeeText('jp');
    }
}

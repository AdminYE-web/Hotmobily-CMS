<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use Tests\TestCase;

class RelatedBlogsPresetTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        (require database_path('migrations/2026_11_10_000000_create_related_blogs_presets_table.php'))->up();
    }

    public function test_admin_can_reuse_update_and_delete_presets_without_changing_loaded_copies(): void
    {
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin');
        $url = '/api/v1/admin/related-blogs-presets';
        $content = ['title' => 'Related articles', 'articles' => [
            ['title' => 'Article one', 'url' => '/blog/one', 'image_url' => '/images/one.webp', 'ignored' => 'discard'],
            ['title' => 'Article two', 'url' => 'https://example.com/two', 'image_url' => '/images/two.webp', 'underline' => true],
        ], 'ignored' => 'discard'];
        $saved = $this->postJson($url, ['name' => 'Acrylic', 'content' => $content])->assertCreated();
        $id = $saved->json('data.id');
        $saved->assertJsonMissingPath('data.content_json.ignored')->assertJsonMissingPath('data.content_json.articles.0.ignored');
        $this->getJson($url)->assertOk()->assertJsonCount(1, 'data')->assertJsonMissingPath('data.0.content_json');
        $copy = $this->getJson($url.'/'.$id)->assertOk()->json('data.content_json');
        $this->assertSame('Article one', $copy['articles'][0]['title']);
        $this->assertFalse($copy['articles'][0]['underline']);
        $this->assertTrue($copy['articles'][1]['underline']);
        $content['articles'] = array_reverse($content['articles']);
        $this->putJson($url.'/'.$id, ['name' => 'Updated', 'content' => $content])->assertOk()->assertJsonPath('data.content_json.articles.0.title', 'Article two');
        $this->deleteJson($url.'/'.$id)->assertOk();
        $this->getJson($url.'/'.$id)->assertNotFound();
        $this->getJson($url)->assertJsonCount(0, 'data');
        $this->assertSame('Article one', $copy['articles'][0]['title']);
    }

    public function test_validation_rejects_empty_duplicate_oversized_and_unsafe_presets(): void
    {
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin');
        $url = '/api/v1/admin/related-blogs-presets';
        $content = ['title' => 'Blogs', 'articles' => [['title' => 'One', 'url' => '/blog/one', 'image_url' => '/one.webp']]];
        $this->postJson($url, ['name' => 'Set', 'content' => $content])->assertCreated();
        $this->postJson($url, ['name' => 'Set', 'content' => $content])->assertUnprocessable()->assertJsonValidationErrors('name');
        $content['articles'][0]['url'] = 'javascript:alert(1)';
        $this->postJson($url, ['name' => 'Unsafe', 'content' => $content])->assertUnprocessable()->assertJsonValidationErrors('content.articles.0.url');
        $content['articles'] = [[]];
        $this->postJson($url, ['name' => 'Empty', 'content' => $content])->assertUnprocessable();
        $content['articles'] = array_fill(0, 21, ['title' => 'Too many']);
        $this->postJson($url, ['name' => 'Large', 'content' => $content])->assertUnprocessable()->assertJsonValidationErrors('content.articles');
    }

    public function test_authentication_is_required(): void
    {
        $url = '/api/v1/admin/related-blogs-presets';
        $this->getJson($url)->assertUnauthorized();
        $this->getJson($url.'/1')->assertUnauthorized();
        $this->postJson($url, [])->assertUnauthorized();
        $this->putJson($url.'/1', [])->assertUnauthorized();
        $this->deleteJson($url.'/1')->assertUnauthorized();
    }
}

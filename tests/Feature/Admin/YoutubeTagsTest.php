<?php
namespace Tests\Feature\Admin;
use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductLayout;
use App\Support\YoutubeTagsContent;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
class YoutubeTagsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        (require database_path('migrations/2026_10_22_000000_create_product_content_revisions_table.php'))->up();
        Schema::create('product_layouts', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->default('Gallery');
            $table->string('slug')->default('gallery');
            $table->string('status')->default('draft');
            $table->text('draft_layout_json')->nullable();
            $table->text('published_layout_json')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
        Schema::create('products', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('product_layout_id')->nullable();
            $table->string('status')->default('draft');
            $table->timestamps();
        });
        Schema::create('product_pages', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->text('draft_content_json')->nullable();
            $table->text('published_content_json')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
        Schema::create('faqs', function (Blueprint $table): void {
            $table->id();
            $table->string('material')->nullable();
            $table->string('question_name')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('category')->nullable();
            $table->string('entry_type')->nullable();
            $table->integer('sort_order')->default(0);
        });
    }


    private function product(): Product
    {
        $schema=['version'=>2,'rows'=>[['id'=>'r1','columns'=>[['id'=>'c1','width'=>12,'blocks'=>[['id'=>'video1','type'=>'youtube','settings'=>[]]]]]]]];
        $layout=ProductLayout::create(['draft_layout_json'=>$schema,'published_layout_json'=>$schema]);
        return Product::create(['product_layout_id'=>$layout->id]);
    }
    private function video(): array
    {
        return array_replace(YoutubeTagsContent::defaults(),['youtube_url'=>'https://www.youtube.com/watch?v=5KK0a4b1C9Q','thumbnail_url'=>'/products/img/rubber-production-yt.webp','tags'=>[
            ['id'=>'second','label'=>'7 business days','url'=>'/faq/delivery'],
            ['id'=>'first','label'=>'In-house production','url'=>''],
        ]]);
    }
    private function renderVideo(array $content): string
    {
        return view('products.partials.block',['block'=>['id'=>'video1','type'=>'youtube'],'contents'=>['video1'=>$content]])->render();
    }
    public function test_save_reload_publish_keeps_tag_order_links_colors_and_video_fields(): void
    {
        $this->actingAs(new Admin(['email'=>'qa@example.test']),'admin');$product=$this->product();$video=$this->video();$video['tag_background_color']='#123ABC';$video['tag_text_color']='#EEEEEE';
        $this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['video1'=>$video]])->assertOk();
        $this->getJson('/api/v1/admin/products/'.$product->id.'/page')->assertOk()->assertJsonPath('data.content.blocks.video1.tags.0.id','second')->assertJsonPath('data.content.blocks.video1.tags.0.url','/faq/delivery')->assertJsonPath('data.content.blocks.video1.tag_background_color','#123abc')->assertJsonPath('data.content.blocks.video1.youtube_url',$video['youtube_url']);
        $this->postJson('/api/v1/admin/products/'.$product->id.'/page/publish')->assertOk();$saved=$product->page()->first()->published_content_json['blocks']['video1'];
        $this->assertSame($video['tags'],$saved['tags']);$this->assertSame('#eeeeee',$saved['tag_text_color']);$this->assertTrue($saved['tags_enabled']);
        $video['tags_enabled']=false;$this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['video1'=>$video]])->assertOk();$this->assertFalse($product->page()->first()->draft_content_json['blocks']['video1']['tags_enabled']);
    }
    public function test_invalid_links_colors_duplicate_ids_and_tag_limit_are_rejected_without_overwriting(): void
    {
        $this->actingAs(new Admin(['email'=>'qa@example.test']),'admin');$product=$this->product();$video=$this->video();$this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['video1'=>$video]])->assertOk();
        foreach(['javascript:alert(1)','//external.test/a','data:text/html,bad','/\\external.test/a'] as $url){$bad=$video;$bad['tags'][0]['url']=$url;$this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['video1'=>$bad]])->assertUnprocessable();}
        $bad=$video;$bad['tags'][1]['id']='second';$this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['video1'=>$bad]])->assertUnprocessable();
        $bad=$video;$bad['tag_background_color']='red;display:none';$this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['video1'=>$bad]])->assertUnprocessable();
        $bad=$video;$bad['tags']=array_map(fn($n)=>['id'=>'tag-'.$n,'label'=>'Tag '.$n,'url'=>''],range(1,51));$this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['video1'=>$bad]])->assertUnprocessable();
        $this->assertSame($video['tags'],$product->page()->first()->draft_content_json['blocks']['video1']['tags']);
    }
    public function test_render_tags_below_video_as_links_or_text_with_legacy_and_hidden_states(): void
    {
        $video=$this->video();$html=$this->renderVideo($video);$this->assertStringContainsString('class="store-youtube-tags"',$html);$this->assertStringContainsString('href="/faq/delivery"',$html);$this->assertStringContainsString('<span class="store-youtube-tag">In-house production</span>',$html);$this->assertLessThan(strpos($html,'class="store-youtube-tags"'),strpos($html,'class="store-youtube-player"'));
        $video['tags'][0]['label']='<script>bad</script>';$html=$this->renderVideo($video);$this->assertStringContainsString('&lt;script&gt;bad&lt;/script&gt;',$html);$this->assertStringNotContainsString('<script>bad',$html);
        $video['tags_enabled']=false;$this->assertStringNotContainsString('class="store-youtube-tags"',$this->renderVideo($video));
        $this->assertStringNotContainsString('class="store-youtube-tags"',$this->renderVideo(['youtube_id'=>'5KK0a4b1C9Q']));
        $video['tags_enabled']=true;$video['youtube_id']='invalid';$video['youtube_url']='';$this->assertStringNotContainsString('class="store-youtube-tags"',$this->renderVideo($video));
    }
}

<?php
namespace Tests\Feature\Admin;
use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductLayout;
use App\Models\GalleryPage;
use App\Models\AcrylicGallery;
use App\Services\GalleryItems;
use App\Support\GalleryShowcaseContent;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
class GalleryShowcaseTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        (require database_path('migrations/2026_09_21_000000_create_acrylic_gallery_tables.php'))->up();
        (require database_path('migrations/2026_09_21_010000_create_gallery_pages_table.php'))->up();
        (require database_path('migrations/2026_09_21_030000_add_heading_to_gallery_pages_table.php'))->up();
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


    private function source(): array
    {
        $page = GalleryPage::where('public_slug', 'rubberkeyholder')->firstOrFail();
        $item = AcrylicGallery::create(['type'=>$page->gallery_type, 'arr_img'=>'one.webp,two.webp', 'arr_txt1'=>'Red、Company，Red', 'arr_txt2'=>'Customer']);
        return [$page, $item];
    }
    public function test_api_is_authenticated_and_includes_each_image_with_tags_and_archive(): void
    {
        [$page, $item] = $this->source();
        $this->getJson('/api/v1/admin/gallery-showcase/pages')->assertUnauthorized();
        $this->actingAs(new Admin(['email'=>'qa@example.test']), 'admin');
        $this->getJson('/api/v1/admin/gallery-showcase/pages')->assertOk()->assertJsonFragment(['public_slug'=>'rubberkeyholder']);
        $response = $this->getJson('/api/v1/admin/gallery-showcase/pages/'.$page->id)->assertOk();
        $items = $response->json('data.items');
        $this->assertSame(['Red','Company'], $items[0]['tags']);
        $this->assertSame($item->id, $items[0]['gallery_id']);
        $this->assertNotSame($items[0]['key'], $items[1]['key']);
        $this->assertCount(2, $items[0]['images']);
        $this->assertGreaterThan(2, count($items));
        $page->update(['is_active'=>false]);
        $this->getJson('/api/v1/admin/gallery-showcase/pages/'.$page->id)->assertNotFound();
    }
    public function test_layout_save_publish_and_references_keep_titles_order_but_not_copied_tags_or_urls(): void
    {
        [$page, $item] = $this->source();
        $choices = (new GalleryItems)->choices($page);
        $layout = ProductLayout::create([]);
        $schema = ['version'=>2, 'rows'=>[['id'=>'r1','columns'=>[['id'=>'c1','width'=>12,'blocks'=>[
            ['id'=>'gs1','type'=>'gallery_showcase','settings'=>['showcase'=>['title'=>'Default','columns'=>4,'show_tags'=>false]]],
            ['id'=>'a1','type'=>'accordion','settings'=>['title'=>'Examples'],'children'=>[['id'=>'gs2','type'=>'gallery_showcase','settings'=>[]]]],
        ]]]]]];
        $this->actingAs(new Admin(['email'=>'qa@example.test']), 'admin');
        $this->putJson('/api/v1/admin/product-layouts/'.$layout->id.'/layout', $schema)->assertOk();
        $this->assertSame(4, $layout->fresh()->draft_layout_json['rows'][0]['columns'][0]['blocks'][0]['settings']['showcase']['columns']);
        $layout->update(['published_layout_json'=>$schema]);
        $product=Product::create(['product_layout_id'=>$layout->id]);
        $data=array_replace(GalleryShowcaseContent::defaults(), ['gallery_page_id'=>$page->id,'description'=>'<p><b>Hello</b></p><script>bad()</script>', 'items'=>[
            ['key'=>$choices[1]['key'],'title'=>'Second','image_url'=>'https://forged.test/image.jpg','tags'=>['forged']],
            ['key'=>$choices[0]['key'],'title'=>'First'],
        ]]);
        $this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['gs1'=>$data,'gs2'=>$data]])->assertOk();
        $this->postJson('/api/v1/admin/products/'.$product->id.'/page/publish')->assertOk();
        $saved=$product->page()->first()->published_content_json['blocks']['gs1'];
        $this->assertSame($choices[1]['key'],$saved['items'][0]['key']);
        $this->assertSame('Second',$saved['items'][0]['title']);
        $this->assertArrayNotHasKey('tags',$saved['items'][0]);
        $this->assertArrayNotHasKey('image_url',$saved['items'][0]);
        $this->assertStringNotContainsString('<script',$saved['description']);
        $data['items'][1]['key']=$data['items'][0]['key'];
        $this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['gs1'=>$data]])->assertUnprocessable();
    }
    public function test_render_resolves_current_tags_order_and_missing_images_without_using_snapshot_urls(): void
    {
        [$page,$item]=$this->source();
        AcrylicGallery::create(['type'=>$page->gallery_type, 'arr_img'=>'unselected.webp', 'arr_txt1'=>'Unselected & Tag']);
        $choices=(new GalleryItems)->choices($page);
        $choices=array_values(array_filter($choices,fn($choice)=>$choice['gallery_id']===$item->id));
        $content=array_replace(GalleryShowcaseContent::defaults(),['gallery_page_id'=>$page->id,'title'=>'Examples','items'=>[
            ['key'=>$choices[1]['key'],'title'=>'Second'],['key'=>'missing','title'=>'Removed'],['key'=>$choices[0]['key'],'title'=>'First'],
        ]]);
        $render=fn()=>view('products.partials.gallery-showcase',['content'=>$content,'settings'=>[], 'safeUrl'=>fn($url)=>$url])->render();
        $html=$render();
        $menu=(new GalleryItems)->tagOptions($page);
        preg_match_all('/data-gs-tag="([^"]+)"/', $html, $matches);
        $this->assertSame($menu, $matches[1]);
        $this->assertCount(11, $matches[1]);
        $this->assertStringNotContainsString('data-gs-tag="Unselected &amp; Tag"',$html);
        $this->assertStringContainsString('?tag='.rawurlencode($menu[0]),$html);
        $this->assertStringNotContainsString('<button type="button" data-gs-tag',$html);
        $this->assertStringNotContainsString('Removed',$html);
        $this->assertLessThan(strpos($html,'>First</h4>'),strpos($html,'>Second</h4>'));
        $this->assertStringContainsString('/gallery/rubberkeyholder',$html);
        $item->update(['arr_txt1'=>'Blue','arr_img'=>'two.webp']);
        $html=$render();
        $this->assertStringContainsString('data-gs-tag="'.$menu[0].'"',$html);
        $this->assertStringNotContainsString('>First</h4>',$html);
        $page->update(['is_active'=>false]);
        $this->assertStringNotContainsString('gs-card-title',$render());
    }
    public function test_direct_uploads_save_publish_and_render_without_requiring_a_gallery(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');$this->actingAs(new Admin(['email'=>'qa@example.test']),'admin');
        $schema=['version'=>2,'rows'=>[['id'=>'r1','columns'=>[['id'=>'c1','width'=>12,'blocks'=>[['id'=>'gs1','type'=>'gallery_showcase','settings'=>[]]]]]]]];
        $layout=ProductLayout::create(['draft_layout_json'=>$schema,'published_layout_json'=>$schema]);$product=Product::create(['product_layout_id'=>$layout->id]);
        $upload=$this->post('/api/v1/admin/products/'.$product->id.'/images',['image'=>\Illuminate\Http\UploadedFile::fake()->image('showcase.png',32,32)],['Accept'=>'application/json'])->assertCreated();
        $data=array_replace(GalleryShowcaseContent::defaults(),['items'=>[['key'=>'upload-one','source'=>'upload','title'=>'Custom image','image_url'=>$upload->json('data.url')]]]);
        $this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['gs1'=>$data]])->assertOk();$this->postJson('/api/v1/admin/products/'.$product->id.'/page/publish')->assertOk();
        $saved=$product->page()->first()->published_content_json['blocks']['gs1'];$this->assertNull($saved['gallery_page_id']);$this->assertEquals($data['items'],$saved['items']);
        $html=view('products.partials.gallery-showcase',['content'=>$saved,'settings'=>[],'safeUrl'=>fn($url)=>$url])->render();$this->assertStringContainsString('Custom image',$html);$this->assertStringContainsString($upload->json('data.url'),$html);$this->assertStringNotContainsString('data-gs-tag=',$html);
        foreach(['','javascript:alert(1)','//external.test/image.png','data:image/png,bad'] as $url){$bad=$data;$bad['items'][0]['image_url']=$url;$this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['gs1'=>$bad]])->assertUnprocessable();}
        $this->assertEquals($data['items'],$product->page()->first()->draft_content_json['blocks']['gs1']['items']);
    }
    public function test_mixed_sources_preserve_order_and_gallery_items_still_require_a_gallery(): void
    {
        [$page,$item]=$this->source();$reference=(new GalleryItems)->choices($page)[0];
        $input=array_replace(GalleryShowcaseContent::defaults(),['gallery_page_id'=>$page->id,'items'=>[
            ['key'=>'custom','source'=>'upload','title'=>'Uploaded first','image_url'=>'/custom.png'],
            ['key'=>$reference['key'],'title'=>'Gallery second','image_url'=>'/forged.png'],
        ]]);
        $saved=GalleryShowcaseContent::normalize($input);$this->assertSame('upload',$saved['items'][0]['source']);$this->assertSame('/custom.png',$saved['items'][0]['image_url']);$this->assertArrayNotHasKey('image_url',$saved['items'][1]);
        $html=view('products.partials.gallery-showcase',['content'=>$saved,'settings'=>[],'safeUrl'=>fn($url)=>$url])->render();$this->assertLessThan(strpos($html,'Gallery second'),strpos($html,'Uploaded first'));
        $input['gallery_page_id']=null;$this->expectException(\Illuminate\Validation\ValidationException::class);GalleryShowcaseContent::normalize($input);
    }

}

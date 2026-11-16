<?php
namespace Tests\Feature\Admin;
use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductLayout;
use App\Support\ButtonGroupContent;
use App\Support\TextLinkDownload;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
class ButtonGroupTest extends TestCase
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
        $schema=['version'=>2,'rows'=>[['id'=>'r1','columns'=>[['id'=>'c1','width'=>12,'blocks'=>[['id'=>'buttons','type'=>'button','settings'=>[]]]]]]]];
        $layout=ProductLayout::create(['draft_layout_json'=>$schema,'published_layout_json'=>$schema]);
        return Product::create(['product_layout_id'=>$layout->id]);
    }
    private function button(string $id='order',string $style='solid'): array
    {
        return array_merge(ButtonGroupContent::appearance($style),['id'=>$id,'text'=>'Order','url'=>'/products/acrylic','target'=>'_self','link_mode'=>'link','icon'=>'cart','file_path'=>'','file_name'=>'','file_size'=>0]);
    }
    private function group(): array
    {
        $link=$this->button();$file=$this->button('download','card');$file['link_mode']='download';$file['icon']='download';$file['text']="Download template\nFile";$file['file_path']='products/1/content-files/aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee.txt';$file['file_name']='Template.txt';$file['file_size']=20;
        return array_replace(ButtonGroupContent::defaults(),['items'=>[$link,$file]]);
    }
    private function renderButtons(array $content): string
    {
        return view('products.partials.block',['block'=>['id'=>'buttons','type'=>'button'],'contents'=>['buttons'=>$content]])->render();
    }
    public function test_upload_save_reload_publish_and_download_file_preserve_button_configuration(): void
    {
        Storage::fake('public');$this->actingAs(new Admin(['email'=>'qa@example.test']),'admin');$product=$this->product();
        $upload=$this->post('/api/v1/admin/products/'.$product->id.'/files',['file'=>UploadedFile::fake()->createWithContent('Template.txt','Button download contents')],['Accept'=>'application/json'])->assertCreated();
        $group=$this->group();$group['columns']=3;$group['mobile_columns']=2;$group['gap']=20;$group['items'][0]['target']='_blank';$group['items'][0]['font_size']=26;$group['items'][0]['icon_size']=64;$group['items'][1]['file_path']=$upload->json('data.path');
        $this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['buttons'=>$group]])->assertOk();
        $this->getJson('/api/v1/admin/products/'.$product->id.'/page')->assertOk()->assertJsonPath('data.content.blocks.buttons.columns',3)->assertJsonPath('data.content.blocks.buttons.items.0.font_size',26)->assertJsonPath('data.content.blocks.buttons.items.0.icon_size',64)->assertJsonPath('data.content.blocks.buttons.items.1.file_path',$upload->json('data.path'))->assertJsonPath('data.content.blocks.buttons.items.1.style','card');
        $this->postJson('/api/v1/admin/products/'.$product->id.'/page/publish')->assertOk();$saved=$product->page()->first()->published_content_json['blocks']['buttons'];
        $this->assertEquals($group,$saved);$this->get(TextLinkDownload::url($saved['items'][1]))->assertOk()->assertDownload('Template.txt')->assertHeader('X-Content-Type-Options','nosniff');
        $html=$this->renderButtons($saved);$this->assertStringContainsString('target="_blank" rel="noopener noreferrer"',$html);$this->assertStringContainsString('download="Template.txt"',$html);$this->assertStringContainsString('store-group-button--card',$html);$this->assertStringContainsString('--bg-columns:3',$html);
    }
    public function test_invalid_urls_missing_downloads_colors_ids_and_columns_are_rejected_without_overwriting(): void
    {
        $this->actingAs(new Admin(['email'=>'qa@example.test']),'admin');$product=$this->product();$group=$this->group();$this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['buttons'=>$group]])->assertOk();
        foreach(['javascript:alert(1)','//external.test/a','data:text/html,bad','/\\external.test/a'] as $url){$bad=$group;$bad['items'][0]['url']=$url;$this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['buttons'=>$bad]])->assertUnprocessable();}
        foreach(['file_path'=>'','background_color'=>'red;display:none','id'=>'order','icon_size'=>121] as $key=>$value){$bad=$group;$bad['items'][1][$key]=$value;$this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['buttons'=>$bad]])->assertUnprocessable();}
        $bad=$group;$bad['items'][1]['file_path']='../../.env';$this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['buttons'=>$bad]])->assertUnprocessable();
        $bad=$group;$bad['columns']=5;$this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['buttons'=>$bad]])->assertUnprocessable();
        $this->assertEquals($group,$product->page()->first()->draft_content_json['blocks']['buttons']);
    }
    public function test_legacy_button_render_and_save_remain_single_button_until_converted(): void
    {
        $legacy=['text'=>'Existing button','url'=>'/faq/order'];$html=$this->renderButtons($legacy);$this->assertStringContainsString('class="store-button"',$html);$this->assertStringNotContainsString('class="store-button-group"',$html);$this->assertStringContainsString('Existing button',$html);
        $this->actingAs(new Admin(['email'=>'qa@example.test']),'admin');$product=$this->product();$this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['buttons'=>$legacy]])->assertOk();$this->assertSame($legacy,$product->page()->first()->draft_content_json['blocks']['buttons']);
    }
    public function test_all_content_editors_validate_group_fields_and_render_escapes_button_text(): void
    {
        $group=$this->group();$group['items'][0]['text']='<script>bad</script>';$html=$this->renderButtons($group);$this->assertStringContainsString('&lt;script&gt;bad&lt;/script&gt;',$html);$this->assertStringNotContainsString('<script>bad',$html);
        foreach([\App\Http\Controllers\Api\V1\Admin\ProductDataPageController::class,\App\Http\Controllers\Api\V1\Admin\CustomPageController::class,\App\Http\Controllers\Api\V1\Admin\GuidePageController::class] as $class){$controller=app($class);$method=new \ReflectionMethod($controller,'sanitizeBlockContent');$this->assertEquals($group,$method->invoke($controller,'button',$group));}
    }
    public function test_uploaded_icon_persists_renders_and_requires_a_safe_image_url(): void
    {
        Storage::fake('public');$this->actingAs(new Admin(['email'=>'qa@example.test']),'admin');$product=$this->product();
        $image=$this->post('/api/v1/admin/products/'.$product->id.'/images',['image'=>UploadedFile::fake()->image('icon.png',32,32)],['Accept'=>'application/json'])->assertCreated();
        $group=$this->group();$group['items'][0]['icon']='upload';$group['items'][0]['icon_image_url']=$image->json('data.url');
        $this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['buttons'=>$group]])->assertOk();
        $saved=$product->page()->first()->draft_content_json['blocks']['buttons'];$this->assertSame($group['items'][0]['icon_image_url'],$saved['items'][0]['icon_image_url']);
        $this->assertStringContainsString('<img src="'.$image->json('data.url').'" alt="" loading="lazy">',$this->renderButtons($saved));
        foreach(['','javascript:alert(1)','data:image/svg+xml,bad','//external.test/icon.png'] as $url){$bad=$group;$bad['items'][0]['icon_image_url']=$url;$this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['buttons'=>$bad]])->assertUnprocessable();}
        $group['items'][0]['icon']='none';$group['items'][0]['icon_image_url']='';$this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['buttons'=>$group]])->assertOk();
        $this->assertStringNotContainsString('<img src="'.$image->json('data.url').'"',$this->renderButtons($group));
    }

}

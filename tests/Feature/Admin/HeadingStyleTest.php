<?php
namespace Tests\Feature\Admin;
use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductLayout;
use App\Support\HeadingContent;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
class HeadingStyleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        (require database_path('migrations/2026_11_16_000000_create_heading_presets_table.php'))->up();
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
        $schema=['version'=>2,'rows'=>[['id'=>'r1','columns'=>[['id'=>'c1','width'=>12,'blocks'=>[['id'=>'heading1','type'=>'heading','settings'=>[]]]]]]]];
        $layout=ProductLayout::create(['draft_layout_json'=>$schema,'published_layout_json'=>$schema]);
        return Product::create(['product_layout_id'=>$layout->id]);
    }
    public function test_presets_require_authentication_and_save_style_only_with_independent_copies(): void
    {
        $url='/api/v1/admin/heading-presets';$this->getJson($url)->assertUnauthorized();$this->postJson($url,[])->assertUnauthorized();$this->putJson($url.'/1',[])->assertUnauthorized();$this->deleteJson($url.'/1')->assertUnauthorized();
        $this->actingAs(new Admin(['email'=>'qa@example.test']),'admin');$style=HeadingContent::defaults();$style['text']='Do not copy this heading';
        $created=$this->postJson($url,['name'=>'Orange underline','content'=>$style])->assertCreated();$id=$created->json('data.id');$copy=$created->json('data.content_json');$this->assertArrayNotHasKey('text',$copy);
        $this->getJson($url)->assertOk()->assertJsonCount(1,'data');$this->getJson($url.'/'.$id)->assertOk()->assertJsonPath('data.content_json.alignment','center');
        $style['alignment']='right';$this->putJson($url.'/'.$id,['name'=>'Right aligned','content'=>$style])->assertOk()->assertJsonPath('data.content_json.alignment','right');$this->assertSame('center',$copy['alignment']);
        $this->deleteJson($url.'/'.$id)->assertOk();$this->getJson($url.'/'.$id)->assertNotFound();$this->getJson($url)->assertJsonCount(0,'data');
    }
    public function test_save_reload_publish_and_render_heading_appearance_preserves_text_and_legacy_format(): void
    {
        $this->actingAs(new Admin(['email'=>'qa@example.test']),'admin');$product=$this->product();$style=array_replace(HeadingContent::defaults(),['alignment'=>'right','background_color'=>'#123ABC','underline_color'=>'#ABCDEF','text_color'=>'#ffffff']);$data=['text'=>'My title','heading_style'=>$style];
        $this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['heading1'=>$data]])->assertOk();
        $this->getJson('/api/v1/admin/products/'.$product->id.'/page')->assertOk()->assertJsonPath('data.content.blocks.heading1.heading_style.alignment','right')->assertJsonPath('data.content.blocks.heading1.heading_style.background_color','#123abc');
        $this->postJson('/api/v1/admin/products/'.$product->id.'/page/publish')->assertOk();$saved=$product->page()->first()->published_content_json['blocks']['heading1'];
        $html=view('products.partials.block',['block'=>['id'=>'heading1','type'=>'heading'],'contents'=>['heading1'=>$saved]])->render();$this->assertStringContainsString('My title',$html);$this->assertStringContainsString('--heading-align:right',$html);$this->assertStringContainsString('--heading-line-color:#abcdef',$html);
        $legacy=['text'=>'Legacy'];$this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['heading1'=>$legacy]])->assertOk();$this->assertSame($legacy,$product->page()->first()->draft_content_json['blocks']['heading1']);
    }
    public function test_invalid_style_and_duplicate_preset_names_are_rejected(): void
    {
        $this->actingAs(new Admin(['email'=>'qa@example.test']),'admin');$url='/api/v1/admin/heading-presets';$style=HeadingContent::defaults();$this->postJson($url,['name'=>'One','content'=>$style])->assertCreated();$this->postJson($url,['name'=>'One','content'=>$style])->assertUnprocessable();
        foreach(['alignment'=>'justify','background_color'=>'red;display:none','underline_color'=>'bad','underline_width'=>20,'show_underline'=>'invalid'] as $key=>$value){$bad=$style;$bad[$key]=$value;$this->postJson($url,['name'=>'Bad','content'=>$bad])->assertUnprocessable();}
        $this->getJson($url)->assertJsonCount(1,'data');
    }
}

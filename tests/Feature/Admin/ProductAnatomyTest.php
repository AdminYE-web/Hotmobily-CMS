<?php
namespace Tests\Feature\Admin;
use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductLayout;
use App\Support\ProductAnatomyContent;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
class ProductAnatomyTest extends TestCase
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


    private function layout(): array
    {
        return ['version'=>2,'rows'=>[['id'=>'r1','columns'=>[['id'=>'c1','width'=>12,'blocks'=>[
            ['id'=>'anatomy1','type'=>'product_anatomy','settings'=>[]],
            ['id'=>'accordion1','type'=>'accordion','settings'=>['title'=>'Details'],'children'=>[['id'=>'anatomy2','type'=>'product_anatomy','settings'=>[]]]],
        ]]]]]];
    }
    private function product(): Product
    {
        $layout=ProductLayout::create(['draft_layout_json'=>$this->layout(),'published_layout_json'=>$this->layout()]);
        return Product::create(['product_layout_id'=>$layout->id]);
    }
    public function test_layout_and_content_save_reload_publish_preserve_callouts_and_coordinates(): void
    {
        $this->actingAs(new Admin(['email'=>'qa@example.test']),'admin');$product=$this->product();
        $this->putJson('/api/v1/admin/product-layouts/'.$product->product_layout_id.'/layout',$this->layout())->assertOk();
        $data=ProductAnatomyContent::example();$data['items'][0]['label_x']=-12.5;$data['items'][0]['label_y']=41.75;$data['items'][0]['x']=24.25;$data['items'][0]['y']=32.5;$data['items'][0]['description'].='<script>bad()</script>';
        $this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['anatomy1'=>$data,'anatomy2'=>$data]])->assertOk();
        $this->getJson('/api/v1/admin/products/'.$product->id.'/page')->assertOk()->assertJsonPath('data.content.blocks.anatomy1.items.0.label_x',-12.5)->assertJsonPath('data.content.blocks.anatomy1.items.0.label_y',41.75)->assertJsonPath('data.content.blocks.anatomy1.items.0.x',24.25)->assertJsonPath('data.content.blocks.anatomy2.left_mobile_image',$data['left_mobile_image']);
        $this->postJson('/api/v1/admin/products/'.$product->id.'/page/publish')->assertOk();$saved=$product->page()->first()->published_content_json['blocks']['anatomy1'];
        $this->assertStringContainsString('left:-12.5%;top:41.75%',$html=view('products.partials.block',['block'=>['id'=>'anatomy1','type'=>'product_anatomy'],'contents'=>['anatomy1'=>$saved]])->render());$this->assertCount(5,$saved['items']);$this->assertStringNotContainsString('<script',$saved['items'][0]['description']);$this->assertSame('#part_keyholder',$saved['items'][0]['url']);$this->assertTrue($saved['details_enabled']);
        $html=view('products.partials.block',['block'=>['id'=>'anatomy1','type'=>'product_anatomy'],'contents'=>['anatomy1'=>$saved]])->render();
        $this->assertStringContainsString('class="product-anatomy pa-pulse"',$html);$this->assertStringContainsString('x2="24.25" y2="32.5"',$html);$this->assertStringContainsString('href="#part_keyholder"',$html);$this->assertStringContainsString('base_3mm.webp',$html);$this->assertStringContainsString('<source media="(max-width:600px)"',$html);
    }
    public function test_validation_rejects_unsafe_images_links_and_invalid_coordinates_without_replacing_saved_content(): void
    {
        $this->actingAs(new Admin(['email'=>'qa@example.test']),'admin');$product=$this->product();$data=ProductAnatomyContent::example();$this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['anatomy1'=>$data]])->assertOk();
        foreach(['javascript:alert(1)','//external.test/a','data:image/svg+xml,bad'] as $url){$bad=$data;$bad['left_image']=$url;$this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['anatomy1'=>$bad]])->assertUnprocessable();}
        foreach(['x'=>101,'y'=>-1,'label_x'=>101,'label_y'=>200,'side'=>'above','url'=>'javascript:alert(1)'] as $key=>$value){$bad=$data;$bad['items'][0][$key]=$value;$this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['anatomy1'=>$bad]])->assertUnprocessable();}
        $bad=$data;$bad['items'][1]['id']=$bad['items'][0]['id'];$this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['anatomy1'=>$bad]])->assertUnprocessable();
        $this->assertSame($data['left_image'],$product->page()->first()->draft_content_json['blocks']['anatomy1']['left_image']);
    }
    public function test_independent_component_copies_optional_details_and_empty_state(): void
    {
        $data=ProductAnatomyContent::normalize(ProductAnatomyContent::example());$data['details_enabled']=false;$data['pulse']=false;
        $html=view('products.partials.block',['block'=>['id'=>'anatomy1','type'=>'product_anatomy'],'contents'=>['anatomy1'=>$data]])->render();$this->assertStringNotContainsString('class="pa-details"',$html);$this->assertStringNotContainsString('product-anatomy pa-pulse',$html);
        foreach([\App\Http\Controllers\Api\V1\Admin\ProductDataPageController::class,\App\Http\Controllers\Api\V1\Admin\CustomPageController::class,\App\Http\Controllers\Api\V1\Admin\GuidePageController::class] as $class){$method=new \ReflectionMethod($class,'sanitizeBlockContent');$this->assertEquals($data,$method->invoke(app($class),'product_anatomy',$data));}
        $html=view('products.partials.block',['block'=>['id'=>'empty','type'=>'product_anatomy'],'contents'=>[]])->render();$this->assertStringNotContainsString('<section class="product-anatomy',$html);
    }
}

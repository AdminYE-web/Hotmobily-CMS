<?php
namespace Tests\Feature\Admin;
use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductLayout;
use App\Support\CustomTableBusinessDays;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
class CustomTableBusinessDaysTest extends TestCase
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


    private function table(): array
    {
        return array_replace(CustomTableBusinessDays::defaults(), ['title'=>'Shipping prices', 'description'=>'<p>Delivery information <a href="https://example.test/guide">Guide</a></p><script>bad()</script>', 'enable_business_days_switch'=>true,
            'rows'=>[['id'=>'r1','cells'=>[
                ['id'=>'price','width'=>50,'content'=>'528円 (52,800円)'],
                ['id'=>'date','width'=>50,'content'=>'11/25(水)','business_days'=>'10'],
            ]]],
        ]);
    }
    private function product(): Product
    {
        $schema=['version'=>2,'rows'=>[['id'=>'r1','columns'=>[['id'=>'c1','width'=>12,'blocks'=>[['id'=>'table1','type'=>'custom_table','settings'=>[]]]]]]]];
        $layout=ProductLayout::create(['draft_layout_json'=>$schema,'published_layout_json'=>$schema]);
        return Product::create(['product_layout_id'=>$layout->id]);
    }
    private function renderTable(array $table): string
    {
        return view('products.partials.block',['block'=>['id'=>'table1','type'=>'custom_table'], 'contents'=>['table1'=>$table]])->render();
    }
    public function test_save_reload_publish_keeps_switch_settings_and_separate_days(): void
    {
        $this->actingAs(new Admin(['email'=>'qa@example.test']),'admin');
        $product=$this->product();$table=$this->table();$table['show_business_days']=false;$table['business_days_label']='Show working days';
        $this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['table1'=>$table]])->assertOk();
        $this->getJson('/api/v1/admin/products/'.$product->id.'/page')->assertOk()->assertJsonPath('data.content.blocks.table1.enable_business_days_switch',true)->assertJsonPath('data.content.blocks.table1.show_business_days',false)->assertJsonPath('data.content.blocks.table1.rows.0.cells.1.business_days',10);
        $this->postJson('/api/v1/admin/products/'.$product->id.'/page/publish')->assertOk();
        $saved=$product->page()->first()->published_content_json['blocks']['table1'];
        $this->assertStringContainsString('Delivery information', $saved['description']);
        $this->assertStringContainsString('https://example.test/guide', $saved['description']);
        $this->assertStringNotContainsString('<script', $saved['description']);
        $this->assertSame('Show working days',$saved['business_days_label']);$this->assertSame('11/25(水)',$saved['rows'][0]['cells'][1]['content']);$this->assertNull($saved['rows'][0]['cells'][0]['business_days']);
        $saved['rows'][0]['cells'][1]['business_days']=0;
        $this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['table1'=>$saved]])->assertOk();
        $this->assertSame(0,$product->page()->first()->draft_content_json['blocks']['table1']['rows'][0]['cells'][1]['business_days']);
    }
    public function test_invalid_days_and_settings_are_rejected_without_changing_saved_table(): void
    {
        $this->actingAs(new Admin(['email'=>'qa@example.test']),'admin');$product=$this->product();$table=$this->table();
        $this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['table1'=>$table]])->assertOk();
        foreach([-1,1.5,3651,'not days'] as $invalid){$bad=$table;$bad['rows'][0]['cells'][1]['business_days']=$invalid;$this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['table1'=>$bad]])->assertUnprocessable();}
        $bad=$table;$bad['enable_business_days_switch']='wrong';$this->putJson('/api/v1/admin/products/'.$product->id.'/page',['blocks'=>['table1'=>$bad]])->assertUnprocessable();
        $this->assertSame(10,$product->page()->first()->draft_content_json['blocks']['table1']['rows'][0]['cells'][1]['business_days']);
    }
    public function test_frontend_switch_defaults_and_legacy_cells_keep_dates_and_prices(): void
    {
        $table=$this->table();$html=$this->renderTable($table);
        $this->assertStringContainsString('store-custom-table-description', $html);
        $this->assertStringContainsString('Delivery information', $html);
        $this->assertStringNotContainsString('<script', $html);
        $this->assertStringContainsString('data-custom-table-days-toggle checked',$html);
        $this->assertStringContainsString('data-custom-table-day-count >10日</span>',$html);
        $this->assertStringContainsString('11/25(水)',$html);$this->assertStringContainsString('528円 (52,800円)',$html);
        $table['show_business_days']=false;$html=$this->renderTable($table);$this->assertStringContainsString('data-custom-table-day-count  hidden >10日</span>',$html);
        $table['enable_business_days_switch']=false;$html=$this->renderTable($table);$this->assertStringNotContainsString('data-custom-table-days-toggle',$html);$this->assertStringNotContainsString(' hidden >10日',$html);
        $table=['title'=>'Legacy','rows'=>[['cells'=>[['width'=>100,'content'=>"11/25(水)\n10日"]]]]];
        $html=$this->renderTable($table);$this->assertStringNotContainsString('data-custom-table-days-toggle',$html);$this->assertStringContainsString('10日',$html);
    }
}

<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\ProductOption;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Tests\TestCase;

class ProductOptionBulkUploadTest extends TestCase
{
    private string $temporaryPublic;

    protected function setUp(): void
    {
        parent::setUp();
        Schema::create('option_groups', function (Blueprint $table): void {
            $table->id(); $table->boolean('is_active')->default(true);
        });
        Schema::create('product_options', function (Blueprint $table): void {
            $table->id(); $table->unsignedBigInteger('option_group_id');
            $table->string('option_code', 100); $table->string('option_name');
            $table->json('option_images'); $table->boolean('is_active'); $table->boolean('is_disabled');
            $table->string('color_code')->nullable(); $table->text('option_detail')->nullable(); $table->text('disable_text')->nullable();
            $table->timestamps(); $table->unique(['option_group_id', 'option_code']);
        });
        (require database_path('migrations/2026_11_10_000400_add_bulk_upload_key_to_product_options_table.php'))->up();
        DB::table('option_groups')->insert([['id' => 1, 'is_active' => true], ['id' => 2, 'is_active' => true], ['id' => 3, 'is_active' => false]]);
        $this->temporaryPublic = sys_get_temp_dir().DIRECTORY_SEPARATOR.'hotmobily-option-bulk-'.Str::uuid();
        File::ensureDirectoryExists($this->temporaryPublic);
        $this->app->usePublicPath($this->temporaryPublic);
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin');
    }

    protected function tearDown(): void
    {
        $resolved = realpath($this->temporaryPublic);
        if ($resolved && str_starts_with($resolved, realpath(sys_get_temp_dir()).DIRECTORY_SEPARATOR) && str_starts_with(basename($resolved), 'hotmobily-option-bulk-')) File::deleteDirectory($resolved);
        parent::tearDown();
    }

    private function upload(string $name, ?string $key = null, int $group = 1)
    {
        $path = $this->temporaryPublic.DIRECTORY_SEPARATOR.'incoming-'.Str::uuid().'.png';
        File::put($path, base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+a3ioAAAAASUVORK5CYII='));
        return $this->postJson(route('admin.product-options.bulk-upload'), [
            'option_group_id' => $group, 'upload_id' => $key ?? (string) Str::uuid(), 'image' => new UploadedFile($path, $name, 'image/png', null, true),
        ]);
    }

    public function test_fifty_images_create_fifty_active_options_with_filename_names_and_codes(): void
    {
        for ($i = 1; $i <= 50; $i++) {
            $this->upload('attachment_'.$i.'.png')->assertCreated()->assertJsonPath('data.option_name', 'attachment_'.$i)->assertJsonPath('data.option_code', 'attachment_'.$i);
        }
        $this->assertSame(50, ProductOption::count());
        $this->assertSame(50, ProductOption::where('is_active', true)->where('is_disabled', false)->count());
        $this->assertCount(50, File::files(public_path('product-options')));
        foreach (ProductOption::all() as $option) {
            $this->assertCount(1, $option->option_images);
            $this->assertFileExists(public_path('product-options/'.$option->option_images[0]));
        }
    }

    public function test_duplicate_names_unicode_and_retries_are_handled_without_overwriting(): void
    {
        $key = (string) Str::uuid();
        $first = $this->upload('strap red.png', $key)->assertCreated()->assertJsonPath('data.option_code', 'strap red');
        $this->upload('strap red.png', $key)->assertOk()->assertJsonPath('data.created', false)->assertJsonPath('data.id', $first->json('data.id'));
        $this->upload('strap red.jpg')->assertCreated()->assertJsonPath('data.option_code', 'strap red_2')->assertJsonPath('data.option_name', 'strap red');
        $unicode = $this->upload('ストラップ.png')->assertCreated()->assertJsonPath('data.option_code', 'ストラップ');
        $this->upload('strap red.png', group: 2)->assertCreated()->assertJsonPath('data.option_code', 'strap red');
        $this->upload('strap red.png', $key, 2)->assertConflict();
        $this->assertSame(4, ProductOption::count());
        $this->assertCount(4, File::files(public_path('product-options')));
        $option = ProductOption::findOrFail($unicode->json('data.id'));
        $this->put(route('admin.product-options.update', $option), ['option_group_id' => 1, 'option_code' => 'ストラップ', 'option_name' => 'Edited', 'is_active' => 1])->assertSessionHasNoErrors()->assertRedirect();
        $this->assertSame('Edited', $option->fresh()->option_name);
    }

    public function test_invalid_uploads_create_no_options_or_images(): void
    {
        $url = route('admin.product-options.bulk-upload');
        $this->postJson($url, ['option_group_id' => 1, 'upload_id' => (string) Str::uuid(), 'image' => UploadedFile::fake()->create('fake.png', 10, 'text/plain')])->assertUnprocessable()->assertJsonValidationErrors('image');
        $this->postJson($url, ['option_group_id' => 1, 'upload_id' => (string) Str::uuid(), 'image' => UploadedFile::fake()->image('large.png')->size(5121)])->assertUnprocessable()->assertJsonValidationErrors('image');
        $this->upload('image.png', group: 3)->assertUnprocessable()->assertJsonValidationErrors('option_group_id');
        $this->assertSame(0, ProductOption::count());
        $this->assertFalse(File::exists(public_path('product-options')));
    }

    public function test_failed_database_write_removes_the_uploaded_image(): void
    {
        ProductOption::creating(static function (): void {throw new \RuntimeException('Simulated database failure');});
        try {
            $this->upload('failed.png')->assertStatus(500);
            $this->assertSame(0, ProductOption::count());
            $this->assertCount(0, File::files(public_path('product-options')));
        } finally {
            ProductOption::flushEventListeners();
        }
    }

    public function test_guest_cannot_upload(): void
    {
        auth('admin')->logout();
        $this->upload('private.png')->assertUnauthorized();
        $this->assertSame(0, ProductOption::count());
    }
}

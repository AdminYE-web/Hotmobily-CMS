<?php

namespace Tests\Unit;

use App\Models\Review;
use App\Services\ReviewImporter;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ReviewImporterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::dropIfExists('reviews_hm');
        Schema::create('reviews_hm', function (Blueprint $table): void {
            $table->id();
            $table->text('comment')->nullable();
            $table->integer('service')->nullable();
            $table->integer('product')->nullable();
            $table->string('product_type', 100)->nullable();
            $table->text('images')->nullable();
            $table->text('sale_name')->nullable();
            $table->dateTime('date_reviews')->nullable();
            $table->integer('row_stamp')->nullable();
        });

        config()->set([
            'reviews.google.api_key' => 'test-api-key',
            'reviews.google.spreadsheet_id' => 'test-spreadsheet',
            'reviews.google.sheet_name' => 'Form Responses 1',
            'reviews.google.first_data_row' => 2,
            'reviews.fallback_sale_name' => 'Other',
        ]);
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('reviews_hm');

        parent::tearDown();
    }

    public function test_it_imports_new_rows_and_maps_legacy_columns(): void
    {
        Http::fake([
            'https://sheets.googleapis.com/*' => Http::response([
                'values' => [
                    [
                        '2026-09-01 06:47:00',
                        'Great service',
                        '6',
                        '4',
                        '',
                        '',
                        'Rubber Strap',
                        '',
                    ],
                    ['', '', '', '', '', '', '', ''],
                ],
            ]),
        ]);

        $result = app(ReviewImporter::class)->import();

        $this->assertSame(2, $result['start_row']);
        $this->assertSame(1, $result['imported']);
        $this->assertSame(1, $result['skipped']);

        $this->assertDatabaseHas('reviews_hm', [
            'row_stamp' => 2,
            'comment' => 'Great service',
            'service' => 5,
            'product' => 4,
            'product_type' => 'Rubber Strap',
            'sale_name' => 'Other',
            'images' => '',
        ]);
    }

    public function test_it_starts_after_the_latest_sheet_row(): void
    {
        Review::query()->create([
            'row_stamp' => 7,
            'service' => 5,
            'product' => 5,
        ]);

        Http::fake([
            'https://sheets.googleapis.com/*' => Http::response([
                'values' => [
                    [
                        '2026-09-02 06:47:00',
                        'New review',
                        '5',
                        '5',
                    ],
                ],
            ]),
        ]);

        $result = app(ReviewImporter::class)->import();

        $this->assertSame(8, $result['start_row']);
        $this->assertDatabaseHas('reviews_hm', [
            'row_stamp' => 8,
            'comment' => 'New review',
        ]);

        Http::assertSent(fn ($request): bool => str_contains(
            $request->url(),
            'A8%3AH'
        ));
    }

    public function test_it_can_limit_the_number_of_sheet_rows(): void
    {
        Http::fake([
            'https://sheets.googleapis.com/*' => Http::response([
                'values' => [
                    ['2026-09-03 06:47:00', 'Review 1', '5', '5'],
                    ['2026-09-04 06:47:00', 'Review 2', '5', '4'],
                ],
            ]),
        ]);

        $result = app(ReviewImporter::class)->import(false, 2);

        $this->assertSame(2, $result['imported']);
        $this->assertDatabaseCount('reviews_hm', 2);
        Http::assertSent(fn ($request): bool => str_contains(
            $request->url(),
            'A2%3AH3'
        ));
    }
}

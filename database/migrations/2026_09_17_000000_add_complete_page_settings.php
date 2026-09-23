<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $addedGroupSettings = false;
        $addedItemSettings = false;

        if (Schema::hasTable('products') && ! Schema::hasColumn('products', 'complete_head_text')) {
            Schema::table('products', function (Blueprint $table): void {
                $table->text('complete_head_text')->nullable();
            });
        }

        if (Schema::hasTable('product_option_groups') && ! Schema::hasColumn('product_option_groups', 'show_in_complete_summary')) {
            $addedGroupSettings = true;
            Schema::table('product_option_groups', function (Blueprint $table): void {
                $table->boolean('show_in_complete_summary')->default(false);
                $table->string('complete_summary_label', 255)->nullable();
                $table->unsignedInteger('complete_summary_sort_order')->default(0);
                $table->boolean('show_in_complete_price_summary')->default(false);
                $table->string('complete_price_summary_label', 255)->nullable();
                $table->unsignedInteger('complete_price_summary_sort_order')->default(0);
                $table->unsignedBigInteger('complete_price_summary_option_id')->nullable();
                $table->index(
                    ['product_id', 'show_in_complete_summary', 'complete_summary_sort_order'],
                    'product_option_groups_complete_summary_index'
                );
                $table->index(
                    ['product_id', 'show_in_complete_price_summary', 'complete_price_summary_sort_order'],
                    'product_option_groups_complete_price_summary_index'
                );
            });
        }

        if (Schema::hasTable('product_option_group_items') && ! Schema::hasColumn('product_option_group_items', 'show_in_complete_summary')) {
            $addedItemSettings = true;
            Schema::table('product_option_group_items', function (Blueprint $table): void {
                $table->boolean('show_in_complete_summary')->default(false);
                $table->string('complete_summary_label', 255)->nullable();
                $table->unsignedInteger('complete_summary_sort_order')->default(0);
                $table->boolean('show_in_complete_price_summary')->default(false);
                $table->string('complete_price_summary_label', 255)->nullable();
                $table->unsignedInteger('complete_price_summary_sort_order')->default(0);
                $table->unsignedBigInteger('complete_price_summary_option_id')->nullable();
                $table->index(
                    ['product_option_group_id', 'show_in_complete_summary', 'complete_summary_sort_order'],
                    'product_option_group_items_complete_summary_index'
                );
                $table->index(
                    ['product_option_group_id', 'show_in_complete_price_summary', 'complete_price_summary_sort_order'],
                    'product_option_group_items_complete_price_summary_index'
                );
            });
        }

        if (! Schema::hasTable('product_complete_summary_custom_rows')) {
            Schema::create('product_complete_summary_custom_rows', function (Blueprint $table): void {
                $table->id();
                $table->unsignedBigInteger('product_id');
                $table->unsignedInteger('sort_order')->default(0);
                $table->string('label', 255);
                $table->text('content')->nullable();
                $table->timestamps();
                $table->index(
                    ['product_id', 'sort_order', 'id'],
                    'product_complete_summary_custom_rows_product_sort_index'
                );
            });
        }

        if ($addedGroupSettings
            && Schema::hasTable('product_option_groups')
            && Schema::hasColumn('product_option_groups', 'show_in_confirm_summary')
            && Schema::hasColumn('product_option_groups', 'show_in_confirm_price_summary')) {
            DB::table('product_option_groups')->update([
                'show_in_complete_summary' => DB::raw('show_in_confirm_summary'),
                'complete_summary_label' => DB::raw('confirm_summary_label'),
                'complete_summary_sort_order' => DB::raw('confirm_summary_sort_order'),
                'show_in_complete_price_summary' => DB::raw('show_in_confirm_price_summary'),
                'complete_price_summary_label' => DB::raw('confirm_price_summary_label'),
                'complete_price_summary_sort_order' => DB::raw('confirm_price_summary_sort_order'),
                'complete_price_summary_option_id' => DB::raw('confirm_price_summary_option_id'),
            ]);
        }

        if ($addedItemSettings
            && Schema::hasTable('product_option_group_items')
            && Schema::hasColumn('product_option_group_items', 'show_in_confirm_summary')
            && Schema::hasColumn('product_option_group_items', 'show_in_confirm_price_summary')) {
            DB::table('product_option_group_items')->update([
                'show_in_complete_summary' => DB::raw('show_in_confirm_summary'),
                'complete_summary_label' => DB::raw('confirm_summary_label'),
                'complete_summary_sort_order' => DB::raw('confirm_summary_sort_order'),
                'show_in_complete_price_summary' => DB::raw('show_in_confirm_price_summary'),
                'complete_price_summary_label' => DB::raw('confirm_price_summary_label'),
                'complete_price_summary_sort_order' => DB::raw('confirm_price_summary_sort_order'),
                'complete_price_summary_option_id' => DB::raw('confirm_price_summary_option_id'),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('product_complete_summary_custom_rows');

        if (Schema::hasTable('product_option_group_items') && Schema::hasColumn('product_option_group_items', 'show_in_complete_summary')) {
            Schema::table('product_option_group_items', function (Blueprint $table): void {
                $table->dropIndex('product_option_group_items_complete_summary_index');
                $table->dropIndex('product_option_group_items_complete_price_summary_index');
                $table->dropColumn([
                    'show_in_complete_summary',
                    'complete_summary_label',
                    'complete_summary_sort_order',
                    'show_in_complete_price_summary',
                    'complete_price_summary_label',
                    'complete_price_summary_sort_order',
                    'complete_price_summary_option_id',
                ]);
            });
        }

        if (Schema::hasTable('product_option_groups') && Schema::hasColumn('product_option_groups', 'show_in_complete_summary')) {
            Schema::table('product_option_groups', function (Blueprint $table): void {
                $table->dropIndex('product_option_groups_complete_summary_index');
                $table->dropIndex('product_option_groups_complete_price_summary_index');
                $table->dropColumn([
                    'show_in_complete_summary',
                    'complete_summary_label',
                    'complete_summary_sort_order',
                    'show_in_complete_price_summary',
                    'complete_price_summary_label',
                    'complete_price_summary_sort_order',
                    'complete_price_summary_option_id',
                ]);
            });
        }

        if (Schema::hasTable('products') && Schema::hasColumn('products', 'complete_head_text')) {
            Schema::table('products', function (Blueprint $table): void {
                $table->dropColumn('complete_head_text');
            });
        }
    }
};

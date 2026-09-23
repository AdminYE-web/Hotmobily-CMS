<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('product_option_groups')
            && ! Schema::hasColumn('product_option_groups', 'show_in_admin_order_detail_summary')) {
            Schema::table('product_option_groups', function (Blueprint $table): void {
                $table->boolean('show_in_admin_order_detail_summary')->default(false);
                $table->string('admin_order_detail_summary_label', 255)->nullable();
                $table->unsignedInteger('admin_order_detail_summary_sort_order')->default(0);
                $table->boolean('show_in_admin_order_detail_price_summary')->default(false);
                $table->string('admin_order_detail_price_summary_label', 255)->nullable();
                $table->unsignedInteger('admin_order_detail_price_summary_sort_order')->default(0);
                $table->unsignedBigInteger('admin_order_detail_price_summary_option_id')->nullable();
                $table->index(
                    ['product_id', 'show_in_admin_order_detail_summary', 'admin_order_detail_summary_sort_order'],
                    'product_option_groups_admin_order_detail_summary_index'
                );
                $table->index(
                    ['product_id', 'show_in_admin_order_detail_price_summary', 'admin_order_detail_price_summary_sort_order'],
                    'product_option_groups_admin_order_detail_price_index'
                );
            });

            if (Schema::hasColumn('product_option_groups', 'show_in_complete_summary')) {
                DB::table('product_option_groups')->update([
                    'show_in_admin_order_detail_summary' => DB::raw('show_in_complete_summary'),
                    'admin_order_detail_summary_label' => DB::raw('complete_summary_label'),
                    'admin_order_detail_summary_sort_order' => DB::raw('complete_summary_sort_order'),
                    'show_in_admin_order_detail_price_summary' => DB::raw('show_in_complete_price_summary'),
                    'admin_order_detail_price_summary_label' => DB::raw('complete_price_summary_label'),
                    'admin_order_detail_price_summary_sort_order' => DB::raw('complete_price_summary_sort_order'),
                    'admin_order_detail_price_summary_option_id' => DB::raw('complete_price_summary_option_id'),
                ]);
            }
        }

        if (Schema::hasTable('product_option_group_items')
            && ! Schema::hasColumn('product_option_group_items', 'show_in_admin_order_detail_summary')) {
            Schema::table('product_option_group_items', function (Blueprint $table): void {
                $table->boolean('show_in_admin_order_detail_summary')->default(false);
                $table->string('admin_order_detail_summary_label', 255)->nullable();
                $table->unsignedInteger('admin_order_detail_summary_sort_order')->default(0);
                $table->boolean('show_in_admin_order_detail_price_summary')->default(false);
                $table->string('admin_order_detail_price_summary_label', 255)->nullable();
                $table->unsignedInteger('admin_order_detail_price_summary_sort_order')->default(0);
                $table->unsignedBigInteger('admin_order_detail_price_summary_option_id')->nullable();
                $table->index(
                    ['product_option_group_id', 'show_in_admin_order_detail_summary', 'admin_order_detail_summary_sort_order'],
                    'product_option_group_items_admin_order_detail_summary_index'
                );
                $table->index(
                    ['product_option_group_id', 'show_in_admin_order_detail_price_summary', 'admin_order_detail_price_summary_sort_order'],
                    'product_option_group_items_admin_order_detail_price_index'
                );
            });

            if (Schema::hasColumn('product_option_group_items', 'show_in_complete_summary')) {
                DB::table('product_option_group_items')->update([
                    'show_in_admin_order_detail_summary' => DB::raw('show_in_complete_summary'),
                    'admin_order_detail_summary_label' => DB::raw('complete_summary_label'),
                    'admin_order_detail_summary_sort_order' => DB::raw('complete_summary_sort_order'),
                    'show_in_admin_order_detail_price_summary' => DB::raw('show_in_complete_price_summary'),
                    'admin_order_detail_price_summary_label' => DB::raw('complete_price_summary_label'),
                    'admin_order_detail_price_summary_sort_order' => DB::raw('complete_price_summary_sort_order'),
                    'admin_order_detail_price_summary_option_id' => DB::raw('complete_price_summary_option_id'),
                ]);
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('product_option_group_items')
            && Schema::hasColumn('product_option_group_items', 'show_in_admin_order_detail_summary')) {
            Schema::table('product_option_group_items', function (Blueprint $table): void {
                $table->dropIndex('product_option_group_items_admin_order_detail_summary_index');
                $table->dropIndex('product_option_group_items_admin_order_detail_price_index');
                $table->dropColumn([
                    'show_in_admin_order_detail_summary',
                    'admin_order_detail_summary_label',
                    'admin_order_detail_summary_sort_order',
                    'show_in_admin_order_detail_price_summary',
                    'admin_order_detail_price_summary_label',
                    'admin_order_detail_price_summary_sort_order',
                    'admin_order_detail_price_summary_option_id',
                ]);
            });
        }

        if (Schema::hasTable('product_option_groups')
            && Schema::hasColumn('product_option_groups', 'show_in_admin_order_detail_summary')) {
            Schema::table('product_option_groups', function (Blueprint $table): void {
                $table->dropIndex('product_option_groups_admin_order_detail_summary_index');
                $table->dropIndex('product_option_groups_admin_order_detail_price_index');
                $table->dropColumn([
                    'show_in_admin_order_detail_summary',
                    'admin_order_detail_summary_label',
                    'admin_order_detail_summary_sort_order',
                    'show_in_admin_order_detail_price_summary',
                    'admin_order_detail_price_summary_label',
                    'admin_order_detail_price_summary_sort_order',
                    'admin_order_detail_price_summary_option_id',
                ]);
            });
        }
    }
};

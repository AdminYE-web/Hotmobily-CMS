<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_content_revisions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('version');
            $table->string('action', 32);
            $table->json('snapshot_json');
            $table->string('snapshot_hash', 64);
            $table->string('created_by')->nullable();
            $table->timestamps();
            $table->unique(['product_id', 'version']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_content_revisions');
    }
};

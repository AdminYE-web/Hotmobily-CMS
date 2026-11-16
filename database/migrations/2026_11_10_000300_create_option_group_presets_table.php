<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('option_group_presets', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('option_group_id')->constrained('option_groups')->cascadeOnDelete();
            $table->string('name', 150);
            $table->json('content_json');
            $table->timestamps();
            $table->unique(['option_group_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('option_group_presets');
    }
};

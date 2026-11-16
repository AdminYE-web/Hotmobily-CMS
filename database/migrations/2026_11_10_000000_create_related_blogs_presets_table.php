<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('related_blogs_presets', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 150)->unique();
            $table->json('content_json');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('related_blogs_presets');
    }
};

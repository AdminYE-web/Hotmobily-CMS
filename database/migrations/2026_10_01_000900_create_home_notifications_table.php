<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_notifications', function (Blueprint $table): void {
            $table->id();
            $table->string('title', 100);
            $table->text('message')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::table('home_notifications')->insert([
            'id' => 1,
            'title' => 'お知らせ',
            'message' => '現在お知らせはありません。',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('home_notifications');
    }
};

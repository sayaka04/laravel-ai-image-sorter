<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            // Explicitly linking to 'albums' table
            $table->foreignId('album_id')->constrained('albums')->cascadeOnDelete();
            $table->string('category_name');
            $table->text('ai_rules')->nullable(); // Stores instructions for the AI
            $table->timestamps();

            $table->unique(['album_id', 'category_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};

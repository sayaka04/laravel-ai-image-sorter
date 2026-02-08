<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();

            $table->string('file_name');
            $table->string('file_path', 500);

            // Using JSON type allows you to store the full AI response object
            $table->json('raw_ai_response')->nullable();

            $table->timestamps();

            $table->unique(['category_id', 'file_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};

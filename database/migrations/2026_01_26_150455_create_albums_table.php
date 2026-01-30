<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->id();

            // Automatically creates 'user_id' column and links it to 'users' table
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('album_name');
            $table->text('description')->nullable(); // Nullable because description is optional

            $table->timestamps(); // Creates created_at and updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('albums');
    }
};

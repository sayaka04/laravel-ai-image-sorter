<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('upload_queues', function (Blueprint $table) {
            $table->id();

            $table->foreignId('album_id')->constrained('albums')->cascadeOnDelete();

            $table->string('file_path', 500); // 500 chars to be safe for deep paths
            $table->string('original_filename')->nullable();

            // Enum restricts values to these 3 options
            // Index added for faster querying when looking for 'pending' jobs
            $table->enum('status', [
                'pending',
                'image_processing',
                'final_processing',
                'failed',
                'completed',
            ])
                ->default('pending')
                ->index();


            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('upload_queues');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(); // Judul foto (opsional)
            $table->text('description')->nullable(); // Deskripsi singkat (opsional)
            $table->string('image_path'); // Path file gambar
            $table->boolean('is_active')->default(true); // Status tampil/tidak
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
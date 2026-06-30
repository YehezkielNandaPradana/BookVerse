<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('publisher_id')->constrained('publishers')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('isbn')->unique();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->integer('publication_year');
            $table->string('language')->default('Indonesia');
            $table->integer('pages');
            $table->string('cover')->nullable();
            $table->string('barcode')->unique();
            $table->string('edition')->nullable();
            $table->integer('stock')->default(0);
            $table->integer('available_stock')->default(0);
            $table->enum('status', ['available', 'unavailable'])->default('available');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};

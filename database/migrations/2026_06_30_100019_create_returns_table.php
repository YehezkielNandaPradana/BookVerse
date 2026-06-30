<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrowing_id')->constrained('borrowings')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('returned_by')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->date('return_date');
            $table->integer('late_days')->default(0);
            $table->decimal('total_fine', 10, 2)->default(0.00);
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};

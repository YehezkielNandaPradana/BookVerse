<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('book_id')->constrained('books')->cascadeOnUpdate()->restrictOnDelete();
            $table->dateTime('reservation_date');
            $table->dateTime('expired_at');
            $table->enum('status', ['pending', 'approved', 'expired', 'completed'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};

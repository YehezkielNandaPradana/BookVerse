<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fine_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fine_id')->constrained('fines')->cascadeOnUpdate()->restrictOnDelete();
            $table->dateTime('payment_date');
            $table->decimal('amount', 10, 2);
            $table->string('method');
            $table->string('proof')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fine_payments');
    }
};

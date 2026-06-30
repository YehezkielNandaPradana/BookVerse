<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('library_name');
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->integer('borrow_limit')->default(5);
            $table->integer('borrow_duration')->default(7); // in days
            $table->decimal('fine_per_day', 10, 2)->default(1000.00);
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};

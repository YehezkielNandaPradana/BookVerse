<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('librarian_id')->constrained('librarians')->cascadeOnUpdate()->restrictOnDelete();
            $table->date('borrow_date');
            $table->date('due_date');
            $table->enum('status', ['pending', 'approved', 'borrowed', 'returned', 'cancelled'])->default('pending');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};

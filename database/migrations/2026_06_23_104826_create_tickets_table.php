<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('tickets', function (Blueprint $table) {
        $table->id();

        $table->string('ticket_number')->unique();

        $table->string('title');

        $table->foreignId('category_id')
              ->constrained()
              ->restrictOnDelete();

        $table->foreignId('priority_id')
              ->constrained()
              ->restrictOnDelete();

        $table->enum('status', [
            'OPEN',
            'IN_PROGRESS',
            'WAITING',
            'RESOLVED',
            'CLOSED'
        ])->default('OPEN');

        // User pembuat ticket
        $table->foreignId('created_by')
              ->constrained('users')
              ->restrictOnDelete();

        // Department yang saat ini bertanggung jawab
        $table->foreignId('current_department_id')
              ->constrained('departments')
              ->restrictOnDelete();

        // Agent yang sedang menangani
        $table->foreignId('current_handler_id')
              ->nullable()
              ->constrained('users')
              ->nullOnDelete();

        // Agent yang menyelesaikan
        $table->foreignId('resolved_by')
              ->nullable()
              ->constrained('users')
              ->nullOnDelete();

        $table->timestamp('resolved_at')
              ->nullable();

        $table->timestamp('closed_at')
              ->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};

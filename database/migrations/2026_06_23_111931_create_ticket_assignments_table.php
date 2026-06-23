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
    Schema::create('ticket_assignments', function (Blueprint $table) {
        $table->id();

        $table->foreignId('ticket_id')
              ->constrained()
              ->cascadeOnDelete();

        // siapa agent yang menangani
        $table->foreignId('assigned_to')
              ->nullable()
              ->constrained('users')
              ->nullOnDelete();

        // department yang memiliki antrian tiket saat itu
        $table->foreignId('department_id')
              ->constrained()
              ->restrictOnDelete();

        // siapa yang melakukan assign/escalate
        $table->foreignId('assigned_by')
              ->nullable()
              ->constrained('users')
              ->nullOnDelete();

        $table->timestamp('assigned_at');

        // kapan ownership berakhir
        $table->timestamp('ended_at')
              ->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_assignments');
    }
};

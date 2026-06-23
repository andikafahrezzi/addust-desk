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
    Schema::create('ticket_events', function (Blueprint $table) {
        $table->id();

        $table->foreignId('ticket_id')
              ->constrained()
              ->cascadeOnDelete();

        // siapa yang melakukan aksi
        $table->foreignId('performed_by')
              ->nullable()
              ->constrained('users')
              ->nullOnDelete();

        $table->enum('event_type', [
            'CREATED',
            'ACCEPTED',
            'REASSIGNED',
            'ESCALATED',
            'RESOLVED',
            'CLOSED',
            'REOPENED'
        ]);

        // pesan yang akan ditampilkan di UI
        $table->text('description');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_events');
    }
};

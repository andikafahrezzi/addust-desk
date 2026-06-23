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
    Schema::create('ticket_messages', function (Blueprint $table) {
        $table->id();

        // Ticket induk
        $table->foreignId('ticket_id')
              ->constrained()
              ->cascadeOnDelete();

        // Pengirim pesan (user/agent/admin)
        $table->foreignId('sender_id')
              ->constrained('users')
              ->restrictOnDelete();

        // Isi pesan
        $table->longText('message');

        // Untuk fitur reply seperti WhatsApp
        $table->foreignId('parent_message_id')
              ->nullable()
              ->constrained('ticket_messages')
              ->nullOnDelete();

        // Menandai pesan telah diedit
        $table->timestamp('edited_at')
              ->nullable();

        // Soft delete untuk pesan
        $table->softDeletes();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_messages');
    }
};

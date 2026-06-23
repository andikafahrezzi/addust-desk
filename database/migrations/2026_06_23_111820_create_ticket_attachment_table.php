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
    Schema::create('ticket_attachments', function (Blueprint $table) {
        $table->id();

        $table->foreignId('ticket_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->foreignId('message_id')
              ->nullable()
              ->constrained('ticket_messages')
              ->cascadeOnDelete();

        $table->foreignId('uploaded_by')
              ->constrained('users')
              ->restrictOnDelete();

        $table->string('file_name');

        // nama asli file
        $table->string('original_name');

        // lokasi file di storage
        $table->string('file_path');

        // jpg, png, pdf, txt, dll
        $table->string('mime_type');

        // dalam byte
        $table->unsignedBigInteger('file_size');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_attachment');
    }
};

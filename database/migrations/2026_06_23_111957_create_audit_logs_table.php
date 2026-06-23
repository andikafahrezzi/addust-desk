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
    Schema::create('audit_logs', function (Blueprint $table) {
        $table->id();

        // User yang melakukan aksi
        $table->foreignId('user_id')
              ->nullable()
              ->constrained('users')
              ->nullOnDelete();

        // Contoh:
        // CREATE, UPDATE, DELETE, LOGIN, LOGOUT
        $table->string('action');

        // Nama tabel yang terkena perubahan
        // contoh: users, tickets, categories
        $table->string('table_name');

        // ID dari data yang berubah
        $table->unsignedBigInteger('record_id')
              ->nullable();

        // Data sebelum perubahan
        $table->json('old_values')
              ->nullable();

        // Data sesudah perubahan
        $table->json('new_values')
              ->nullable();

        // IP Address pelaku
        $table->string('ip_address')
              ->nullable();

        // Browser atau device
        $table->text('user_agent')
              ->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};

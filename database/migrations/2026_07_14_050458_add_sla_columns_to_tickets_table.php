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
        Schema::table('tickets', function (Blueprint $table) {

        $table->unsignedInteger('response_sla_minutes')
        ->after('priority_id');   

        $table->unsignedInteger('resolution_sla_minutes')
            ->after('response_sla_minutes');

        $table->dateTime('response_due_at')
            ->after('resolution_sla_minutes');

        $table->dateTime('resolution_due_at')
            ->after('response_due_at');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {

            $table->dropColumn([

                'response_sla_minutes',

                'resolution_sla_minutes',

                'response_due_at',

                'resolution_due_at',

            ]);

        });
    }
};
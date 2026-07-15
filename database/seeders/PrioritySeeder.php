<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrioritySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('priorities')->insert([
            [
                'name' => 'LOW',
                'sla_response_minutes' => 240,
                'sla_resolution_minutes' => 4320,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'MEDIUM',
                'sla_response_minutes' => 120,
                'sla_resolution_minutes' => 1440,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'HIGH',
                'sla_response_minutes' => 30,
                'sla_resolution_minutes' => 480,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'CRITICAL',
                'sla_response_minutes' => 15,
                'sla_resolution_minutes' => 240,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
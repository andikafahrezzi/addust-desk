<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'name' => 'USER',
                'description' => 'User yang membuat tiket',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'AGENT',
                'description' => 'Agent yang menangani tiket',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ADMIN',
                'description' => 'Administrator sistem',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
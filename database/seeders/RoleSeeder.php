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
            ],
            [
                'name' => 'AGENT',
                'description' => 'Agent yang menangani tiket',
            ],
            [
                'name' => 'ADMIN',
                'description' => 'Administrator sistem',
            ],
        ]);
    }
}
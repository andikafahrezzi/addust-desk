<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('departments')->insert([
            [
                'name' => 'HELPDESK',
                'description' => 'First Level Support',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'NOC',
                'description' => 'Network Operation Center',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'IT SUPPORT',
                'description' => 'General IT Support',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
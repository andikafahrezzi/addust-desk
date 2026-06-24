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
            ],
            [
                'name' => 'NOC',
                'description' => 'Network Operation Center',
            ],
            [
                'name' => 'IT SUPPORT',
                'description' => 'General IT Support',
            ],
        ]);
    }
}
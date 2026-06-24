<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'HARDWARE',
                'description' => 'Masalah perangkat keras',
            ],
            [
                'name' => 'SOFTWARE',
                'description' => 'Masalah aplikasi dan sistem',
            ],
            [
                'name' => 'NETWORK',
                'description' => 'Masalah jaringan',
            ],
            [
                'name' => 'ACCOUNT',
                'description' => 'Masalah akun dan akses',
            ],
            [
                'name' => 'OTHER',
                'description' => 'Masalah lainnya',
            ],
        ]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil role ID
        $roleAdmin = Role::where('name', 'ADMIN')->first();
        $roleAgent = Role::where('name', 'AGENT')->first();
        $roleUser = Role::where('name', 'USER')->first();

        // Ambil department ID
        $deptHelpdesk = Department::where('name', 'Helpdesk')->first();
        $deptNOC = Department::where('name', 'NOC')->first();
        $deptITSupport = Department::where('name', 'IT Support')->first();

        // ============================================
        // 1. ADMIN (1 orang)
        // ============================================
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'role_id' => $roleAdmin->id,
            'department_id' => null, // Admin tidak terikat department
            'is_active' => true,
        ]);

        // ============================================
        // 2. AGENTS (2 orang per department)
        // ============================================
        
        // Agent Helpdesk (2 orang)
        User::create([
            'name' => 'Budi Helpdesk',
            'email' => 'hp@hp.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'role_id' => $roleAgent->id,
            'department_id' => $deptHelpdesk->id,
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Siti Helpdesk',
            'email' => 'hp2@hp.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'role_id' => $roleAgent->id,
            'department_id' => $deptHelpdesk->id,
            'is_active' => true,
        ]);

        // Agent NOC (2 orang)
        User::create([
            'name' => 'Andi NOC',
            'email' => 'noc@noc.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'role_id' => $roleAgent->id,
            'department_id' => $deptNOC->id,
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Rina NOC',
            'email' => 'noc2@noc.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'role_id' => $roleAgent->id,
            'department_id' => $deptNOC->id,
            'is_active' => true,
        ]);

        // Agent IT Support (2 orang)
        User::create([
            'name' => 'Dedi IT Support',
            'email' => 'it@it.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'role_id' => $roleAgent->id,
            'department_id' => $deptITSupport->id,
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Lina IT Support',
            'email' => 'it2@it.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'role_id' => $roleAgent->id,
            'department_id' => $deptITSupport->id,
            'is_active' => true,
        ]);

        // ============================================
        // 3. USERS (2 orang user biasa)
        // ============================================
        User::create([
            'name' => 'Rudi Karyawan',
            'email' => 'user@user.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'role_id' => $roleUser->id,
            'department_id' => null, // User tidak terikat department
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Ani Karyawan',
            'email' => 'user2@user.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'role_id' => $roleUser->id,
            'department_id' => null,
            'is_active' => true,
        ]);
    }
}
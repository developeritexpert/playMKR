<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Admin', 'slug' => 'admin'],
            ['name' => 'Internal Team', 'slug' => 'internal-team'],
            ['name' => 'Sponser', 'slug' => 'sponser'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}

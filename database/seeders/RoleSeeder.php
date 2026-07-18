<?php

namespace Database\Seeders;

use App\Modules\Auth\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'label' => 'System Administrator'],
            ['name' => 'mao_personnel', 'label' => 'Municipal Agriculture Officer'],
            ['name' => 'farmer', 'label' => 'Registered Banana Grower'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['name' => $role['name']], $role);
        }
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleAdm = Role::create(['name' => 'Admin']);
        $roleReg = Role::create(['name' => 'Registrador']);
        $roleObs = Role::create(['name' => 'Observador']);
        $roleSup = Role::create(['name' => 'Supervisor']);

        Permission::create([
            'name' => 'logs.index',
            'description' => 'Ver Bitacora',
        ])->syncRoles([$roleAdm, $roleObs, $roleSup]);
    }
}

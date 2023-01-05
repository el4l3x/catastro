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

        Permission::create([
            'name' => 'roles.index',
            'description' => 'Ver Roles de Usuarios',
        ])->syncRoles([$roleAdm, $roleObs, $roleSup]);
        Permission::create([
            'name' => 'roles.create',
            'description' => 'Crear un Rol de Usuario',
        ])->syncRoles([$roleAdm, $roleReg, $roleSup]);
        Permission::create([
            'name' => 'roles.edit',
            'description' => 'Editar un Rol de Usuario',
        ])->syncRoles([$roleAdm, $roleSup]);
        Permission::create([
            'name' => 'roles.destroy',
            'description' => 'Eliminar un Rol de Usuario',
        ])->syncRoles([$roleAdm, $roleSup]);
        
        Permission::create([
            'name' => 'usuarios.index',
            'description' => 'Ver Usuarios',
        ])->syncRoles([$roleAdm, $roleObs, $roleSup]);
        Permission::create([
            'name' => 'usuarios.create',
            'description' => 'Crear un Usuario',
        ])->syncRoles([$roleAdm, $roleSup]);
        Permission::create([
            'name' => 'usuarios.edit',
            'description' => 'Editar un Usuario',
        ])->syncRoles([$roleAdm, $roleSup]);
        Permission::create([
            'name' => 'usuarios.destroy',
            'description' => 'Eliminar un Usuario',
        ])->syncRoles([$roleAdm, $roleSup]);

        Permission::create([
            'name' => 'comunas.index',
            'description' => 'Ver Comunas',
        ])->syncRoles([$roleAdm, $roleSup, $roleObs]);
        Permission::create([
            'name' => 'comunas.create',
            'description' => 'Crear una Comuna',
        ])->syncRoles([$roleAdm, $roleSup, $roleReg]);
        Permission::create([
            'name' => 'comunas.edit',
            'description' => 'Editar una Comuna',
        ])->syncRoles([$roleAdm, $roleSup]);
        Permission::create([
            'name' => 'comunas.destroy',
            'description' => 'Eliminar una Comuna',
        ])->syncRoles([$roleAdm, $roleSup]);

        Permission::create([
            'name' => 'concejos.index',
            'description' => 'Ver Concejos Comunales',
        ])->syncRoles([$roleAdm, $roleSup, $roleObs]);
        Permission::create([
            'name' => 'concejos.create',
            'description' => 'Crear un Concejo Comunal',
        ])->syncRoles([$roleAdm, $roleSup, $roleReg]);
        Permission::create([
            'name' => 'concejos.edit',
            'description' => 'Editar un Concejo Comunal',
        ])->syncRoles([$roleAdm, $roleSup]);
        Permission::create([
            'name' => 'concejos.destroy',
            'description' => 'Eliminar un Concejo Comunal',
        ])->syncRoles([$roleAdm, $roleSup]);
        
        Permission::create([
            'name' => 'parroquias.index',
            'description' => 'Ver Parroquias',
        ])->syncRoles([$roleAdm, $roleSup, $roleObs]);
        Permission::create([
            'name' => 'parroquias.create',
            'description' => 'Crear una Parroquia',
        ])->syncRoles([$roleAdm, $roleSup, $roleReg]);
        Permission::create([
            'name' => 'parroquias.edit',
            'description' => 'Editar una Parroquia',
        ])->syncRoles([$roleAdm, $roleSup]);
        Permission::create([
            'name' => 'parroquias.destroy',
            'description' => 'Eliminar una Parroquia',
        ])->syncRoles([$roleAdm, $roleSup]);
        
        Permission::create([
            'name' => 'personas.index',
            'description' => 'Ver Ciudadanos',
        ])->syncRoles([$roleAdm, $roleSup, $roleObs]);
        Permission::create([
            'name' => 'personas.create',
            'description' => 'Agregar Ciudadano',
        ])->syncRoles([$roleAdm, $roleSup, $roleReg]);
        Permission::create([
            'name' => 'personas.edit',
            'description' => 'Editar Ciudadano',
        ])->syncRoles([$roleAdm, $roleSup]);
        Permission::create([
            'name' => 'personas.destroy',
            'description' => 'Eliminar Ciudadano',
        ])->syncRoles([$roleAdm, $roleSup]);

    }
}

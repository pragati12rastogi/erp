<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $permissions = [
            'roles.index',
            'roles.create',
            'roles.edit',
            'role.delete',
            'home',
            'users.index',
            'users.create',
            'users.edit',
            'users.delete'
        ];
      
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        
    }
}

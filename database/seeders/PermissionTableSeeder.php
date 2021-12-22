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
        /* 
            [
                'name'=>'roles.index',
                'guard_name'=>'web',
                'master_name'=>'roles'
            ],
            [
                'name'=>'roles.create',
                'guard_name'=>'web',
                'master_name'=>'roles'
            ],
            [
                'name'=>'roles.edit',
                'guard_name'=>'web',
                'master_name'=>'roles'
            ],
            [
                'name'=>'role.delete',
                'guard_name'=>'web',
                'master_name'=>'roles'
            ],

            [
                'name'=>'users.index',
                'guard_name'=>'web',
                'master_name'=>'users'
            ],
            [
                'name'=>'users.create',
                'guard_name'=>'web',
                'master_name'=>'users'
            ],
            [
                'name'=>'users.edit',
                'guard_name'=>'web',
                'master_name'=>'users'
            ],
            [
                'name'=>'users.delete',
                'guard_name'=>'web',
                'master_name'=>'users'
            ],
            [
                'name'=>'category.index',
                'guard_name'=>'web',
                'master_name'=>'category'
            ],
            [
                'name'=>'category.create',
                'guard_name'=>'web',
                'master_name'=>'category'
            ],
            [
                'name'=>'category.edit',
                'guard_name'=>'web',
                'master_name'=>'category'
            ],
            [
                'name'=>'category.delete',
                'guard_name'=>'web',
                'master_name'=>'category'
            ], 
            [
                'name'=>'hsn.index',
                'guard_name'=>'web',
                'master_name'=>'hsn'
            ],
            [
                'name'=>'hsn.create',
                'guard_name'=>'web',
                'master_name'=>'hsn'
            ],
            [
                'name'=>'hsn.edit',
                'guard_name'=>'web',
                'master_name'=>'hsn'
            ],
            [
                'name'=>'hsn.delete',
                'guard_name'=>'web',
                'master_name'=>'hsn'
            ],
            [
                'name'=>'gst.index',
                'guard_name'=>'web',
                'master_name'=>'gst'
            ],
            [
                'name'=>'gst.create',
                'guard_name'=>'web',
                'master_name'=>'gst'
            ],
            [
                'name'=>'gst.edit',
                'guard_name'=>'web',
                'master_name'=>'gst'
            ],
            [
                'name'=>'gst.delete',
                'guard_name'=>'web',
                'master_name'=>'gst'
            ],
            [
                'name'=>'item.index',
                'guard_name'=>'web',
                'master_name'=>'item'
            ],
            [
                'name'=>'item.create',
                'guard_name'=>'web',
                'master_name'=>'item'
            ],
            [
                'name'=>'item.edit',
                'guard_name'=>'web',
                'master_name'=>'item'
            ],
            [
                'name'=>'item.delete',
                'guard_name'=>'web',
                'master_name'=>'item'
            ],
            */
        $permissions = [

        ];
      
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
        
    }
}

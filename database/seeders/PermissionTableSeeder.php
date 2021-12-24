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
                'name'=>'role.destroy',
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
                'name'=>'users.destroy',
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
                'name'=>'category.destroy',
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
                'name'=>'hsn.destroy',
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
                'name'=>'gst.destroy',
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
                'name'=>'item.destroy',
                'guard_name'=>'web',
                'master_name'=>'item'
            ],
            [
                'name'=>'stocks.index',
                'guard_name'=>'web',
                'master_name'=>'stocks'
            ],
            [
                'name'=>'stocks.create',
                'guard_name'=>'web',
                'master_name'=>'stocks'
            ],
            [
                'name'=>'stocks.edit',
                'guard_name'=>'web',
                'master_name'=>'stocks'
            ],
            [
                'name'=>'stocks.destroy',
                'guard_name'=>'web',
                'master_name'=>'stocks'
            ],
            [
                'name'=>'vendors.index',
                'guard_name'=>'web',
                'master_name'=>'vendors'
            ],
            [
                'name'=>'vendors.create',
                'guard_name'=>'web',
                'master_name'=>'vendors'
            ],
            [
                'name'=>'vendors.edit',
                'guard_name'=>'web',
                'master_name'=>'vendors'
            ],
            [
                'name'=>'vendors.destroy',
                'guard_name'=>'web',
                'master_name'=>'vendors'
            ]
            ,[
                'name'=>'invoice.master',
                'guard_name'=>'web',
                'master_name'=>'invoice master'
            ]
            */
        $permissions = [
            [
                'name'=>'stock-distributions.index',
                'guard_name'=>'web',
                'master_name'=>'stock distribution'
            ],
            [
                'name'=>'stock-distributions.create',
                'guard_name'=>'web',
                'master_name'=>'stock distribution'
            ],
            [
                'name'=>'stock-distributions.view',
                'guard_name'=>'web',
                'master_name'=>'stock distribution'
            ],
            [
                'name'=>'stock-distributions.destroy',
                'guard_name'=>'web',
                'master_name'=>'stock distribution'
            ]

            
        ];
      
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
        
    }
}

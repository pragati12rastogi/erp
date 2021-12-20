<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Custom\Constants;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->delete();
        
        
        $user = User::create(
            ['name' => 'SuperAdmin',
            'profile'=>null,
            'firm_name'=>'XYZ',
            'role_id'=> 1,
            'address' =>'somewhere',
            'gst_no' =>'Abcd123456789',
            'mobile' =>'9793749498',
            'state_id' =>10,
            'district'=>'Delhi',
            'email'=>'admin@erp.com',
            'email_verified_at'=>null,
            'password' => bcrypt(12345678),
            'status' => '1',
            ]
        );
        
        
        $role = Role::create(['name'=>'Admin']);
        

        $permissions = Permission::pluck('id','id')->all();
   
        $role->syncPermissions($permissions);
        
        $user->assignRole([$role->id]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'SuperAdmin',
                'profile'=>null,
                'role_id'=>1,
                'firm_name'=>'XYZ',
                'address' =>'somewhere',
                'gst_no' =>'Abcd123456789',
                'mobile' =>'9793749498',
                'state_id' =>10,
                'district'=>'Delhi',
                'email'=>'admin@erp.com',
                'email_verified_at'=>null,
                'password' => bcrypt(12345678),
                'status' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ),
        ));
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_list = Permission::create(['name'=>'users.list']);
        $user_view = Permission::create(['name'=>'users.view']);
        $user_create = Permission::create(['name'=>'users.create']);
        $user_update = Permission::create(['name'=>'users.update']);
        $user_delete = Permission::create(['name'=>'users.delete']);
        $appoinment_create = Permission::create(['name'=>'appoinment.create']);
        $appoinment_view = Permission::create(['name'=>'appoinment.view']);
        $appoinment_delete = Permission::create(['name'=>'appoinment.delete']);
        $appoinment_update = Permission::create(['name'=>'appoinment.update']);



         $admin_role = Role::create(['name'=>'admin']);
         $admin_role->givePermissionTo([

            $user_create,
            $user_list,
            $user_view,
            $user_update,
            $user_delete,
         ]);


         $admin = User::create([
                'name' => 'Admin',
                'username' => 'admin_username',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('1234'),

         ]);

         $admin->assignRole($admin_role);
         $admin->givePermissionTo([

            $user_create,
            $user_list,
            $user_view,
            $user_update,
            $user_delete,
            ]);

//user
  $user = User::create([
            'name' => 'user',
            'username' => 'user_username',
            'email' => 'user@gmail.com',
            'password' => bcrypt('1234'),

     ]);

     $user_role = Role::create(['name'=>'user']);

     $user->assignRole($user_role);
     $user->givePermissionTo([
        $user_list,
     ]);

     $user_role->givePermissionTo([
        $user_list,
     ]);

//doctor user

     $doctor = User::create([
      'name' => 'salman',
      'username' => 'salman01',
      'email' => 'doctor@gmail.com',
      'password' => bcrypt('1234'),

      ]);
      $doctor_role = Role::create(['name'=>'doctor']);
      $doctor->assignRole($doctor_role);
      $doctor->givePermissionTo([
         $appoinment_create,
         $appoinment_view,
         $appoinment_delete,
         $appoinment_update,
      ]);
      $doctor_role->givePermissionTo([
         $appoinment_create,
         $appoinment_view,
         $appoinment_delete,
         $appoinment_update,
      ]);



    }

}

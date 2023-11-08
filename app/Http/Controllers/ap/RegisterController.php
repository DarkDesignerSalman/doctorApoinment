<?php

namespace App\Http\Controllers\ap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Helpers\Helper;
use App\Http\Resources\UserResource;

use App\Models\User;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request){


         $user = User::create([

            'name'  => $request->name,
            'username'  => $request->username,
            'email'  => $request->email,
            'password'  => bcrypt($request->password) ,

         ]);
         // if($request->role=="doctor"){
         //    $doctor_role =Role::where('name' ,'doctor')->first();
         //    if($doctor_role){
         //       $user->assignRole($doctor_role);
         //    }
         // }
        
            $user_role =Role::where('name' ,'user')->first();
            if($user_role){
               $user->assignRole($user_role);
            }
         
         // if($request->role=="admin"){
         //    $admin_role =Role::where('name' ,'admin')->first();
         //    if($admin_role){
         //       $user->assignRole($admin_role);
         //    }
         // }

        return new UserResource($user);

    }
}

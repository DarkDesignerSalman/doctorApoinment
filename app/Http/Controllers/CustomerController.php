<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class CustomerController extends Controller
{
    public function login(Request $request){

        $input=$request->all();

        $validation = \Validator::make($input,[
            'email' => 'required',
            'password' => 'required',


        ]);

        if ($validation -> fails()){

            return response()->json(['error' => $validation ->errors()],422);
        }

        if(Auth::guard('customer')->attempt(['email'=>$input['email'],'password' =>$input['password']])){
             $customer = Auth::guard('customer')->user();
             $token= $customer->createToken('token',['customer'])->plainTextToken;

             return response()->json(['token' => $token,'data' => $customer]);
        }

    }

    public function allcustomer(){
        $user=Auth::user();
        return response()->json(['data' => $user]);

    }
}

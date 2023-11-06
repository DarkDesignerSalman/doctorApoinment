<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class MemberController extends Controller
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

        if(Auth::guard('member')->attempt(['email'=>$input['email'],'password' =>$input['password']])){
             $member = Auth::guard('member')->user();
             $token= $member->createToken('token',['member'])->plainTextToken;

             return response()->json(['token' => $token,'data' => $member]);
        }

    }

    public function authUser(){
        $user=Auth::user();
        return response()->json(['data' => $user]);

    }
}

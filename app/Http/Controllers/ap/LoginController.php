<?php

namespace App\Http\Controllers\ap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Helpers\Helper;
use App\Http\Resources\UserResource;
use Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request){


        if(!Auth::attempt($request->only('email','password'))){
            Helper::sendError("Email or Password is wrong");


        }

        return new UserResource(auth()->user());

    }
}

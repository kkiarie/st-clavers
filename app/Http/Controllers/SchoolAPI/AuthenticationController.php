<?php

namespace App\Http\Controllers\SchoolAPI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class AuthenticationController extends Controller
{
    //



    public function register()
    {
        return "api test";
    }


    public function login(Request $request)
    {
        $email=$request->email;
        $password=$request->password;
        $credentials = $request->validate([
                    'email' => ['required', 'email'],
                    'password' => ['required'],
                ]);
         
                if (Auth::attempt($credentials)) {
                    $user=User::whereEmail($email)->first();
                    $token =$user->createToken('sm')->plainTextToken;
                    return response([
                        // "email"=>$email,
                        "name"=>$user->name,
                        "token"=>$token,
                        "message"=>"welcome back $user->name",

                    ],200
                    );
                }
                else{

                    return  response([
                        "message"=>"Invalid credentials"
                    ],422);
                }


    }
}

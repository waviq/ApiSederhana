<?php

namespace App\Http\Controllers;

use App\Transformers\UserTransformer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request, User $user){

        $this->validate($request,[
           'name'       =>  'required',
            'email'     =>  'required|email|unique:users',
            'password'  =>  'required'
        ]);

        $user = $user->create([
            'name'      =>  $request->name,
            'email'     =>  $request->email,
            'password'  =>  bcrypt($request->password),
            'api_token' =>  bcrypt($request->email)

        ]);

        $respon =  fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->addMeta([
                'token' =>$user->api_token
            ])
            ->toArray();

        return response()->json($respon, 212);
    }

    public function login(Request $request, User $user){
        if (!Auth::attempt(
            [
                'email'     =>$request->email,
                'password'  =>$request->password,
            ])){
            return response()->json([
               'error'      =>  'user atau password salah',
            ],401);
        }
        $user = $user->find(Auth::user()->id);
        return fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->addMeta([
                'token' =>$user->api_token
            ])
            ->toArray();
    }
}

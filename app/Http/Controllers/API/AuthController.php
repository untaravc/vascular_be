<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->response['status'] = false;
        $this->response['text'] = 'Password atau email tidak sesuai.';
        $validator = Validator::make([
            'email'    => 'required',
            'password' => 'required',
        ],[
            'email.required'    => 'Email atau password tidak sesuai.',
            'password.required' => 'Email atau password tidak sesuai.',
        ]);

        if($validator->fails()){
            return $this->response;
        }

        $user = User::whereEmail($request->email)->first();
        if(!$user){
            return $this->response;
        }

        if(!Hash::check($request->password, $user->password)){
            return $this->response;
        }

        $token = $user->createToken('web');

        User::whereEmail($request->email)
            ->first()
            ->update([
            'last_login' => now()
        ]);

        $this->response['status'] = true;
        $this->response['text'] = 'Login berhasil';
        $this->response['result'] = $token->plainTextToken;
        return $this->response;
    }

    public function auth(Request $request){
        $user = $request->user();

        $this->response['result'] = $user;
        return $this->response;
    }
}

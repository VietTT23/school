<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
//dd(Hash::make(1));
        if (!empty(Auth::check()))
        {
            return redirect('/admin/dashboard');
        }
        return view('auth.login');
    }

    public function AuthLogin(Request $request)
    {
        $remember = !empty($request->remember)?true:false;
        $user = [
            'email'=>$request->email,
            'password'=>$request->password,
        ];
        if (Auth::attempt($user))
        {

            return redirect()->route('dashboard');
        }
        else
        {
            return redirect()->back()->with('error', 'Tài khoản hoặc mật khẩu không đúng');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}

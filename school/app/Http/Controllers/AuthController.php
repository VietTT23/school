<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        if (!empty(Auth::check()))
        {
            if (Auth::user()->user_type == 'admin')
            {
                return redirect()->route('admin.dashboard');
            }
            elseif (Auth::user()->user_type == 'teacher')
            {
                return redirect()->route('teacher.dashboard');
            }
            elseif (Auth::user()->user_type == 'student')
            {
                return redirect()->route('student.dashboard');
            }
            elseif (Auth::user()->user_type == 'parent')
            {
                return redirect()->route('parent.dashboard');
            }
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
            if (Auth::user()->user_type == 'admin')
            {
                return redirect()->route('admin.dashboard');
            }
            elseif (Auth::user()->user_type == 'teacher')
            {
                return redirect()->route('teacher.dashboard');
            }
            elseif (Auth::user()->user_type == 'student')
            {
                return redirect()->route('student.dashboard');
            }
            elseif (Auth::user()->user_type == 'parent')
            {
                return redirect()->route('parent.dashboard');
            }

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

    public function forgot_password()
    {
        return view('auth.forgot_password');
    }
}

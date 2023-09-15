<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

    public function post_forgot_password(Request $request)
    {
        $email = $request->email;
        $user = User::query()->where('email', '=', $email)->first();
        if (!empty($user))
        {
            $user->remember_token = Str::random(30);
            $user->save();
            Mail::to($user->email)->send(new ForgotPasswordMail($user));
            return redirect()->back()->with('success', 'Email đã được gửi. Vui lòng kiểm tra email của bạn!');

        }
        else
        {
            return redirect()->back()->with('error', 'Không tìm thấy tài khoản!');
        }
    }

    public function reset_password($remember_token)
    {
        $user = User::query()->where('remember_token', '=', $remember_token)->first();
        if (!empty($user))
        {
            return view('auth.reset_password', [
                'user'=>$user,
            ]);
        }
        else
        {
            abort(404);
        }
    }

    public function update_password($remember_token, Request $request)
    {
        if ($request->password == $request->confirm_password)
        {
            $user = User::query()->where('remember_token', '=', $remember_token)->first();
            $user->password = Hash::make($request->password);
            $user->remember_token = Str::random(30);
            $user->update();

            return redirect('/')->with('success', 'Đổi mật khẩu thành công');
        }
        else
        {
            return redirect()->back()->with('error', 'Mật khẩu không trùng khớp');
        }
    }
}

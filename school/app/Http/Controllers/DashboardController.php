<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $user_type = Auth::user()->user_type;
        $title = 'Dashboard';
        if ($user_type == 'admin')
        {
            return view('admin.dashboard', [
                'user_type'=>$user_type,
                'user'=>$user,
                'tile'=>$title,
            ]);
        }
        elseif ($user_type == 'teacher')
        {
            return view('teacher.dashboard', [
                'user_type'=>$user_type,
                'user'=>$user,
                'tile'=>$title,
            ]);
        }
        elseif ($user_type == 'student')
        {
            return view('student.dashboard', [
                'user_type'=>$user_type,
                'user'=>$user,
                'tile'=>$title,
            ]);
        }
        elseif ($user_type == 'parent')
        {
            return view('parent.dashboard',  [
                'user_type'=>$user_type,
                'user'=>$user,
                'tile'=>$title,
            ]);
        }
    }
}

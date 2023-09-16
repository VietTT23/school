<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $user_type = Auth::user()->user_type;
        $title = 'Admin List';
        $admins = User::query()->select('*')
                                ->where('user_type','=', 'admin')
                                ->where('is_delete','=','not_delete')
                                ->orderBy('created_at')
                                ->get();
        return view('admin.admin.list', [
            'user'=>$user,
            'user_type'=>$user_type,
            'title'=>$title,
            'admins'=>$admins,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $user_type = Auth::user()->user_type;
        $title = 'Add new Admin';
        return view('admin.admin.create', [
            'title'=>$title,
            'user_type'=>$user_type,
            'user'=>$user,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([
            'name'=>['required', 'string'],
            'email'=>['required', 'email', 'unique:users'],
            'password'=>['required'],
        ]);
        $user = User::query()->create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'user_type'=>'admin',
            ]);
        $user->save();
        return redirect('/admin/admin/list')->with('success', 'Thêm admin thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $user = Auth::user();
        $user_type = Auth::user()->user_type;
        $title = 'Edit Admin';
        $admins = User::query()->find($id);
        if (!empty($admins))
        {
            return view('admin.admin.edit', [
                'title'=>$title,
                'user_type'=>$user_type,
                'user'=>$user,
                'admins'=>$admins,
            ]);
        }
        else
        {
            abort(404);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        request()->validate([
            'name'=>['required', 'string'],
            'email'=>['required', 'email', 'unique:users'],
        ]);
        $password = $request->password;
        if (!empty($password))
        {
            User::query()->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($password),
            ]);
        }
        else
        {
            User::query()->where('id', '=', $id)
                ->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                ]);
        }

        return redirect('/admin/admin/list')->with('success', 'Sửa thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::query()->where('id', '=', $id)
            ->update([
                'is_delete'=>'delete',
            ]);
        return redirect('/admin/admin/list')->with('success', 'Xóa thành công!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClassRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('q');
        $user = Auth::user();
        $user_type = Auth::user()->user_type;
        $title = 'Class List';
        $class_rooms = ClassRoom::query()->select(['class_rooms.*', 'users.name as create_by_user'])
                                        ->join('users', 'users.id', '=', 'class_rooms.created_by')
                                        ->where('class_rooms.is_delete', '=', 'not_delete')
                                        ->Where(function ($query) use ($search){
                                            $query->where('class_rooms.name', 'like', '%'.$search.'%')
                                                ->orWhere('users.name', 'like', '%'.$search.'%')
                                                ->orWhere('status', '=', '%'.$search.'%');
                                        })
                                        ->orderBy('created_at')
                                        ->paginate();
        $page = $class_rooms->appends([\Illuminate\Support\Facades\Request::except('page'), 'q'=>$search])->links();

        return view('admin.class.list', [
            'user'=>$user,
            'user_type'=>$user_type,
            'title'=>$title,
            'classes'=>$class_rooms,
            'search'=>$search,
            'page'=>$page,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $user_type = Auth::user()->user_type;
        $title = 'Add new Class';

        return view('admin.class.create', [
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
            'status'=>['required'],
        ]);
        $class = ClassRoom::query()->create([
            'name'=>$request->name,
            'status'=>$request->status,
            'created_by'=>Auth::user()->id,
        ]);
        $class->save();
        return redirect('/admin/class/list')->with('success', 'Thêm class thành công!');
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
        $title = 'Edit Class';
        $class_rooms = ClassRoom::query()->find($id);
        if (!empty($class_rooms))
        {
            return view('admin.class.edit', [
                'title'=>$title,
                'user_type'=>$user_type,
                'user'=>$user,
                'classes'=>$class_rooms,
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
            'status'=>['required'],
        ]);

        ClassRoom::query()->where('id','=', $id)->update([
            'name'=>$request->name,
            'status'=>$request->status,
        ]);

        return redirect('/admin/class/list')->with('success', 'Sửa thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ClassRoom::query()->where('id', '=', $id)
            ->update([
                'is_delete'=>'delete',
            ]);
        return redirect('/admin/class/list')->with('success', 'Xóa thành công!');
    }
}

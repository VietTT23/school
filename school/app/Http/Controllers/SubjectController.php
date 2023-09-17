<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('q');
        $user = Auth::user();
        $user_type = Auth::user()->user_type;
        $title = 'Subjects List';
        $subjects = Subject::query()->select(['subjects.*', 'users.name as create_by_user'])
            ->join('users', 'users.id', '=', 'subjects.created_by')
            ->where('subjects.is_delete', '=', 'not_delete')
            ->Where(function ($query) use ($search){
                $query->where('subjects.name', 'like', '%'.$search.'%')
                    ->orWhere('users.name', 'like', '%'.$search.'%')
                    ->orWhere('subjects.type', 'like', '%'.$search.'%')
                    ->orWhere('status', '=', '%'.$search.'%');
            })
            ->orderBy('created_at')
            ->paginate();
        $page = $subjects->appends([\Illuminate\Support\Facades\Request::except('page'), 'q'=>$search])->links();

        return view('admin.subject.list', [
            'user'=>$user,
            'user_type'=>$user_type,
            'title'=>$title,
            'subjects'=>$subjects,
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
        $title = 'Add new Subject';

        return view('admin.subject.create', [
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
            'type'=>['required', 'string'],
            'status'=>['required'],
        ]);
        $subject = Subject::query()->create([
            'name'=>$request->name,
            'type'=>$request->type,
            'status'=>$request->status,
            'created_by'=>Auth::user()->id,
        ]);
        $subject->save();
        return redirect('/admin/subject/list')->with('success', 'Thêm class thành công!');
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
        $title = 'Edit Subject';
        $subjects = Subject::query()->find($id);
        if (!empty($subjects))
        {
            return view('admin.subject.edit', [
                'title'=>$title,
                'user_type'=>$user_type,
                'user'=>$user,
                'subjects'=>$subjects,
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
            'type'=>['required', 'string'],
            'status'=>['required'],
        ]);

        Subject::query()->where('id','=', $id)->update([
            'name'=>$request->name,
            'type'=>$request->type,
            'status'=>$request->status,
        ]);

        return redirect('/admin/subject/list')->with('success', 'Sửa thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Subject::query()->where('id', '=', $id)
            ->update([
                'is_delete'=>'delete',
            ]);
        return redirect('/admin/subject/list')->with('success', 'Xóa thành công!');
    }
}

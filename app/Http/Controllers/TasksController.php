<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;    // 追加

class TasksController extends Controller
{
    // getでtasks/にアクセスされた場合の一覧表示処理
    public function index()
    {
        $tasks = Task::all();
        
        return view('tasks.index', [
            'tasks' => $tasks,
            ]);
    }

    // getでtasks/create/にアクセスされた場合の新規登録画面表示処理
    public function create()
    {
        $task = new Task;
        
        return view('tasks.create', [
            'task' => $task,
            ]);
    }

    // postでtasks/にアクセスされた場合の新規登録処理
    public function store(Request $request)
    {
        $this->validate($request, [
            'status' => 'required|max:10',
            'content' => 'required|max:30',
        ]);
        
        $task = new Task;
        $task->content = $request->content;
        $task->status = $request->status;
        $task->save();
        
        return redirect('/');
    }

    // getでtasks/idにアクセスされた場合の取得表示処理
    public function show($id)
    {
        $task = Task::find($id);
        
        return view('tasks.show', [
            'task' => $task,
            ]);
    }

    // getでtsks/id/editにアクセスされた場合の更新画面表示処理
    public function edit($id)
    {
        $task = Task::find($id);
        
        return view('tasks.edit', [
            'task' => $task,
            ]);
    }

    // putまたはpatchでtasks/idにアクセスされた場合の更新処理
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|max:10',
            'content' => 'required|max:30',
        ]);
        
        $task = Task::find($id);
        $task->content = $request->content;
        $task->status = $request->status;
        $task->save();
        
        return redirect('/');
    }

    // deleteでtasks/idにアクセスされた場合の削除処理
    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();

        return redirect('/');
    }
}

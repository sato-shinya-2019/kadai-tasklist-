<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;    // 追加

class TasksController extends Controller
{
    // getでtasks/にアクセスされた場合の一覧表示処理
    public function index()
    {
        // ログインしている場合…
        $tasks = Task::all();
        $data = [];
        if(\Auth::check()) {
            
        $user = \Auth::user();
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(5);

            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];    

        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
        
        // ログインしてない場合…
        } else {    
            
        return view('welcome', $data);
        
        }

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
        
          $request->user()->tasks()->create([
            'status' => $request->status,
            'content' => $request->content,
        ]);
        
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
        $task = \App\Task::find($id);
        
        if (\Auth::id() === $task->user_id) {
        $task->delete();
        }

        return redirect('/');
    }
}

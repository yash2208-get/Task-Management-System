<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:task-list|task-create|task-edit|task-delete', ['only' => ['index','show']]);
        $this->middleware('permission:task-create', ['only' => ['create','store']]);
        $this->middleware('permission:task-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:task-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $tasks = Task::join('users', 'tasks.user_id', '=', 'users.id')->select('tasks.*', 'users.name')->latest()->paginate(5);
        return view('tasks.index', compact('tasks'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        request()->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'priority' => 'required|in:low,medium,high',
            'deadline' => 'nullable|date',
            'status' => 'required|in:pending,completed,working',
            'document' => 'nullable|file|mimes:pdf,.jpg,.jpeg,.png,gif|max:2048'
        ]);
        
        try {
            if($request->file('document') != null) {
                $image = $request->file('document');
                $imageName = time() . '.' .$request->file('document')->getClientOriginalExtension();
                $filePath=$image->move(public_path('document'), $imageName);
            }
            
            $task = new Task();
            $task->title = $request->title;
            $task->priority = $request->priority;
            $task->description = $request->description;
            $task->deadline = $request->deadline;
            $task->status = $request->status;
            $task->document = $imageName ?? null;
            $task->user_id = auth()->user()->id;
            $task->save();
            return redirect()->route('tasks.index')->with('success','Task created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show(Task $task)
    {
        return view('tasks.show',compact('task'));
    }

    public function edit(Task $task)
    {
        return view('tasks.edit',compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        request()->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'priority' => 'required|in:low,medium,high',
            'deadline' => 'nullable|date',
            'status' => 'required|in:pending,completed,working',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048'
        ]);
        try {
            if($request->file('document') != null) {
                $image = $request->file('document');
                $imageName = time() . '.' .$request->file('document')->getClientOriginalExtension();
                $filePath=$image->move(public_path('document'), $imageName);
            }
            $task->title = $request->title;
            $task->priority = $request->priority;
            $task->description = $request->description;
            $task->deadline = $request->deadline;
            $task->status = $request->status;
            $task->document = $imageName ?? null;
            $task->save();
            return redirect()->route('tasks.index')->with('success','Task updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Task $task)
    {
        if ($task->user_id != auth()->user()->id) {
            return redirect()->back()->with('error', 'You are not authorized to delete this task.');
        }
        try {
            $task->delete();
            return redirect()->route('tasks.index')->with('success','Task deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

}

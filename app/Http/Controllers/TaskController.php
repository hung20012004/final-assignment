<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Exports\TasksExport;
use Maatwebsite\Excel\Facades\Excel;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }

        $tasks = $query->paginate(10);

        return view('user.manager.index-task', compact('tasks'));
    }

    public function create()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('user.manager.create-task', compact('users'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'state' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'time' => 'required|date'
        ]);

        // Tạo task mới
        Task::create($validatedData);
        return redirect()->route('tasks.index')->with('success', 'task created successfully!');
    }

    public function show(Task $task)
    {
        $task = Task::findOrFail($task->id);

        return view('user.manager.show-task', compact('task'));
    }

    public function edit(Task $task)
    {
        $user = Task::findOrFail($task->id);

        return view('user.manager.edit-task', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        // dd($request,$task);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'time' => 'required|date',
            'state' => 'required|string|max:255'
        ]);

        // Update the task
        $task->update($validatedData);

        // Redirect to the task list with success message
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }


    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'task deleted successfully!');
    }
    public function export()
    {
        return Excel::download(new TasksExport, 'tasks.xlsx');
    }
}

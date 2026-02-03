<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;
use App\Models\TaskSubmission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function submit(Request $request, Task $task)
    {
        $request->validate([
            'proof_image' => 'required|image|max:5120', // 5MB max
        ]);

        $path = $request->file('proof_image')->store('submissions', 'public');

        TaskSubmission::create([
            'user_id' => Auth::id(),
            'task_id' => $task->id,
            'proof_image_path' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task submitted successfully! Waiting for approval.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TaskSubmission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        $submissions = TaskSubmission::with(['user', 'task'])->where('status', 'pending')->get();
        return view('admin.submissions', compact('submissions'));
    }

    public function approve(TaskSubmission $submission)
    {
        DB::transaction(function () use ($submission) {
            $submission->update(['status' => 'approved']);

            $reward = $submission->task->reward_aed;
            $completerReward = $reward * 0.5;
            $recruiterReward = $reward * 0.5;

            // Give reward to completer
            $completer = $submission->user;
            $completer->increment('balance_aed', $completerReward);

            // Give reward to recruiter if exists
            if ($completer->recruiter_id) {
                $recruiter = User::find($completer->recruiter_id);
                if ($recruiter) {
                    $recruiter->increment('balance_aed', $recruiterReward);
                }
            }
        });

        return back()->with('success', 'Submission approved and rewards distributed!');
    }

    public function reject(Request $request, TaskSubmission $submission)
    {
        $request->validate(['feedback' => 'required|string']);
        $submission->update([
            'status' => 'rejected',
            'admin_feedback' => $request->feedback
        ]);
        return back()->with('success', 'Submission rejected.');
    }

    public function withdrawals()
    {
        $withdrawals = \App\Models\Withdrawal::with('user')->where('status', 'pending')->get();
        return view('admin.withdrawals', compact('withdrawals'));
    }

    public function approveWithdrawal(\App\Models\Withdrawal $withdrawal)
    {
        $withdrawal->update(['status' => 'approved']);
        return back()->with('success', 'Withdrawal approved.');
    }

    public function codes()
    {
        $codes = \App\Models\AccessCode::with('user')->latest()->get();
        return view('admin.codes', compact('codes'));
    }

    public function generateCode(Request $request)
    {
        $code = strtoupper(Str::random(3)) . '-' . rand(100, 999);
        \App\Models\AccessCode::create([
            'code' => $code,
            'status' => 'active',
            'expires_at' => now()->addDays(7),
        ]);

        return back()->with('success', "New access code generated: $code");
    }

    // Task Management Methods
    public function tasks()
    {
        $tasks = \App\Models\Task::latest()->get();
        return view('admin.tasks.index', compact('tasks'));
    }

    public function createTask()
    {
        return view('admin.tasks.create');
    }

    public function storeTask(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string',
            'reward_aed' => 'required|numeric|min:0',
            'instagram_url' => 'required|url',
        ]);

        \App\Models\Task::create($request->all());

        return redirect()->route('admin.tasks.index')->with('success', 'Task created successfully!');
    }

    public function deleteTask(\App\Models\Task $task)
    {
        $task->delete();
        return back()->with('success', 'Task deleted successfully.');
    }
}

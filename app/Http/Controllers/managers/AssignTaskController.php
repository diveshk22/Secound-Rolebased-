<?php

namespace App\Http\Controllers\Managers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use App\Models\Comment;

class AssignTaskController extends Controller
{
    public function AssignTask()
    {
        $employees = User::role('user')->get();
        return view('managers.task.ViewAssignTask', compact('employees'));
    }

    public function StoreComment(Request $request)
    {
        Comment::create([
            'task_id' => $request->task_id,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);
        return back()->with('success', 'Comment added successfully.');
    }

    public function Store(Request $request)
    {
        // dd($request->all());
        // Validate the incoming request data
        $request->validate([
        'employee_id' => 'required|exists:users,id',
        'task_description' => 'required|string',
        'due_date' => 'nullable|date',
        ]);

        // Create a new task
        $task = new Task();
        $task->title = 'Task by Manager'; // ya koi default title
        $task->description = $request->task_description;
        $task->assigned_to = $request->employee_id;
        $task->due_date = $request->due_date;
        $task->user_id = auth()->id(); // ⭐ VERY IMPORTANT
        $task->status = 'pending';
        // dd($task);
        $task->save();

        // Redirect back with a success message
        return back()->with('success', 'Task assigned successfully.');
    }

    public function viewAssignedTasks()
    {
        $assignedTasks = Task::with('assignedUser')->where('user_id', auth()->id())->get();
        return view('managers.task.ViewAssignedTasks', compact('assignedTasks'));
    }

    public function handleTaskAction(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'comment' => 'required|string'
        ]);

        Comment::create([
            'task_id' => $request->task_id,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Comment added successfully.');
    }
}

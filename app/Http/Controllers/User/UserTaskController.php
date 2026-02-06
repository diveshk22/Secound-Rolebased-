<?php
namespace App\Http\Controllers\User;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserTaskController extends Controller
{
    // views to task description page button click
    public function viewDescription($id)
    {
        $task = Task::with('comments.user')->findOrFail($id);
        return view('user.task.description', compact('task'));
    }

    // show tasks assigned to user
    public function showTask()
    {
        $tasks = Task::where('assigned_to', Auth::id())->with('comments.user')->get();
        return view('User.Task.ShowTask', compact('tasks'));
    }

    // update task status
   public function updateTaskStatus(Request $request, $id)
   {
    $request->validate([
        'status' => 'required|in:' . implode(',', Task::STATUSES)
    ]);
    $task = Task::findOrFail($id);

    // /Agar user hai to sirf apne task ka status badal sake
    if (auth::user()->role == 'user' && $task->assigned_to != auth()->id()){
        return redirect()->back()->with('error', 'Unauthorized access.');
    } 
    $task->status = $request->status;
    $task->save();

    return redirect()->back()->with('success', 'Task status updated successfully.');
   }
}
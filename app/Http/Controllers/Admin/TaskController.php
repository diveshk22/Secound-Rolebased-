<?php
namespace App\Http\Controllers\admin;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TaskController extends Controller
{

    // status update function
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:' . implode(',', Task::STATUSES) . ',pending,completed'
        ]);
        
        $task = Task::findOrFail($id);
        $task->status = $request->status;
        $task->save();
        
        return redirect()->back()->with('success', 'Task status updated successfully.');
    }

    // show all tasks
    public function index()
    {
        // sirf aaj ka tasks show karna hai
        $tasks = Task::whereDate('created_at', Carbon::today())->get();
        return view('admin.task.taskindex', compact('tasks'));

    }

    // delete task
    public function destroy($id)
    {
    Task::findOrFail($id)->delete();
    return redirect()->back()->with('success', 'Task deleted successfully!');
    }

    // create task form 
    public function create()
    {
        $users = User::role('user')->get();
        return view('admin.task.createtask', compact('users'));
    }

    // store task
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'assigned_to' => 'required|exists:users,id',
            'due_date' => 'nullable|date',
        ]);

        try {
            $task = Task::create([
                'title' => $request->title,
                'description' => $request->description,
                'due_date' => $request->due_date,
                'assigned_to' => $request->assigned_to,
                'user_id' => auth()->id(),
            ]);
            
            return redirect()->back()->with('success', 'Task created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create task: ' . $e->getMessage());
        }
    }

}

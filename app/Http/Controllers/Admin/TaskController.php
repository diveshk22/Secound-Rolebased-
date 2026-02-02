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
        $tasks = Task::with(['user', 'assignedUser'])->get();
        return view('admin.task.taskindex', compact('tasks'));
    }

    // edit task form
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $users = User::all();
        return view('admin.task.edit-task', compact('task', 'users'));
    }
    // update tasks
    public function update (Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->title = $request->title;
        $task->description = $request->description;
        $task->due_date = $request->due_date;
        $task->assigned_to = $request->assigned_to;

        $task->save();
        return redirect()->route('admin.task.index')->with('success', 'Task updated successfully.');
    }

    // delete task
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->back()->with('success', 'Task Deleted Successfully');
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

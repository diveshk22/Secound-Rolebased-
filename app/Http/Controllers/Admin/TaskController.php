<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Show tasks of specific project
    public function index($project_id)
    {
        $tasks = Task::where('project_id', $project_id)
        ->with(['user', 'assignedUser', 'comments.user'])
        ->latest()
        ->distinct()
        ->get();

    return view('admin.Projects.Task.TaskIndex', compact('tasks', 'project_id'));
    }
    // Show create task form
    public function create($project_id)
    {
        $project = Project::findOrFail($project_id);

        // Only users assigned to this project
        $users = $project->users;

        return view('admin.Projects.Task.Createtask', compact('users', 'project_id'));
    }

    // Store task
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'assigned_to' => 'required|exists:users,id',
            'due_date' => 'nullable|date',
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'assigned_to' => $request->assigned_to,
            'user_id' => auth()->id(),
            'project_id' => $request->project_id,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Task created successfully!');
    }

    // Show single task
    public function show($id)
    {
        $task = Task::with(['user', 'assignedUser', 'project'])->findOrFail($id);
        
        return view('admin.Projects.Task.TaskShow', compact('task'));
    }

    // Edit task
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $users = User::whereHas('projects', function($query) use ($task) {
            $query->where('project_id', $task->project_id);
        })->get();

        return view('admin.Projects.Task.edit-task', compact('task', 'users'));
    }

    // Update task
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'assigned_to' => $request->assigned_to,
        ]);

        return back()->with('success', 'Task updated successfully.');
    }

    // Delete task
    public function destroy($id)
    {
        Task::findOrFail($id)->delete();

        return back()->with('success', 'Task Deleted Successfully');
    }
}

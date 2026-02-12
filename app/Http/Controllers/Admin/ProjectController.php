<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('users')->get();
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $users = User::All();

        return view('admin.projects.create', compact('users'));
    }

    public function store(Request $request)
    {
        // ✅ Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'users' => 'required|array'
        ]);

        // ✅ Project create
        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // ✅ Attach users (many-to-many)
        $project->users()->attach($request->users);

        return back()
            ->with('success', 'Project Created Successfully');
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id); 
        $project->delete(); 
        return back() ->with('success', 'Project Deleted Successfully');
    }

    // Edit Project
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $users = User::All();

        return view('admin.projects.editproject', compact('project', 'users'));
    }

    // Update Project
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $project->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if ($request->has('users')) {
            $project->users()->sync($request->users);
        }

        return back()
            ->with('success', 'Project Updated Successfully');
    }
}

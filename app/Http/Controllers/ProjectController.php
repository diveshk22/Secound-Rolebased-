<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
    $managerIds = User::role('manager')->pluck('id');

    $projects = Project::whereIn('created_by', $managerIds)
                ->with('creator', 'users')
                ->latest()
                ->get();

    return view('projects.index', compact('projects'));
    }
    public function create()
    {
        $users =User::role(['user', 'manager'])->get();
        return view('projects.create', compact('users'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => auth()->id(),
        ]);

        if($request->has('assigned_users')){
            $project->users()->attach($request->assigned_users);
        }
        $project->users()->attach(auth()->id());

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }
    
    // public function destroy($id)
    // {
    //     $project = Project::findOrFail($id);
    //     $project->delete();

    //     return redirect()->back()->with('success', 'Project deleted successfully.');
    // }
}

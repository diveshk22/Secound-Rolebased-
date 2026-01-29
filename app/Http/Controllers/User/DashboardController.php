<?php

namespace App\Http\Controllers\User;
use App\Models\Task;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()

    
    {
        $tasks = Task::where('assigned_to', auth()->id())->get();
        return view('user.UserDashboard', compact('tasks'));
    }
}
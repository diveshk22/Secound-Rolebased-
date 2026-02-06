<?php

namespace App\Http\Controllers\Managers;

use App\Models\User;
use App\Models\Task;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManagerDashboardController extends Controller
{
    public function index()
    {
        $managerId = auth()->id();

        // Manager ke banaye hue users
        $totalUsers = User::where('created_by', $managerId)->count();

        // Tasks
        $totalTasks = Task::count();
        $pendingTasks = Task::where('status', 'pending')->count();
        $completedTasks = Task::where('status', 'completed')->count();
        $inProgressTasks = Task::where('status', 'in_progress')->count();

        // Recent tasks
        $tasks = Task::with('user')->latest()->take(6)->get();

        return view('Managers.ManagerDashboard', compact(
            'totalUsers',
            'totalTasks',
            'pendingTasks',
            'completedTasks',
            'inProgressTasks',
            'tasks'
        ));
    }
}

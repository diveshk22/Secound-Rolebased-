<?php

namespace App\Http\Controllers\User;
use App\Models\Task;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class DashboardController extends Controller
{
    public function index()    
    {
        $userId = auth()->id();

        $tasks = Task::where('assigned_to', $userId)->get();

        $totalTasksCount = Task::where('assigned_to', $userId)->count();

        $pendingTasksCount = Task::where('assigned_to', $userId)
                                ->where('status', 'pending')
                                ->count();

        $rejectedTasksCount = Task::where('assigned_to', $userId)
                                ->where('status', 'Reject')
                                ->count();
                                
        return view('User.UserDashboard', compact(
            'tasks',
            'totalTasksCount',
            'pendingTasksCount',
            'rejectedTasksCount'
        ));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // Dashboard for user management
    public function dashboard()
    {
    $totalUsers = User::count();

    $todayUsers  = User::role('user')
            ->whereDate('created_at', Carbon::today())
            ->count();
    return view('admin.dashboard', compact('totalUsers','todayUsers'));
    }

    public function index()
    {
        $totalUsers = User::count();
        $todayUsers = User::whereDate('created_at', Carbon::today())->count();
        
        return view('admin.AdminDashboard', compact('totalUsers', 'todayUsers'));
    }
}

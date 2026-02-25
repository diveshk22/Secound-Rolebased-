<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $todayUsers = User::whereDate('created_at', Carbon::today())->count();
        return view('super_admin.dashboard', compact('todayUsers'));
    }
}

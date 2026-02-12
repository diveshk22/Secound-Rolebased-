<?php

namespace App\Http\Controllers\Managers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManagerDashboardController extends Controller
{
    public function index()
    {
        $managerId = auth()->id();

        // Manager ke banaye hue users
        $totalUsers = User::where('created_by', $managerId)->count();

        return view('Managers.ManagerDashboard', compact(
            'totalUsers'
        ));
    }
}

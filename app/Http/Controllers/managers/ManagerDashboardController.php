<?php

namespace App\Http\Controllers\managers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManagerDashboardController extends Controller
{
    public function index()
    {
        return view('managers.dashboard');
    }
}

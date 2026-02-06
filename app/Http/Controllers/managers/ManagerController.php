<?php

namespace App\Http\Controllers\managers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class ManagerController extends Controller
{
    public function allUsers()
    {
    $users = User::role('user')->with('creator')->get();
    return view('managers.allusers',compact('users'));
    }
}
<?php
namespace App\Http\Controllers\superadmin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskViewController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['user', 'assignedUser'])->latest()->get();
        return view('Super-Admin.tasks.index', compact('tasks'));
    }
}

?>
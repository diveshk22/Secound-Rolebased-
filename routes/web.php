<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\User\UserTaskController;
use App\Http\Controllers\Managers\ManagerController;
use App\Http\Controllers\Managers\AssignTaskController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\superadmin\SuperAdminController;
Use App\Http\Controllers\Managers\CreateUController;
Use App\Http\Controllers\Managers\ManagerDashboardController;

// WELCOME ROUTE
Route::get('/', function () {
    return view('welcome');
})->name('/');

// USER CREATION ROUTES
Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
Route::post('/admin/users/store', [UserController::class, 'store'])->name('admin.users.store');
Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');

//LOGIN ROUTES (missing the)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// PASSWORD RESET ROUTES
Route::get('/password/reset', function () {
    return view('auth.passwords.email');
})->name('password.request');

Route::post('/password/email', function () {
    // Handle password reset email logic here
    return back()->with('status', 'Password reset link sent!');
})->name('password.email');

// Projects Routes
Route::resource('projects', App\Http\Controllers\ProjectController::class);


// Super-Admin all routes 
Route::middleware(['auth', 'redirect.role:superadmin'])->group(function () {
Route::get('/superadmin/Super-dashboard', [App\Http\Controllers\superadmin\SuperAdminController::class, 'index'])->name('superadmin.superdashboard');
Route::get('/superadmin/users', [App\Http\Controllers\superadmin\SuperAdminController::class, 'users'])->name('super.users');
Route::post('/superadmin/users/{id}/role', [App\Http\Controllers\superadmin\SuperAdminController::class, 'changeRole'])->name('super.change.role');
});

// show peniding tasks to user or completed tasks
Route::get('/admin/task/status/{id}', [App\Http\Controllers\Admin\TaskController::class, 'updateStatus'])->name('admin.task.updateStatus');

// view routes for task details
Route::middleware(['auth', 'redirect.role:admin'])->group(function () {
Route::get('/admin/task', [TaskController::class, 'index'])->name('admin.task.index');
Route::get('/admin/task/createtask', [TaskController::class, 'create'])->name('admin.task.createtask');
Route::post('/admin/task/store', [TaskController::class, 'store'])->name('admin.task.store');
Route::get('/admin/task/{id}', [TaskController::class, 'show'])->name('admin.task.show');
Route::get('/admin/task/{id}/edit', [TaskController::class, 'edit'])->name('admin.task.edit');
Route::put('/admin/task/{id}', [TaskController::class, 'update'])->name('admin.task.update');
Route::delete('/admin/task/{id}', [TaskController::class, 'destroy'])->name('admin.task.destroy');
Route::delete('/admin/task/{id}', [TaskController::class, 'destroy'])->name('admin.task.delete');
});

// routes function to dashboard based on role
Route::get('/redirect', function () {

    if (auth()->user()->hasRole('superadmin')) {
        return redirect()->route('superadmin.superdashboard');
    }

    if (auth()->user()->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    if (auth()->user()->hasRole('manager')) {
        return redirect('/manager/dashboard');
    }

    if (auth()->user()->hasRole('user')) {
        return redirect()->route('user.dashboard');
    }
});

// users destroy admin /users/{user}
Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])
    ->name('admin.users.destroy');

// Route groups for admin and user dashboards
Route::post('/admin/users/{user}/role', [UserController::class, 'changeRole'])
    ->name('admin.users.changeRole');
    
//ADMIN DASHBOARD
Route::middleware(['auth', 'redirect.role:admin'])->group(function(){
Route::get('/admin/dashboard',[AdminDashboardController::class, 'index'])->name('admin.dashboard');
});
Route::post('/user/{id}/make-manager', [UserController::class, 'makeManager'])
    ->middleware('role:admin');

//USER DASHBOARD
Route::middleware(['auth', 'redirect.role:user'])->group(function(){
Route::get('/user/dashboard',[UserDashboardController::class, 'index'])->name('user.dashboard');
});

// USER TASK ROUTES
Route::get('/user/task/showtask', [App\Http\Controllers\User\UserTaskController::class, 'showTask'])->name('user.task.showtask');
Route::get('/user/task/mytask', [App\Http\Controllers\User\UserTaskController::class, 'myTask'])->name('user.task.mytask');
Route::post('/user/task/store', [App\Http\Controllers\User\UserTaskController::class, 'store'])->name('user.task.store');
Route::post('/task/update-status/{id}', [App\Http\Controllers\User\UserTaskController::class, 'updateTaskStatus'])->name('task.update.status');

// managers routes
Route::middleware(['role:manager'])->group(function () {
Route::get('/manager/dashboard', [App\Http\Controllers\Managers\ManagerDashboardController::class, 'index'])->name('managers.managerdashboard'); 
Route::get('/managers/createuser', [App\Http\Controllers\Managers\CreateUController::class, 'create'])->name('managers.createuser');
Route::get('/managers/allusers', [App\Http\Controllers\Managers\CreateUController::class, 'allUsers'])->name('managers.allusers');
Route::post('/managers/storeuser', [App\Http\Controllers\Managers\CreateUController::class, 'store'])->name('managers.storeUser');
});

//managers TAsk Assigen routes
Route::get('/managers/Task/assigntask', [AssignTaskController::class, 'AssignTask'])
    ->name('managers.assigntask');

Route::post('/managers/Task/Assign', [AssignTaskController::class, 'Store'])
    ->name('managers.task.assigntask');

Route::get('/managers/Task/viewassigntask', [AssignTaskController::class, 'viewAssignedTasks'])
    ->name('managers.viewassigntask');

Route::post('/managers/Task/viewassigntask', [AssignTaskController::class, 'handleTaskAction'])
    ->name('managers.viewassigntask.post');
Route::get('/managers/Task/comment', [AssignTaskController::class, 'storeComment'])
    ->name('managers.task.comment');

Route::post('/managers/Task/comment', [AssignTaskController::class, 'storeComment'])
    ->name('managers.task.comment.post');

// user task description route
Route::get('task/description/{id}', [UserTaskController::class, 'viewDescription'])
    ->name('task.view.description');

// USER PROFILE UPDATE ROUTE
Route::middleware(['auth'])->group(function () {
Route::get('/user/task/profile', [ProfileController::class, 'edit'])->name('task.profile');
Route::post('/user/task/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// Comment store route
Route::post('/task/comment', [CommentController::class, 'store'])
    ->name('task.comment'); 

//  users profile route 
Route::get('/profile', [\App\Http\Controllers\User\ProfileController::class, 'edit'])
    ->middleware('auth')
    ->name('profile.edit');
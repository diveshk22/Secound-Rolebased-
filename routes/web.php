<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\UserTaskController;

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

// show peniding tasks to user or completed tasks
Route::get('/admin/task/status/{id}', [App\Http\Controllers\Admin\TaskController::class, 'updateStatus'])->name('admin.task.updateStatus');

// Task routes
Route::middleware(['auth', 'role:admin'])->group(function () {
Route::get('/admin/task/createtask', [App\Http\Controllers\Admin\TaskController::class, 'create'])->name('admin.task.createtask');
Route::post('/admin/task/store', [App\Http\Controllers\Admin\TaskController::class, 'store'])->name('admin.task.store');
Route::get('/admin/task', [App\Http\Controllers\Admin\TaskController::class, 'index'])->name('admin.task.index');
Route::delete('/admin/task/{id}', [App\Http\Controllers\Admin\TaskController::class, 'destroy'])->name('admin.task.destroy');
});
// routesn function to dashboard based on role
Route::get('/redirect', function () {

    if (auth()->user()->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
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
Route::middleware(['auth', 'role:admin'])->group(function(){
    Route::get('/admin/dashboard',[AdminDashboardController::class, 'index'])->name('admin.dashboard');
});


//USER DASHBOARD
Route::middleware(['auth', 'role:user'])->group(function(){
    Route::get('/user/dashboard',[UserDashboardController::class, 'index'])->name('user.dashboard');
});


// USER TASK ROUTES
Route::get('/user/task/showtask', [App\Http\Controllers\User\UserTaskController::class, 'showTask'])->name('user.task.showtask');
Route::get('/user/task/mytask', [App\Http\Controllers\User\UserTaskController::class, 'myTask'])->name('user.task.mytask');
Route::post('/user/task/store', [App\Http\Controllers\User\UserTaskController::class, 'store'])->name('user.task.store');
Route::post('/task/update-status/{id}', [App\Http\Controllers\User\UserTaskController::class, 'updateTaskStatus'])->name('task.update.status');

// USER PROFILE UPDATE ROUTE
Route::middleware(['auth'])->group(function () {
    Route::get('/user/task/profile', [ProfileController::class, 'edit'])->name('task.profile');
    Route::post('/user/task/profile/update', [ProfileController::class, 'update'])->name('profile.update');

});

//  users profile route 
Route::get('/profile', [\App\Http\Controllers\User\ProfileController::class, 'edit'])
    ->middleware('auth')
    ->name('profile.edit');

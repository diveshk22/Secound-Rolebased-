<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\ProjectController;
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


// Projects Admin Routes
Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects/store', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{id}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{id}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy');

    // Project Tasks Routes
    Route::get('/projects/{project_id}/tasks', [TaskController::class, 'taskIndex'])->name('projects.task.taskindex');
    Route::get('/projects/{project_id}/tasks/create', [TaskController::class, 'taskCreate'])->name('projects.task.create');

});


//USER DASHBOARD
Route::middleware(['auth', 'redirect.role:user'])->group(function(){
Route::get('/user/dashboard',[UserDashboardController::class, 'index'])->name('user.dashboard');
});



// managers routes
Route::middleware(['role:manager'])->group(function () {
Route::get('/manager/dashboard', [App\Http\Controllers\Managers\ManagerDashboardController::class, 'index'])->name('managers.managerdashboard'); 
Route::get('/managers/createuser', [App\Http\Controllers\Managers\CreateUController::class, 'create'])->name('managers.createuser');
Route::get('/managers/allusers', [App\Http\Controllers\Managers\CreateUController::class, 'allUsers'])->name('managers.allusers');
Route::post('/managers/storeuser', [App\Http\Controllers\Managers\CreateUController::class, 'store'])->name('managers.storeUser');
});




// USER PROFILE UPDATE ROUTE
Route::middleware(['auth'])->group(function () {
Route::get('/user/task/profile', [ProfileController::class, 'edit'])->name('task.profile');
Route::post('/user/task/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

 

//  users profile route 
Route::get('/profile', [\App\Http\Controllers\User\ProfileController::class, 'edit'])
    ->middleware('auth')
    ->name('profile.edit');
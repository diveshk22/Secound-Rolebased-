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
Route::middleware(['auth', 'role:admin'])->group(function () {

Route::resource('admin/users', UserController::class)->names([
    'index' => 'admin.users.index',
    'create' => 'admin.users.create',
    'store' => 'admin.users.store',
    'show' => 'admin.users.show',
    'edit' => 'admin.users.edit',
    'update' => 'admin.users.update',
    'destroy' => 'admin.users.destroy'
]);
});

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

// SHARED ROUTES (No prefix, accessible by both)
Route::middleware(['auth', 'role:admin,manager'])->group(function () {
    
    // Project Routes
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/admin/projects', [ProjectController::class, 'index'])->name('admin.projects.index');
    Route::get('/manager/projects', [ProjectController::class, 'index'])->name('manager.projects.index');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{id}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{id}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    
    // Task Routes
    Route::get('/projects/{project_id}/tasks', [TaskController::class, 'Index'])->name('projects.tasks.index');
    Route::get('/projects/{project_id}/tasks/create', [TaskController::class, 'create'])->name('projects.tasks.create');
    Route::post('/projects/{project_id}/tasks', [TaskController::class, 'store'])->name('projects.tasks.store');
    Route::get('/task/{id}/edit', [TaskController::class, 'edit'])->name('admin.projects.task.edit');
    Route::put('/task/{id}', [TaskController::class, 'update'])->name('admin.projects.task.update');
    Route::delete('/task/{id}', [TaskController::class, 'destroy'])->name('admin.projects.task.delete');
    Route::get('/task/{id}/show', [TaskController::class, 'show'])->name('admin.projects.task.show');
});

// MANAGER-ONLY ROUTES (Specific management tasks)
Route::middleware(['auth', 'role:manager'])->group(function () {
    Route::get('/manager/dashboard', [ManagerDashboardController::class, 'index'])->name('manager.dashboard');
    Route::get('/manager/createuser', [CreateUController::class, 'create'])->name('manager.createuser');
    Route::post('/manager/users/store', [CreateUController::class, 'store'])->name('manager.users.store');
    Route::get('/manager/allusers', [CreateUController::class, 'allUsers'])->name('manager.allusers');
});

// USER DASHBOARD & PROJECT ACCESS
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // Projects: Users see ONLY projects they belong to
    // This creates 'user.projects.index' -> URL: /user/projects
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');

    // Project Tasks: Users see ALL tasks in projects they belong to
    // This creates 'user.projects.tasks.index' -> URL: /user/projects/{id}/tasks
    Route::get('/projects/{project_id}/tasks', [TaskController::class, 'taskIndex'])->name('projects.tasks.index');
    
    // Legacy support for your existing "my-tasks"
    Route::get('my-tasks', [TaskController::class, 'myTasks'])->name('mytasks');
});

// SHARED AUTH ROUTES (Profile)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/user/task/profile', [ProfileController::class, 'edit'])->name('task.profile');
    Route::post('/user/task/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});


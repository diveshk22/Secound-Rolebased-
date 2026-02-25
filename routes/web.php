<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Managers\ManagerDashboardController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => view('welcome'))->name('/');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Super - Admin  ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/super-admin/dashboard', [SuperAdminDashboardController::class, 'index'])->name('superadmin.dashboard');
});
Route::prefix('auth')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin|super_admin|manager|user'])->group(function () {
    // Admin Dashboard
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard')->middleware('role:admin|super_admin|manager');

    // Users Management
    Route::middleware('role:admin|super_admin|manager')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::post('/users/{user}/role', [UserController::class, 'changeRole'])->name('users.changeRole');
        Route::post('/user/{id}/make-manager', [UserController::class, 'makeManager'])->name('users.makeManager');
    });

    // Projects & Tasks
    Route::prefix('projects')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('/create', [ProjectController::class, 'create'])->name('projects.create')->middleware('role:admin|super_admin|manager');
        Route::post('/', [ProjectController::class, 'store'])->name('projects.store')->middleware('role:admin|super_admin|manager');
        Route::get('/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit')->middleware('role:admin|super_admin|manager');
        Route::put('/{project}', [ProjectController::class, 'update'])->name('projects.update')->middleware('role:admin|super_admin|manager');
        Route::delete('/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy')->middleware('role:admin|super_admin|manager');

        // Tasks nested under projects
        Route::prefix('{project_id}/tasks')->group(function () {
            Route::get('/', [TaskController::class, 'index'])->name('projects.tasks.index');
            Route::get('/create', [TaskController::class, 'create'])->name('projects.tasks.create')->middleware('role:admin|super_admin|manager');
            Route::post('/', [TaskController::class, 'store'])->name('projects.tasks.store')->middleware('role:admin|super_admin|manager');
            Route::get('{id}/show', [TaskController::class, 'show'])->name('projects.tasks.show');
        });

        // Individual task routes
        Route::prefix('task')->group(function () {
            Route::get('{id}/show', [TaskController::class, 'show'])->name('projects.task.show');
            Route::get('{id}/edit', [TaskController::class, 'edit'])->name('projects.task.edit')->middleware('role:admin|super_admin|manager');
            Route::put('{id}', [TaskController::class, 'update'])->name('projects.task.update')->middleware('role:admin|super_admin|manager');
            Route::delete('{id}', [TaskController::class, 'destroy'])->name('projects.task.delete')->middleware('role:admin|super_admin|manager');
            Route::get('status/{id}', [TaskController::class, 'updateStatus'])->name('projects.task.updateStatus')->middleware('role:admin|super_admin|manager');
        });
    });
});

/*
|--------------------------------------------------------------------------
| MANAGER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:manager'])->prefix('manager')->name('manager.')->group(function () {

    Route::get('Managers.ManagerDashboard', [ManagerDashboardController::class, 'index'])->name('dashboard');

    // Users Management (Manager can access user listing + create/edit)
    Route::resource('users', UserController::class)->except(['show', 'destroy']);

    // Projects & Tasks (same as admin, no duplicates)
    Route::prefix('projects')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('/create', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('/', [ProjectController::class, 'store'])->name('projects.store');
        Route::get('/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
        Route::put('/{project}', [ProjectController::class, 'update'])->name('projects.update');
        Route::delete('/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

        Route::prefix('{project_id}/tasks')->group(function () {
            Route::get('/', [TaskController::class, 'index'])->name('projects.tasks.index');
            Route::get('/create', [TaskController::class, 'create'])->name('projects.tasks.create');
            Route::post('/', [TaskController::class, 'store'])->name('projects.tasks.store');
        });

        Route::prefix('task')->group(function () {
            Route::get('{id}/show', [TaskController::class, 'show'])->name('projects.task.show');
            Route::get('{id}/edit', [TaskController::class, 'edit'])->name('projects.task.edit');
            Route::put('{id}', [TaskController::class, 'update'])->name('projects.task.update');
            Route::delete('{id}', [TaskController::class, 'destroy'])->name('projects.task.delete');
            Route::get('status/{id}', [TaskController::class, 'updateStatus'])->name('projects.task.updateStatus');
        });
    });
});

/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{project_id}/tasks', [TaskController::class, 'index'])->name('projects.tasks.index');
    Route::get('/task/{id}/show', [TaskController::class, 'show'])->name('projects.task.show');
    Route::get('/my-tasks', [TaskController::class, 'myTasks'])->name('mytasks');
    Route::post('/task/{id}/update-status', [TaskController::class, 'updateStatus'])->name('task.updateStatus');
});

/*
|--------------------------------------------------------------------------
| PROFILE (SHARED AUTH)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

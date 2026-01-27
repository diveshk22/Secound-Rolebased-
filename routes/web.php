<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Admin\UserController;

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

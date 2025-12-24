<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Admin Login Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/admin-login', [UserController::class, 'adminLogin'])
    ->name('admin.login');

/*
|--------------------------------------------------------------------------
| Protected Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:web', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [OrderController::class, 'adminOrders'])
        ->name('admin.dashboard');

    Route::post('/logout', function () {
        // Auth::logout();
        Auth::guard('web')->logout();
        return redirect('/login');
    })->name('logout');
});

Route::get('/create-user', function (\Illuminate\Http\Request $request) {
    // 1️⃣ Get query params
    $name = $request->query('name', 'Admin User');
    $email = $request->query('email');
    $password = $request->query('password');
    $is_admin = $request->query('is_admin');
    $phone = $request->query('phone');

    // 2️⃣ Validate required fields
    if (!$email || !$password) {
        return response('Email and password are required!', 400);
    }

    // 3️⃣ Create or ignore duplicate
    User::firstOrCreate(
        ['email' => $email],
        [
            'name' => $name,
            'password' => Hash::make($password),
            'is_admin' => $is_admin,
            'phone' => $phone ?? '000000'
        ]
    );

    return response("User {$email} created successfully!");
});

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
    ->middleware('auth')
    ->name('admin.dashboard');

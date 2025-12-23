<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;


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

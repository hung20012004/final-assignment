<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ManagerController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\LaptopController;
use App\Http\Middleware\CheckLaptop;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::middleware(['manager'])->group(function () {
        Route::resource('users', UserController::class);
        Route::get('/export-user', [UserController::class, 'export'])->name('users.export');
        Route::get('/user-statistics', [UserController::class, 'statistics'])->name('users.statistics');
        Route::resource('tasks', TaskController::class);
        Route::get('/export-task', [TaskController::class, 'export'])->name('tasks.export');
    });
    Route::middleware(['accountant'])->group(function () {

    });
    Route::middleware(['seller'])->group(function () {

    });
    Route::middleware(['warehouse'])->group(function () {
        Route::resource('laptops', LaptopController::class);
    });
    Route::middleware(['customer-service'])->group(function () {

    });


});

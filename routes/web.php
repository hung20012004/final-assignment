<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LaptopController;
use App\Http\Controllers\UserTaskController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::middleware(['manager'])->group(function () {
        Route::resource('users', UserController::class);
        Route::get('/export-user', [UserController::class, 'export'])->name('users.export');
        Route::resource('tasks', TaskController::class);
        Route::get('/export-task', [TaskController::class, 'export'])->name('tasks.export');
        Route::get('/user-statistics', [UserController::class, 'statistics'])->name('users.statistics');
        Route::get('/laptop-statistics', [LaptopController::class, 'statistics'])->name('laptops.statistics');
        Route::get('/order-statistics', [OrderController::class, 'statistics'])->name('orders.statistics');
    });
    Route::middleware(['accountant'])->group(function () {
    });
    Route::middleware(['seller'])->group(function () {
        Route::resource('customers', CustomerController::class);
        Route::resource('orders', OrderController::class);
        Route::resource('blogs', BlogController::class);
        Route::get('/exportCustomer', [CustomerController::class, 'export'])->name('customers.export');
        Route::get('/exportOrder', [OrderController::class, 'export'])->name('orders.export');
        Route::get('/exportBlog', [BlogController::class, 'export'])->name('blogs.export');
    });
    Route::middleware(['warehouse'])->group(function () {
        Route::resource('laptops', LaptopController::class);

    });
    Route::middleware(['customer-service'])->group(function () {

    });
    Route::get('/usertasks', [UserTaskController::class, 'index'])->name('usertasks.index');
    Route::get('/usertasks/{task}/edit', [UserTaskController::class, 'edit'])->name('usertasks.edit');
    Route::put('/usertasks/{task}', [UserTaskController::class, 'update'])->name('usertasks.update');
});

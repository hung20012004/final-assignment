<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\AccountantInvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LaptopController;
use App\Http\Controllers\ManufactoryController;
use App\Http\Controllers\ProviderController;
use App\Http\Middleware\CheckLaptop;
use App\Models\Customer;
use App\Http\Controllers\UserTaskController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\DashboardController;
use App\Models\Salary;

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
        Route::resource('salary', SalaryController::class);
        Route::get('/exportSalary', [SalaryController::class, 'export'])->name('salary.export');
        Route::resource('accountantInvoice', AccountantInvoiceController::class);
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
        Route::get('/export-laptop', [LaptopController::class, 'export'])->name('laptops.export');
        Route::resource('providers', ProviderController::class);
        Route::get('/export-provider', [ProviderController::class, 'export'])->name('providers.export');
        Route::resource('invoices', InvoiceController::class);
        Route::get('/export-invoice', [InvoiceController::class, 'export'])->name('invoices.export');
        Route::resource('manufactories', ManufactoryController::class);
        Route::resource('categories', CategoryController::class);
    });
    Route::middleware(['customer-service'])->group(function () {

    });
    Route::get('/usertasks', [UserTaskController::class, 'index'])->name('usertasks.index');
    Route::get('/usertasks/{task}/edit', [UserTaskController::class, 'edit'])->name('usertasks.edit');
    Route::put('/usertasks/{task}', [UserTaskController::class, 'update'])->name('usertasks.update');
});

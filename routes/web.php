<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaptopController;
use App\Http\Middleware\CheckLaptop;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/laptop', function () {
        return view('laptop');
    })->name('laptop');
    // Route::get('/savelaptop',[LaptopController::class, 'Create'])->name('SaveLaptop');
    Route::middleware('checklaptop')->group(function(){
        Route::get('/savelaptop',[LaptopController::class, 'Create'])->name('SaveLaptop');
    });
});

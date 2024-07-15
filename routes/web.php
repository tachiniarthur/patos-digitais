<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'store']);

Route::get('criar-usuario', [RegisterUserController::class, 'index'])->name('register');
Route::post('criar-usuario', [RegisterUserController::class, 'store']);

Route::match(['get', 'post'], '/logout', [LoginController::class, 'destroy'])->name('logout');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
    
    Route::prefix('/post')->group(function () {
        Route::post('/novo', [PostController::class, 'store']);
    });
});

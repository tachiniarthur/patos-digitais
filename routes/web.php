<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
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
    Route::get('/pagina-principal', [HomeController::class, 'index'])->name('home');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    
    Route::prefix('/post')->group(function () {
        Route::get('/consultar/{cursor?}', [PostController::class, 'getPosts'])->name('post.getPosts');
        Route::post('/novo', [PostController::class, 'store'])->name('post.store');

        Route::get('/comentários/{postId}', [PostController::class, 'getComments'])->name('post.getComments');
        Route::post('/comentar', [PostController::class, 'comment'])->name('post.comment');

        Route::post('/reagir', [PostController::class, 'reaction'])->name('post.reaction');
    });
});

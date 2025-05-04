<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\OrganController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/post/{post}', [HomeController::class, 'show'])->name('post.show');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'registerPage'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Маршруты для управления новостями (только для администраторов)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/posts', [PostController::class, 'index'])->name('post.index');
    Route::get('/admin/posts/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/admin/posts', [PostController::class, 'store'])->name('post.store');
    Route::get('/admin/posts/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::put('/admin/posts/{post}', [PostController::class, 'update'])->name('post.update');
    Route::delete('/admin/posts/{post}', [PostController::class, 'destroy'])->name('post.destroy');
});

// Маршруты для управления организациями (только для администраторов и менеджеров)
Route::middleware(['auth', 'role:admin|manager'])->group(function () {
    Route::get('/admin/organizations', [OrganController::class, 'index'])->name('organ.index');
    Route::get('/admin/organizations/create', [OrganController::class, 'create'])->name('organ.create');
    Route::post('/admin/organizations', [OrganController::class, 'store'])->name('organ.store');
    Route::get('/admin/organizations/{organ}', [OrganController::class, 'show'])->name('organ.show');
    Route::get('/admin/organizations/{organ}/edit', [OrganController::class, 'edit'])->name('organ.edit');
    Route::put('/admin/organizations/{organ}', [OrganController::class, 'update'])->name('organ.update');
    Route::delete('/admin/organizations/{organ}', [OrganController::class, 'destroy'])->name('organ.destroy');
});


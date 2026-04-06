<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccessController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\KomentarController;

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
    Route::get('/auth/google', [AuthController::class, 'redirect'])->name('auth.google.redirect');
    Route::get('/auth/callback/google', [AuthController::class, 'callback'])->name('auth.google.callback');
});

Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Middleware 'role' untuk authorization route berdasarkan role
Route::middleware(['auth', 'role'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User
    Route::get('/user', [UsersController::class, 'index'])->name('users');
    Route::post('/user/store', [UsersController::class, 'store'])->name('user.store');
    Route::put('/user/update/{id}', [UsersController::class, 'update'])->name('user.update');
    Route::delete('/user/destroy/{id}', [UsersController::class, 'destroy'])->name('user.destroy');
    Route::get('/user/detail/{id}', [UsersController::class, 'detail'])->name('user.detail');

    // Role
    Route::get('/role', [RoleController::class, 'index'])->name('role.index');
    Route::post('/role', [RoleController::class, 'store'])->name('role.store');
    Route::put('/role/{id}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('/role/{id}', [RoleController::class, 'destroy'])->name('role.destroy');

    // Menu
    Route::get('/menu', [MenuController::class, 'index'])->name('menu');
    Route::post('/menu/update', [MenuController::class, 'update'])->name('menu.update');

    // User Role
    Route::get('/user/role', [UserRoleController::class, 'userRoleIndex'])->name('user.role.index');
    Route::get('/user/role/{id_user}', [UserRoleController::class, 'userRole'])->name('user.role');

    // Akses Role
    Route::get('/access/role', [AccessController::class, 'accessRoleIndex'])->name('access.role.index');
    Route::get('/access/role/{id_role}', [AccessController::class, 'accessRole'])->name('access.role');

    // Tamu
    Route::prefix('tamu')->group(function () {
        Route::get('/', [TamuController::class, 'index'])->name('tamu.index');
        Route::get('/{id}', [TamuController::class, 'show']);

        Route::post('/', [TamuController::class, 'store'])->name('tamu.store');
        Route::put('/{id}', [TamuController::class, 'update'])->name('tamu.update');
        Route::delete('/{id}', [TamuController::class, 'destroy'])->name('tamu.destroy');

        Route::post('/import/excel', [TamuController::class, 'import'])->name('tamu.import');
        Route::get('/export/excel', [TamuController::class, 'export'])->name('tamu.export');
        Route::delete('/delete/mass', [TamuController::class, 'massdel'])->name('tamu.massdel');
    });

    // Komentar
    Route::get('/komentar', [KomentarController::class, 'data'])->name('komentar.data');
});

Route::get('/test-https', function () {
    return request()->isSecure() ? 'HTTPS' : 'NOT HTTPS';
});

Route::get('/test-session', function () {
    session(['test_key' => 'test_value']);
    return session('test_key');
});
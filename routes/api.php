<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccessController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\TamuController;

Route::post('/user/role', [UserRoleController::class, 'giveAndDropUserRole']);
Route::post('/access/role', [AccessController::class, 'giveAndDropAccessRole']);

Route::prefix('komentar')->group(function () {
    Route::get('/', [KomentarController::class, 'index']);
    Route::get('/{id}', [KomentarController::class, 'show']);

    Route::post('/', [KomentarController::class, 'store']);
    Route::put('/{id}', [KomentarController::class, 'update']);
    Route::delete('/{id}', [KomentarController::class, 'destroy']);
});

Route::prefix('tamu')->group(function () {
    Route::get('/{kode_tamu}', [TamuController::class, 'show']);
});
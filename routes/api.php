<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KomenController;
use App\Http\Controllers\KontenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/konten',[KontenController::class, 'index']);
    Route::get('/konten/{id}',[KontenController::class, 'show']);
    Route::post('/konten/create', [KontenController::class, 'store'])->middleware('admin');
    Route::post('/konten/update/{id}', [KontenController::class, 'update'])->middleware('admin');
    Route::delete('/konten/delete/{id}', [KontenController::class, 'destroy'])->middleware('admin');
    Route::get('/konten/kategori/{kategori}', [KontenController::class, 'getKontenByKategori']);
    Route::get('/komen', [KomenController::class, 'index']);
    Route::get('/komen/{id}', [KomenController::class, 'show']);
    Route::get('/komen/konten/{id_konten}', [KomenController::class, 'getByKonten']);
    // Route::post('/konten/{id_konten}/create', [KomenController::class, 'store']);
    // Route::patch('/komen/update/{id}', [KomenController::class, 'update']);
    // Route::delete('/komen/delete/{id}', [KomenController::class, 'destroy']);
    Route::post('/komen/create/{id_konten}', [KomenController::class, 'storeById']);
    Route::patch('/komen/update/{id_komen}', [KomenController::class, 'update']);
    Route::delete('/komen/delete/{id_komen}', [KomenController::class, 'destroy']);
    Route::get('/logout', [AuthController::class, 'logout']);
});

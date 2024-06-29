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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/konten',[KontenController::class, 'index']);
    Route::get('/konten/{id}',[KontenController::class, 'show']);
    Route::post('/konten/create', [KontenController::class, 'store']);
    Route::patch('/konten/update/{id}', [KontenController::class, 'update']);
    Route::delete('/konten/delete/{id}', [KontenController::class, 'destroy']);
    Route::get('/komen', [KomenController::class, 'index']);
    Route::get('/komen/{id}', [KomenController::class, 'show']);
    Route::get('/komen/konten/{id_konten}', [KomenController::class, 'getByKonten']);
    Route::post('/komen/create', [KomenController::class, 'store']);
    Route::patch('/komen/update/{id}', [KomenController::class, 'update']);
    Route::delete('/komen/delete/{id}', [KomenController::class, 'destroy']);
    Route::get('/logout', [AuthController::class, 'logout']);
});
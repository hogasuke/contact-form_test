<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;

Route::get('/', [ContactController::class, 'index']);
Route::post('/confirm', [ContactController::class, 'confirm']);
Route::post('/back', [ContactController::class, 'back']);
Route::post('/thanks', [ContactController::class, 'thanks']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::get('/admin', [ContactController::class, 'admin']);
    Route::get('/admin/search', [ContactController::class, 'search']);
    Route::delete('/admin/delete', [ContactController::class, 'destroy']);
    Route::get('/admin/export', [ContactController::class, 'export']);
});
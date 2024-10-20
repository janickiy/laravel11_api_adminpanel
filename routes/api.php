<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NoteController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::middleware('auth:api')->group(function () {
        Route::get('notes', [NoteController::class, 'index']);
        Route::get('notes/{id}', [NoteController::class, 'show']);
        Route::post('notes', [NoteController::class, 'store']);
        Route::put('notes/{id}', [NoteController::class, 'update']);
        Route::delete('notes/{id}', [NoteController::class, 'destroy']);
    });
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NotesController;
use App\Http\Controllers\Admin\AdminController;

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.submit');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/', [DashboardController::class, 'index'])->name('admin.templates.index');

Route::group(['prefix' => 'users'], function () {
    Route::get('', [AdminController::class, 'index'])->name('admin.users.index');
    Route::get('create', [AdminController::class, 'create'])->name('admin.users.create');
    Route::post('store', [AdminController::class, 'store'])->name('admin.users.store');
    Route::get('edit/{id}', [AdminController::class, 'edit'])->name('admin.users.edit');
    Route::put('update', [AdminController::class, 'update'])->name('admin.users.update');
    Route::delete('destroy', [AdminController::class, 'destroy'])->name('admin.users.destroy')->where('id', '[0-9]+');
});

Route::group(['prefix' => 'notes'], function () {
    Route::get('', [NotesController::class, 'index'])->name('admin.notes.index');
    Route::get('create', [NotesController::class, 'create'])->name('admin.notes.create');
    Route::post('store', [NotesController::class, 'store'])->name('admin.notes.store');
    Route::get('edit/{id}', [NotesController::class, 'edit'])->name('admin.notes.edit');
    Route::put('update', [NotesController::class, 'update'])->name('admin.notes.update');
    Route::delete('destroy', [NotesController::class, 'destroy'])->name('admin.notes.destroy')->where('id', '[0-9]+');
});

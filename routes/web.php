<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
})->middleware('auth');

Route::get('/dashboard', [\App\Http\Controllers\UserController::class,'index']
)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
Route::post('/save-chat', [\App\Http\Controllers\UserController::class,'saveChat'])->middleware('auth');
Route::post('load-chat', [\App\Http\Controllers\UserController::class,'loadChat'])->middleware('auth');
Route::post('/delete-chat', [\App\Http\Controllers\UserController::class,'deleteChat'])->middleware('auth');
Route::post('/update-chat', [\App\Http\Controllers\UserController::class,'updateChat'])->middleware('auth');

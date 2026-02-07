<?php

use App\Http\Controllers\AccessCodeController;
use Illuminate\Support\Facades\Route;

Route::get('/access-code', [AccessCodeController::class, 'show'])->name('access-code.show');
Route::post('/access-code', [AccessCodeController::class, 'verify'])->name('access-code.verify');
Route::post('/logout', [AccessCodeController::class, 'logout'])->name('logout');

Route::middleware(['access_code'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Add more protected routes here

    // Registration Routes
    Route::get('/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'store'])->name('register.store');

    // Invite Route
    Route::post('/invite', [AccessCodeController::class, 'generateForUser'])->name('invite.generate');
Route::get('/tasks', [App\Http\Controllers\TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/{task}', [App\Http\Controllers\TaskController::class, 'show'])->name('tasks.show');
Route::post('/tasks/{task}/submit', [App\Http\Controllers\TaskController::class, 'submit'])->name('tasks.submit');

Route::get('/referrals', [App\Http\Controllers\ReferralController::class, 'index'])->name('referrals.index');
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile');
Route::post('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

Route::get('/withdraw', [App\Http\Controllers\WithdrawalController::class, 'create'])->name('withdraw.create');
Route::post('/withdraw', [App\Http\Controllers\WithdrawalController::class, 'store'])->name('withdraw.store');
Route::get('/withdrawals', [App\Http\Controllers\WithdrawalController::class, 'index'])->name('withdraw.index');

Route::post('/stories', [App\Http\Controllers\StoryController::class, 'store'])->name('stories.store');

// Admin Routes (Simple for MVP)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/submissions', [App\Http\Controllers\AdminController::class, 'index'])->name('submissions.index');
    Route::post('/submissions/{submission}/approve', [App\Http\Controllers\AdminController::class, 'approve'])->name('submissions.approve');
    Route::post('/submissions/{submission}/reject', [App\Http\Controllers\AdminController::class, 'reject'])->name('submissions.reject');
    Route::post('/users/{user}/revoke', [App\Http\Controllers\AdminController::class, 'revokeAccess'])->name('users.revoke');
    
    Route::get('/withdrawals', [App\Http\Controllers\AdminController::class, 'withdrawals'])->name('withdrawals.index');
    Route::post('/withdrawals/{withdrawal}/approve', [App\Http\Controllers\AdminController::class, 'approveWithdrawal'])->name('withdrawals.approve');
    
    Route::get('/codes', [App\Http\Controllers\AdminController::class, 'codes'])->name('codes.index');
    Route::post('/codes/generate', [App\Http\Controllers\AdminController::class, 'generateCode'])->name('codes.generate');

    // Task Management Routes
    Route::get('/tasks', [App\Http\Controllers\AdminController::class, 'tasks'])->name('tasks.index');
    Route::get('/tasks/create', [App\Http\Controllers\AdminController::class, 'createTask'])->name('tasks.create');
    Route::post('/tasks', [App\Http\Controllers\AdminController::class, 'storeTask'])->name('tasks.store');
    Route::delete('/tasks/{task}', [App\Http\Controllers\AdminController::class, 'deleteTask'])->name('tasks.destroy');
});
});

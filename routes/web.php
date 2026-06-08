<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudyGroupController;
use Illuminate\Support\Facades\Route;

// Default guest landing page
Route::get('/', function () {
    return view('welcome');
});

// Middleware Protected Environment (Breeze Default Auth Group)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // ==========================================
    // MEMBER 3 ROUTES
    // ==========================================
    
    // 1. Dashboard View Route
    Route::get('/dashboard', [StudyGroupController::class, 'dashboard'])->name('dashboard');

    // 2. Find Study Groups (Advanced Search Page) Route
    Route::get('/groups', [StudyGroupController::class, 'index'])->name('groups.index');

    // ==========================================
    // MEMBER 1 ROUTES
    // ==========================================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
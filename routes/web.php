<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudyGroupController;
use App\Http\Controllers\RequestController;
use Illuminate\Support\Facades\Route;

// Default guest landing page
Route::get('/', function () {
    return view('auth-landing');
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
    // MEMBER 5 ROUTES & DETAIL VIEW ROUTE
    // ==========================================
    Route::get('/groups/{group}', [StudyGroupController::class, 'show'])->name('groups.show');
    Route::post('/groups/{group}/resources', [App\Http\Controllers\StudyResourceController::class, 'store'])->name('resources.store');
    Route::get('/resources/{resource}/download', [App\Http\Controllers\StudyResourceController::class, 'download'])->name('resources.download');
    Route::delete('/resources/{resource}', [App\Http\Controllers\StudyResourceController::class, 'destroy'])->name('resources.destroy');
    // MEMBER 2 ROUTES
    // ==========================================
    // automatically maps create, store, edit, update, and destroy to StudyGroupController
    Route::resource('study-groups', StudyGroupController::class)->except(['index', 'show']);

    // ==========================================
    // MEMBER 1 ROUTES
    // ==========================================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==========================================
    // MEMBER 4 ROUTES
    // ==========================================
    Route::post('/study-groups/{group}/join', [RequestController::class, 'sendRequest'])->name('groups.join');
    Route::post('/requests/{joinRequest}/approve', [RequestController::class, 'approve'])->name('requests.approve');
    Route::post('/requests/{joinRequest}/decline', [RequestController::class, 'decline'])->name('requests.decline');
});

require __DIR__.'/auth.php';

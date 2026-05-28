<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

// Redirect the root URL to your notes index
Route::get('/', function () {
    return redirect()->route('notes.index');
});

// Offline Page Route
Route::view('/offline', 'offline');

// Protecting CRUD routes using 'auth' middleware
Route::middleware(['auth', 'verified'])->group(function () {

    // Notes Routes
    Route::resource('notes', NoteController::class);

    // Redirect dashboard to notes
    Route::get('/dashboard', function () {
        return redirect()->route('notes.index');
    })->name('dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
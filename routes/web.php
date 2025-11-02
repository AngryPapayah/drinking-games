<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Openbaar
Route::get('/', [GameController::class, 'dashboard'])->name('home');
Route::get('/games/create', [GameController::class, 'create'])->name('games.create');
Route::get('/dashboard', [GameController::class, 'dashboard'])->name('dashboard');
Route::get('/games/{game}', [GameController::class, 'show'])->name('games.show');

Route::view('/about-us', 'about-us', ['company' => 'BoozeBuddies'])->name('about');
Route::view('/contact-page', 'contact-page')->name('contact-page');

//Ingelogd (user)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/games', [GameController::class, 'store'])->name('games.store');
    Route::get('/games/{game}/edit', [GameController::class, 'edit'])->name('games.edit');
    Route::put('/games/{game}', [GameController::class, 'update'])->name('games.update');
    Route::delete('/games/{game}', [GameController::class, 'destroy'])->name('games.destroy');
});

// admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    Route::post('/admin/games/{game}/toggle-visibility', [\App\Http\Controllers\AdminController::class, 'toggleVisibility'])
        ->name('admin.games.toggleVisibility')
        ->middleware(['auth', 'admin']);

});

// Auth scaffolding
require __DIR__ . '/auth.php';

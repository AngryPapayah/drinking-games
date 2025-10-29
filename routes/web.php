<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// 👇 Openbare routes (ook voor gasten)
Route::get('/', [GameController::class, 'dashboard'])->name('home');
Route::get('/dashboard', [GameController::class, 'dashboard'])->name('dashboard');
Route::get('/games/{game}', [GameController::class, 'show'])->name('games.show');

Route::get('/about-us', function () {
    $company = 'BoozeBuddies';
    return view('about-us', ['company' => $company]);
})->name('about');

Route::get('/contact-page', function () {
    return view('contact-page');
})->name('contact-page');

// 👇 Alleen ingelogde gebruikers
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Alleen voor ingelogden: games aanmaken / aanpassen / verwijderen
    Route::get('/games/create', [GameController::class, 'create'])->name('games.create');
    Route::post('/games', [GameController::class, 'store'])->name('games.store');
    Route::get('/games/{game}/edit', [GameController::class, 'edit'])->name('games.edit');
    Route::put('/games/{game}', [GameController::class, 'update'])->name('games.update');
    Route::delete('/games/{game}', [GameController::class, 'destroy'])->name('games.destroy');
});

// 👇 Alleen admins
Route::get('/admin/dashboard', function () {
    if (!auth()->check() || auth()->user()->role_id !== 1) {
        abort(403, 'Unauthorized access');
    }
    return app(AdminController::class)->dashboard();
})->name('admin.dashboard');

require __DIR__ . '/auth.php';

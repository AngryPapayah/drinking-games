<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', [GameController::class, 'dashboard'])->name('home');

Route::get('/dashboard', [GameController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/games/create', [GameController::class, 'create'])->name('games.create');


Route::get('/contact-page', function () {
    return view('contact-page');
})->name('contact-page');

Route::get('/about-us', function () {
    $company = 'BoozeBuddies';
    return view('about-us', [
        'company' => $company
    ]);
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

Route::resource('games', GameController::class);

require __DIR__ . '/auth.php';

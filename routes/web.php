<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//
//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', function () {
    return view('home');
});
//Route::get('/game', function () {
//    return view('game');
//});

Route::get('/contact-page', function () {
    return view('contact-page');
})->name('contact-page');

Route::get('/form', function () {
    return view('games.create');
})->name('form');

Route::get('/about-us', function () {
    $company = 'BoozeBuddies';
    return view('about-us', [
        'company' => $company
    ]);
});
//Route::get('game/{id}', function (int $id) {
//    return view('game', ['id' => $id]);
//});

Route::resource('games', GameController::class);

require __DIR__ . '/auth.php';

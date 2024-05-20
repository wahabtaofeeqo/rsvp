<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/init', 'IndexController@init');
Route::get('/', 'IndexController@index')->name('index');
Route::get('/thank-you', 'IndexController@thanks')->name('thanks');

Route::post('/', 'IndexController@store')->name('rsvp');

Route::get('/dashboard', 'IndexController@dashboard')
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

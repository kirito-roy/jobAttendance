<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view(view: 'frontEnd.home');
});
Route::get('/about', function () {
    return view(view: 'frontEnd.about');
});
Route::get('/login', function () {
    return view(view: 'auth.login');
});
Route::post('/login', function () {
    return view(view: 'auth.login');
});
Route::get('/register', function () {
    return view(view: 'auth.register');
});
Route::post('/register', function () {
    return view(view: 'auth.register');
});
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';

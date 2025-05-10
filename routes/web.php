<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProfileController;
use App\Livewire\Home;
use App\Livewire\About;
use App\Livewire\Admin;
use App\Livewire; // Import the Home controller
use App\Livewire\Setting;
use Illuminate\Support\Facades\Route;
use Termwind\Components\Li;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get(
    '/',
    Home::class
);
Route::get('/about', About::class);

Route::get('/setting', Setting::class);
Route::get('/admin', Admin::class);
Route::get('/schedules', Livewire\Schedule::class);
Route::get('/notification', Livewire\Notification::class);
Route::get('/attendance', Livewire\Attendance::class);
Route::get('/report', Livewire\Report::class);
Route::get('/profile', Livewire\Profile::class);

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');
Route::get('/register', [RegisteredUserController::class, 'create'])
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store']);



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';

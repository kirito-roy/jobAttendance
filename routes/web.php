<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Home;
use App\Livewire\About;
use App\Livewire\Admin;
use App\Livewire; // Import the Home controller
use App\Livewire\Setting;
use Illuminate\Support\Facades\Route;
use Termwind\Components\Li;

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

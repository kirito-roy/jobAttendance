<?php

use App\Http\Controllers;
use App\Http\Controllers\ProfileController;
use App\Livewire\Home;
use App\Livewire\About;
use App\Livewire\Admin;
use App\Livewire; // Import the Home controller
use App\Livewire\Attendance;
use App\Livewire\Setting;
use Illuminate\Support\Facades\Route;
use Termwind\Components\Li;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Livewire\Role;
use App\Livewire\Roles;
use App\Livewire\Department;

// Middleware configuration for role-based access
Route::aliasMiddleware('role', \App\Http\Middleware\RoleMiddleware::class);

// Middleware groups should be defined in the HTTP Kernel or middleware classes, not in the routes file.

Route::get(
    '/',
    Home::class
);

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');
Route::get('/register', [RegisteredUserController::class, 'create'])
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store']);

Route::middleware(['auth'])->group(function () {
    // Routes for everyone
    Route::get('/about', About::class);
    Route::get('/profile', Livewire\Profile::class);
    Route::get('/notification', Livewire\Notifications::class);
    Route::middleware(['role:manager'])->group(function () {
        Route::get('/manager', Livewire\ManagerPanel::class);
        Route::get('/checkInOut/{date}', Livewire\CheckInOut::class);
    });
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin', Admin::class);
        Route::get('/schedule', Livewire\Schedule::class);

        Route::get('/role', Roles::class);
        Route::get('/manageuser/{id}', Livewire\Manageuser::class);
        Route::get('/department', Department::class);
    });

    // Routes for admin only
    Route::middleware(['role:admin|manager'])->group(function () {

        // Route::get('/report', Livewire\Report::class);
    });

    // Routes for users only
    Route::middleware(['role:user'])->group(function () {
        Route::get('/attendance', Livewire\Attendance::class);
        Route::post('/attendance', [Controllers\attendance_form::class, 'store']);
        // Route::get('/setting', Setting::class);
    });
    // Route::middleware(['role:manager'])->group(function () {
    //     Route::get('/admin', Admin::class);
    //     Route::get('/role', Role::class);
    //     Route::get('/schedules', Livewire\Schedule::class);
    //     Route::get('/report', Livewire\Report::class);
    // });
});

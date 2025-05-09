<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontEnd.home');

});
Route::get('/about', function () {
    return view('frontEnd.about');
});
Route::get('/test-error', function () {
    abort(500, 'Test Error');
});



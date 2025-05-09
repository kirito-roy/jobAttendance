<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontEnd.pages.home');

});
Route::get('/test-error', function () {
    abort(500, 'Test Error');
});



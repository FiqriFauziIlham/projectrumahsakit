<?php

use App\Http\Controllers\DokterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('dktr', DokterController::class);

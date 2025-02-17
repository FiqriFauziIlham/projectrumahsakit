<?php

use App\Http\Controllers\DokterController;
use App\Http\Controllers\RuanganController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::resource('dktr', DokterController::class)->middleware('auth');
Route::resource('ruangan', RuanganController::class)->middleware('auth');

Route::get('/login', [HomeController::class, 'loginpage'])->name('login');
Route::post('actionLogin',[LoginController::class, 'actionLogin'])->name('actionLogin');
Route::post('create',[LoginController::class, 'create'])->name('create')->middleware('throttle:5,1');
Route::get('registrasi',[LoginController::class, 'registrasi'])->name('registrasi');
Route::get('actionLogout',[LoginController::class, 'actionLogout'])->name('actionLogout')->middleware('auth');
Route::get('forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('forgot-password');
Route::post('forgot-password/send-code', [ForgotPasswordController::class, 'sendResetCode'])->name('forgot-password.send-code');
Route::post('forgot-password/verify-code', [ForgotPasswordController::class, 'verifyResetCode'])->name('forgot-password.verify-code');
Route::get('reset-password', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset-password');
Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('reset-password.post');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

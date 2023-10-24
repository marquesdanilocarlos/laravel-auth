<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PassResetController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'auth'], function(){
    Route::get('/', HomeController::class)->name('home')->middleware('auth');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});

Route::group(['middleware' => 'guest'], function(){
    Route::get('/register',[RegisterController::class, 'create']);
    Route::post('/register',[RegisterController::class, 'store'])->name('register');
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/forget-password', [PassResetController::class, 'request'])->name('password.request');
    Route::post('/forget-password', [PassResetController::class, 'email'])->name('password.email');
    Route::get('/reset-password', [PassResetController::class, 'reset'])->name('password.reset');
});

Route::post('/reset-password', [PassResetController::class, 'update'])->name('password.update');

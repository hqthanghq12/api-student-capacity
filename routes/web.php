<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/admin');
Route::group(['prefix' => 'auth'], function(){
    Route::get('login', [AuthController::class, 'adminLogin'])->name('login');
    Route::get('google', [AuthController::class, 'redirectToGoogle'])->name('auth.redirect-google');
    Route::get('google/callback', [AuthController::class, 'adminGoogleCallback'])->name('google-auth.callback');
});


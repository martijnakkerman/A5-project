<?php

use Illuminate\Support\Facades\Auth;
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


Auth::routes();
//Home
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Dashboard
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

//User
Route::get('/user/edit', [App\Http\Controllers\User\UserController::class, 'userEdit'])->name('user.edit');
Route::patch('/user/{user}/update', [App\Http\Controllers\User\UserController::class, 'userUpdate'])->name('user.update');

//Band
Route::get('/band/{band}/edit', [App\Http\Controllers\User\BandController::class, 'bandEdit'])->name('band.edit');

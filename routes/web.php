<?php

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

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\AdministratorController;

/* Navegação pelas Páginas */

Route::view('/home', 'inicio')->name('home');

Route::view('/authentication', 'login')->name('authentication');

Route::get('/request', [RequestController::class, 'index'])->name('request');

Route::get('/history', [RequestController::class, 'historico'])->name('history');

//Route::get('/history/{$order}', [RequestController::class, 'show'])->name('history-order');

Route::get('/register', [UserController::class, 'index'])->name('register');

Route::get('/profile', [UserController::class, 'create'])->name('profile');

Route::get('/edit-profile', [UserController::class, 'edit'])->name('edit-profile');

Route::get('/delete-profile', [UserController::class, 'edit'])->name('delete-profile');

Route::get('/show-request/{id}', [RequestController::class, 'show'])->name('show-request');

Route::get('/edit-request/{id}', [RequestController::class, 'edit'])->name('edit-request');

Route::get('/destoy-request/{id}', [RequestController::class, 'destroy'])->name('destoy-request');

/* Autenticação Usuário */
Route::post('/auth', [AuthenticationController::class, 'auth'])->name('auth');

/* Create Usuário */
Route::post('/store-user', [UserController::class, 'store'])->name('store-user');;

/* Create Requerimento */
Route::post('/store-request', [RequestController::class, 'store'])->name('store-request');;

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

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\MarkersController;

/* Navegação pelas Páginas */

/* Inicio */
Route::view('/', 'inicio')->name('index');

Route::post('/theme', [AuthenticationController::class, 'theme'])->name('theme');

/* Autenticação */
Route::view('/authentication', 'login')->name('authentication');

/* Requerimentos */
Route::get('/request', [RequestController::class, 'index'])->name('request');

/* Histórico */
Route::get('/history/{order?}', [RequestController::class, 'create'])->name('history');

/* Forumulário de cadastro de usuário */
Route::get('/register', [UserController::class, 'index'])->name('register');

/*****************************************************************************************************/

/* Perfil */
Route::get('/profile', [UserController::class, 'create'])->name('profile');

/* Editar perfil */
Route::get('/edit-profile', [UserController::class, 'edit'])->name('edit-profile');

/* Atualizar perfil */
Route::post('/update-profile', [UserController::class, 'update'])->name('update-profile');

/* Deletar perfil */
Route::get('/delete-profile', [UserController::class, 'destroy'])->name('delete-profile');

/* Editar senha */
Route::get('/edit-password', [UserController::class, 'edit'])->name('edit-password');

/* Atualizar senha */
Route::post('/update-password', [UserController::class, 'update'])->name('update-password');

/* Exibir requerimento */
Route::get('/show-request/{id}', [RequestController::class, 'show'])->name('show-request');

/* Editar requerimento */
Route::get('/edit-request/{id}', [RequestController::class, 'edit'])->name('edit-request');

/* Atualizar requerimento */
Route::post('/update-request', [RequestController::class, 'update'])->name('update-request');

/* Deletar requerimento */
Route::post('/destoy-request', [RequestController::class, 'destroy'])->name('destoy-request');

/*****************************************************************************************************/

/* Autenticação Usuário */
Route::post('/auth', [AuthenticationController::class, 'auth'])->name('auth');

/* Logout Usuário */
Route::get('/logout', [AuthenticationController::class, 'logout'])->name('logout');

/* Create Usuário */
Route::post('/store-user', [UserController::class, 'store'])->name('store-user');

/* Create Requerimento */
Route::post('/store-request', [RequestController::class, 'store'])->name('store-request');

Route::get('/map', [MarkersController::class, 'index'])->name('map');

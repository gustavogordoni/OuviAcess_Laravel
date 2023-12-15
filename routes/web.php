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

Route::redirect('/', '/home');

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\AdministratorController;

/* Navegação pelas Páginas */

/* Inicio */
Route::view('/home', 'inicio')->name('home');

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
Route::get('/profile', [UserController::class, 'create'])->name('profile')
    ->middleware('auth');

/* Editar perfil */
Route::get('/edit-profile', [UserController::class, 'edit'])->name('edit-profile')
    ->middleware('auth');

/* Atualizar perfil */
Route::post('/update-profile', [UserController::class, 'update'])->name('update-profile')
    ->middleware('auth');

/* Deletar perfil */
Route::get('/delete-profile', [UserController::class, 'edit'])->name('delete-profile')
    ->middleware('auth');

/* Exibir requerimento */
Route::get('/show-request/{id}', [RequestController::class, 'show'])->name('show-request')
    ->middleware('auth');

/* Editar requerimento */
Route::get('/edit-request/{id}', [RequestController::class, 'edit'])->name('edit-request')
    ->middleware('auth');

/* Deletar requerimento */
Route::post('/destoy-request', [RequestController::class, 'destroy'])->name('destoy-request')
    ->middleware('auth');

/*****************************************************************************************************/

/* Autenticação Usuário */
Route::post('/auth', [AuthenticationController::class, 'auth'])->name('auth');

/* Logout Usuário */
Route::get('/logout', [AuthenticationController::class, 'logout'])->name('logout')
    ->middleware('auth');

/* Create Usuário */
Route::post('/store-user', [UserController::class, 'store'])->name('store-user');

/* Create Requerimento */
Route::post('/store-request', [RequestController::class, 'store'])->name('store-request');

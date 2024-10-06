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

/*--------- Controllers ---------*/
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\MarkersController;

/*****************************************************************************************************/
/*--------- Navegação pelas Páginas ---------*/

/* Inicio */
Route::view('/', 'inicio')->name('index');

/* Cor tema */
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
/*--------- Usuário Comum ---------*/

/* Cadastro Usuário */
Route::post('/store-user', [UserController::class, 'store'])->name('store-user');

/* Autenticação Usuário */
Route::post('/auth', [AuthenticationController::class, 'auth'])->name('auth');

/* Perfil */
Route::get('/profile', [UserController::class, 'create'])->name('profile')->middleware('auth');

/* Editar perfil */
Route::get('/edit-profile', [UserController::class, 'edit'])->name('edit-profile')->middleware('auth');

/* Atualizar perfil */
Route::post('/update-profile', [UserController::class, 'update'])->name('update-profile')->middleware('auth');

/* Deletar perfil */
Route::post('/destroy-profile', [UserController::class, 'destroy'])->name('destroy-profile')->middleware('auth');

/* Editar senha */
Route::get('/edit-password', [UserController::class, 'edit'])->name('edit-password')->middleware('auth');

/* Atualizar senha */
Route::post('/update-password', [UserController::class, 'updatePassword'])->name('update-password')->middleware('auth');

/* Logout Usuário */
Route::get('/logout', [AuthenticationController::class, 'logout'])->name('logout')->middleware('auth');


/*****************************************************************************************************/
/*--------- Requerimentos ---------*/

/* Cadastro Requerimento */
Route::post('/store-request', [RequestController::class, 'store'])->name('store-request');

/* Exibir requerimento */
Route::get('/show-request/{id}', [RequestController::class, 'show'])->name('show-request')->middleware('auth');

/* Atualizar requerimento */
Route::post('/update-request', [RequestController::class, 'update'])->name('update-request')->middleware('auth');

/* Editar requerimento */
Route::get('/edit-request/{id}', [RequestController::class, 'edit'])->name('edit-request')->middleware('auth');

/* Deletar requerimento */
Route::post('/destoy-request', [RequestController::class, 'destroy'])->name('destoy-request')->middleware('auth');


/*****************************************************************************************************/
/*--------- Mapa ---------*/
Route::get('/map', [MarkersController::class, 'index'])->name('map');


/*****************************************************************************************************/
/*--------- Administrador ---------*/

/* Lista de requerimentos */
Route::get('/requests/{order?}', [AdministratorController::class, 'requests'])->name('requests')->middleware('auth');

/* Mostrar deltalhes do requerimento */
Route::get('/admin-show-request/{id}', [AdministratorController::class, 'showRequest'])->name('admin-show-request')->middleware('auth');

/* Responder requerimentos */
Route::get('/admin-respond-request/{id}', [AdministratorController::class, 'respondRequest'])->name('admin-respond-request')->middleware('auth');

/* Deletar requerimento */
Route::post('/admin-destoy-request', [AdministratorController::class, 'destroyRequest'])->name('admin-destoy-request')->middleware('auth');


/* Lista de usuários */
Route::get('/users/{order?}', [AdministratorController::class, 'users'])->name('users')->middleware('auth');

/* Mostrar detalhes do usuário */
Route::get('/admin-show-user/{id}', [AdministratorController::class, 'showUser'])->name('admin-show-user')->middleware('auth');

/* Mostrar deltalhes do usuário */
Route::get('/admin-show-user/{id}', [AdministratorController::class, 'showUser'])->name('admin-admin-show-user')->middleware('auth');

/* Deletar usuário */
Route::post('/admin-destroy-user', [AdministratorController::class, 'destroyUser'])->name('admin-destroy-user')->middleware('auth');
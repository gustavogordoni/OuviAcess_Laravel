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

    /* Autenticação Usuário */
    Route::post('/auth', [AuthenticationController::class, 'auth'])->name('auth');

    /* Forumulário de cadastro de usuário (somente para convidados) */
    Route::get('/register', [UserController::class, 'index'])->name('register')->middleware('guest');

    /* Cadastro Usuário */
    Route::post('/store-user', [UserController::class, 'store'])->name('store-user')->middleware('guest');

    /* Mapa (somente clientes ou convidados podem acessar) */
    Route::get('/map', [MarkersController::class, 'index'])->name('map');

/*****************************************************************************************************/
/*--------- Necessitam de Autenticação - independentemente do tipo ---------*/
Route::group(['middleware' => 'auth'], function () {
    /* Perfil */
    Route::get('/profile', [UserController::class, 'create'])->name('profile');    

    /* Editar perfil */
    Route::get('/edit-profile', [UserController::class, 'edit'])->name('edit-profile');

    /* Atualizar perfil */
    Route::post('/update-profile', [UserController::class, 'update'])->name('update-profile');

    /* Deletar perfil */
    Route::post('/destroy-profile', [UserController::class, 'destroy'])->name('destroy-profile');

    /* Editar senha */
    Route::get('/edit-password', [UserController::class, 'edit'])->name('edit-password');

    /* Atualizar senha */
    Route::post('/update-password', [UserController::class, 'updatePassword'])->name('update-password');
    
    /* Logout Usuário */
    Route::get('/logout', [AuthenticationController::class, 'logout'])->name('logout');
});

/*****************************************************************************************************/
/*--------- Usuário Comum ---------*/
Route::group(['middleware' => 'client'], function () {            
    /* Cadastro Requerimento */
    Route::post('/store-request', [RequestController::class, 'store'])->name('store-request');
    
    /* Exibir requerimento */
    Route::get('/show-request/{id}', [RequestController::class, 'show'])->name('show-request');
    
    /* Atualizar requerimento */
    Route::post('/update-request', [RequestController::class, 'update'])->name('update-request');
    
    /* Editar requerimento */
    Route::get('/edit-request/{id}', [RequestController::class, 'edit'])->name('edit-request');
    
    /* Deletar requerimento */
    Route::post('/destoy-request', [RequestController::class, 'destroy'])->name('destoy-request');
});

/*****************************************************************************************************/
/*--------- Administrador ---------*/
Route::group(['middleware' => 'admin'], function () {
    /* Lista de requerimentos */
    Route::get('/requests/{order?}', [AdministratorController::class, 'requests'])->name('requests');
    
    /* Mostrar deltalhes do requerimento */
    Route::get('/admin-show-request/{id}', [AdministratorController::class, 'showRequest'])->name('admin-show-request');
    
    /* Responder requerimentos */
    Route::get('/admin-respond-request/{id}', [AdministratorController::class, 'respondRequest'])->name('admin-respond-request');
    
    /* Deletar requerimento */
    Route::post('/admin-destoy-request', [AdministratorController::class, 'destroyRequest'])->name('admin-destoy-request');
    
    /* Lista de usuários */
    Route::get('/users/{order?}', [AdministratorController::class, 'users'])->name('users');
    
    /* Mostrar detalhes do usuário */
    Route::get('/admin-show-user/{id}', [AdministratorController::class, 'showUser'])->name('admin-show-user');
    
    /* Deletar usuário */
    Route::post('/admin-destroy-user', [AdministratorController::class, 'destroyUser'])->name('admin-destroy-user');
});

/*****************************************************************************************************/
/*--------- Requerimentos (Clientes ou Convidados) ---------*/
Route::group(['middleware' => 'guestOrClient'], function () {
    /* Histórico (acessível para clientes ou não autenticados) */
    Route::get('/history/{order?}', [RequestController::class, 'create'])->name('history');
    
    /* Requerimentos */
    Route::get('/request', [RequestController::class, 'index'])->name('request');
});

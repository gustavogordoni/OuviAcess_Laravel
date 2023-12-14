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

use App\Http\Controllers\NavegationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\AdministratorController;

/* Navegação pelas Páginas */

Route::get('/home', [NavegationController::class, 'index']);

Route::get('/request', [RequestController::class, 'index']);

Route::get('/history', [RequestController::class, 'historico']);

Route::get('/authentication', [NavegationController::class, 'login']);

Route::get('/register', [UserController::class, 'cadastro_usuario']);

Route::get('/profile', [UserController::class, 'create']);

Route::get('/edit-profile', [UserController::class, 'edit']);

Route::get('/delete-profile', [UserController::class, 'edit']);

Route::get('/show-request/{id}', [RequestController::class, 'show']);

Route::get('/edit-request/{id}', [RequestController::class, 'edit']);

Route::get('/destoy-request/{id}', [RequestController::class, 'destroy']);


/* Create Usuário */
Route::post('/adicionar-usuario', [UserController::class, 'store']);

/* Create Requerimento */
Route::post('/adicionar-requerimento', [RequestController::class, 'store']);

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
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RequerimentoController;
use App\Http\Controllers\AdministradorController;

/* Navegação pelas Páginas */

Route::get('/home', [NavegationController::class, 'index']);

Route::get('/request', [NavegationController::class, 'requerimento']);

Route::get('/history', [NavegationController::class, 'historico']);

Route::get('/authentication', [NavegationController::class, 'login']);

Route::get('/register', [NavegationController::class, 'cadastro_usuario']);

Route::get('/profile', [NavegationController::class, 'perfil']);


/* Create Usuário */
Route::post('/adicionar-usuario', [UsuarioController::class, 'store']);

/* Create Requerimento */
Route::post('/adicionar-requerimento', [RequerimentoController::class, 'store']);

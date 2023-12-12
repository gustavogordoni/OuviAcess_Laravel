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

Route::get('/welcome', function () {
    return view('welcome');
});

use App\Http\Controllers\EventController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RequerimentoController;
use App\Http\Controllers\AdministradorController;

/* Navegação pelas Páginas */

Route::get('/', [EventController::class, 'index']);

Route::get('/requerimento', [EventController::class, 'requerimento']);

Route::get('/historico', [EventController::class, 'historico']);

Route::get('/login', [EventController::class, 'login']);

Route::get('/cadastro-usuario', [EventController::class, 'cadastro_usuario']);

Route::get('/perfil', [EventController::class, 'perfil']);


/* Create Usuário */

Route::post('/adicionar-usuario', [UsuarioController::class, 'store']);

/* Create Requerimento */

Route::post('/adicionar-requerimento', [RequerimentoController::class, 'store']);
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

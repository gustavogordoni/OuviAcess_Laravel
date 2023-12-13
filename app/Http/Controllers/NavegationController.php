<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Requerimento;
use App\Models\Usuario;
use App\Models\Administrador;

class NavegationController extends Controller
{
    public function index(){
        return view('inicio');
    }

    public function requerimento(){
        return view('requerimento');
    }

    public function historico(){
        $events = Requerimento::all();
        return view('historico', ['events' => $events]);
    }

    public function login(){
        return view('login');
    }

    public function cadastro_usuario(){
        return view('cadastro-usuario');
    }

    public function perfil(){
        return view('perfil');
    }
}

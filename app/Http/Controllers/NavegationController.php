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

    public function login(){
        return view('login');
    }
}

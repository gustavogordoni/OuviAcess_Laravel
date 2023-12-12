<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class UsuarioController extends Controller
{
   /*
   public function create(){
    return view('.');
   }
   */

   public function store(Request $request){

      $usuario = new Usuario;

      $usuario->nome = $request->nome;
      $usuario->ddd = $request->ddd;
      $usuario->telefone = $request->telefone;
      $usuario->email = $request->email;
      $usuario->senha = $request->senha;

      $usuario->save();

      return redirect('/');
     }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Requerimento;

class RequerimentoController extends Controller
{
    public function store(Request $request){

        $requerimento = new Requerimento;
  
        $requerimento->titulo = $request->titulo;
        $requerimento->tipo = $request->tipo;
        $requerimento->situacao = "Pendente";

        date_default_timezone_set('America/Sao_Paulo');
        $requerimento->data = date('d/m/Y');

        $requerimento->cidade = $request->cidade;
        $requerimento->cep = $request->cep;
        $requerimento->bairro = $request->bairro;
        $requerimento->logradouro = $request->logradouro;
        $requerimento->descricao = $request->descricao;
  
        $requerimento->save();
  
        return redirect('history');
       }
}

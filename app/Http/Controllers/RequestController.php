<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Requerimento;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     * Listar as informações
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('requerimento');
    }

    /**
     * Show the form for creating a new resource.
     * Exibir informações em um formulário
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * INCLUDE - Salvar registro no Banco de Dados
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

    /**
     * Display the specified resource.
     * SELECT com WHERE - Exibir um recurso específico
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $requerimento = Requerimento::where('id', $id)->first();               
        return view('visualizar-requerimento', ['requerimento' => $requerimento]);
    }

    /**
     * Show the form for editing the specified resource.
     * EDIÇÃO - Exibir informações em um formulário
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $requerimento = Requerimento::where('id', $id)->first();               
        return view('editar-requerimento', ['requerimento' => $requerimento]);
    }

    /**
     * Update the specified resource in storage.
     * UPDATE - Atualiza um registro no Banco de Dados
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *  DELETE - Remove um registro do Banco de Dados
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /* MINHAS FUNÇÕES */
    public function historico(){
        $requerimentos = Requerimento::all();
        return view('historico', ['requerimentos' => $requerimentos]);
    }

    public function visualizar_requerimento($id){
        
        
    }
}

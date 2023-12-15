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
    public function create($order = null)
    {
        if(auth()->check()){
            if($order == "date"){
            $requerimentos = Requerimento::where('id_usuario', auth()->user()->id)->orderBy('data', 'asc')->get();
            $order= ['date' => 'asc'];

            }elseif($order == "title"){
            $requerimentos = Requerimento::where('id_usuario', auth()->user()->id)->orderBy('titulo', 'asc')->get();
            $order=['title' => 'asc'];

            }elseif($order == "id"){
            $requerimentos = Requerimento::where('id_usuario', auth()->user()->id)->orderBy('id', 'asc')->get();
            $order=['id' => 'asc'];

            }else{
            $requerimentos = Requerimento::where('id_usuario', auth()->user()->id)->orderBy('data', 'asc')->get();
            $order= ['date' => 'asc'];
            }
            
            return view('historico', compact('requerimentos', 'order'));
        }else{
            $message = ['history' => 'guest'];
            return view('historico', compact('message'));
        }
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
  
        return redirect()->route('history')->with('message', ['success_request' => 'store']);
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
        return view('visualizar-requerimento', compact('requerimento'));        
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
        return view('editar-requerimento', compact('requerimento'));
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
    public function destroy(Request $request)
    {
        $requerimento = Requerimento::find($request->id);
        $requerimento->delete();
        return redirect()->route('history')->with('message', ['success_request' => 'destroy']);
    }
}

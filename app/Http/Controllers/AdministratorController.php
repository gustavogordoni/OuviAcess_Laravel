<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministratorController extends Controller
{
    /**
     * Display a listing of the resource.
     * Listar as informações
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     * Exibir informações em um formulário
     * @return \Illuminate\Http\Response
     */
    public function create($order = null)
    {
        if ($order == "cards") {
            $layout = "cards";
        } else {
            $layout = "table";
        }

        if (auth()->check()) {
            /*
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

            //Gate::authorize('manipularRequerimento', $requerimentos);
            */

            return view('admin.requerimentos', compact('requerimentos', 'order', 'layout'));
        } else {
            $message = ['requests' => 'guest'];
            return view('admin.requerimentos', compact('message'));
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
        //
    }

    /**
     * Display the specified resource.
     * SELECT com WHERE - Exibir um recurso específico
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * EDIÇÃO - Exibir informações em um formulário
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
}

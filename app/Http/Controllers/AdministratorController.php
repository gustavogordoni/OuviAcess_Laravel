<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Requerimento;
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

    public function requests($order = null)
{
    $layout = $order == "cards" ? "cards" : "table";

    if (auth()->check() && auth()->user()->type == 1) {
        $query = Requerimento::query();

        if ($order == "date") {
            $query->orderBy('data', 'asc');
            $order = ['date' => 'asc'];
        } elseif ($order == "title") {
            $query->orderBy('titulo', 'asc');
            $order = ['title' => 'asc'];
        } elseif ($order == "id") {
            $query->orderBy('id', 'asc');
            $order = ['id' => 'asc'];
        } else {
            $query->orderBy('data', 'asc');
            $order = ['date' => 'asc'];
        }

        $requerimentos = $query->paginate(10);

        return view('admin.requerimentos', compact('requerimentos', 'order', 'layout'));
    } else {
        $message = ['requests' => 'guest'];
        return view('admin.requerimentos', compact('message'));
    }
}

}

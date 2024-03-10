<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Requerimento;
use App\Models\Arquivo;
use Illuminate\Auth\Access\Gate;

class RequestController extends Controller
{

    public function __construct(){
        $this->middleware('auth')->only(['edit', 'update', 'destroy']);
    }
        
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
        if($order == "cards"){
            $layout = "cards";
        }else{
            $layout = "table";
        }

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

            //Gate::authorize('manipularRequerimento', $requerimentos);
            
            return view('historico', compact('requerimentos', 'order', 'layout'));
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
        $requerimento = $request->all();

        if(auth()->check() && empty($request->anonimo)){
            $requerimento['id_usuario'] = auth()->user()->id;

        }else{
            $requerimento['id_usuario'] = null;
        } 

        $requerimento['situacao'] = "Pendente";
        date_default_timezone_set('America/Sao_Paulo');
        $requerimento['data'] = date('Y-m-d');    
        
        $requerimento = Requerimento::create($requerimento);

        $idRequerimento = $requerimento->id;

        for ($i = 0; $i < 5; $i++) {
            $inputName = "image_$i";
        
            if ($request->hasFile($inputName) && $request->file($inputName)->isValid()) {
                $requestImage = $request->$inputName;
                $extension = $requestImage->extension();
                $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
                $requestImage->move(public_path('image/imageRequest'), $imageName);
        
                $arquivo = new Arquivo;
                $arquivo->id_requerimento = $idRequerimento; 
                $arquivo->name = $imageName;
                $arquivo->save();
            } 
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $requestImage = $request->image;
                $extension = $requestImage->extension();
                $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
                $requestImage->move(public_path('image/imageRequest'), $imageName);
            
                $arquivo = new Arquivo;
                $arquivo->id_requerimento = $idRequerimento; 
                $arquivo->name = $imageName;
                $arquivo->save();
            }
        }        

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
        $arquivos = Arquivo::where('id_requerimento', $id)->get();

        $requerimento = Requerimento::where('id', $id)->first();    
        return view('visualizar-requerimento', compact('requerimento', 'arquivos'));
       
    }

    /**
     * Show the form for editing the specified resource.
     * EDIÇÃO - Exibir informações em um formulário
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $arquivos = Arquivo::where('id_requerimento', $id)->get();

        $requerimento = Requerimento::where('id', $id)->first();               
        return view('editar-requerimento', compact('requerimento', 'arquivos'));
    }

    /**
     * Update the specified resource in storage.
     * UPDATE - Atualiza um registro no Banco de Dados
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $requerimento = Requerimento::find($request->id);

        $requerimento->update([
            'titulo' => $request->titulo,
            'tipo' => $request->tipo,
            'cidade' => $request->cidade,
            'cep' => $request->cep,
            'bairro' => $request->bairro,
            'logradouro' => $request->logradouro,
            'descricao' => $request->descricao,
        ]);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
    
            $requestImage->move(public_path('image/imageRequest'), $imageName);
    
            // Encontrar o arquivo existente associado ao requerimento
            $arquivo = Arquivo::where('id_requerimento', $request->id)->first();
    
            // Se o arquivo existir, atualize-o; caso contrário, crie um novo
            if ($arquivo) {
                $arquivo->update([
                    'name' => $imageName,
                ]);
            } else {
                $arquivo = new Arquivo;
                $arquivo->id_requerimento = $request->id; 
                $arquivo->name = $imageName;
                $arquivo->save();
            }
        }   
            return redirect()->route('history')->with('message', ['success_request' => 'update']);
        }

    /**
     * Remove the specified resource from storage.
     *  DELETE - Remove um registro do Banco de Dados
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Arquivo::where('id_requerimento', $request->id)->delete();

        $requerimento = Requerimento::find($request->id);
        $requerimento->delete();
        return redirect()->route('history')->with('message', ['success_request' => 'destroy']);
    }
}

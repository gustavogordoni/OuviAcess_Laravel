<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only(['create', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     * Listar as informações
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cadastro-usuario');
    }

    /**
     * Show the form for creating a new resource.
     * Exibir informações em um formulário
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usuario = auth()->user();
       
        return view('perfil', compact('usuario'));
       
    }

    /**
     * Store a newly created resource in storage.
     * INCLUDE - Salvar registro no Banco de Dados
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->all();
        $user['password'] = bcrypt($request->password);
        $user = User::create($user);

        Auth::login($user);

        return redirect()->route('index')->with('message', ['success_authentication' => auth()->user()->name]);
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
    public function edit()
    {
        $usuario = auth()->user();
       
        return view('editar-perfil', compact('usuario'));
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
        $usuario = User::find(auth()->user()->id);

        $usuario->update([
            'name' => $request->name,
            'ddd' => $request->ddd,
            'phone' => $request->phone,
            //'email' => $request->cep,
        ]);

        return redirect()->route('profile')->with('message', ['success_profile' => 'update']);
    }

     /**
     * Update the specified resource in storage.
     * UPDATE - Atualiza um registro no Banco de Dados
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        $usuario = User::find(auth()->user()->id);

        // Senha atual está correta
        if (password_verify($request->password, $usuario['password'])) {
            // Confirmação da senha nova
            if($request->newpassword == $request->confirmpassword){
                // Nova senha é diferente da atual
                if (!password_verify($request->newpassword, $usuario['password'])) {
                    /*
                    $usuario->update([
                        'password' => bcrypt($request->newpassword),
                    ]);
                    */
                    return redirect()->route('profile')->with('message', ['success_user' => 'updatePassword']);
                    
                }else{
                    return redirect()->route('edit-profile')->with('message', ['error_user' => 'existPassword']);
                }               
            }else{
                return redirect()->route('edit-profile')->with('message', ['error_user' => 'invalidConfirm']);
            }
        }else{
            return redirect()->route('edit-profile')->with('message', ['error_user' => 'invalidPassword']);
        }
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

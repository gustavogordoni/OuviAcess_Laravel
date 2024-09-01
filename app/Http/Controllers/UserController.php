<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\Requerimento;
use App\Models\Arquivo;
use App\Models\Marker;

class UserController extends Controller
{
    public function __construct()
    {
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
    public function store(StoreUserRequest $request)
    {
        $user = $request->all();
        $user['password'] = bcrypt($request->password);
        $user['type'] = User::USER_TYPE_COMMON;

        $user = User::create($user);

        Auth::login($user);

        return redirect()
            ->route('index')
            ->with('info', 'Seja bem-vindo(a) ' . auth()->user()->name);
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
            'phone' => $request->phone,
            //'email' => $request->email,
        ]);

        return redirect()
            ->route('profile')
            ->with('success', 'Perfil atualizado com sucesso!');
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
            if ($request->newpassword == $request->confirmpassword) {
                // Nova senha é diferente da atual
                if (!password_verify($request->newpassword, $usuario['password'])) {

                    $usuario->update([
                        'password' => bcrypt($request->newpassword),
                    ]);

                    return redirect()
                        ->route('profile')
                        ->with('success', 'Senha atualizada com sucesso!');
                } else {
                    return redirect()
                        ->route('edit-profile')
                        ->with('message', ['error_user' => 'existPassword']);
                }
            } else {
                return redirect()
                    ->route('edit-profile')
                    ->with('message', ['error_user' => 'invalidConfirm']);
            }
        } else {
            return redirect()
                ->route('edit-profile')
                ->with('message', ['error_user' => 'invalidPassword']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *  DELETE - Remove um registro do Banco de Dados
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // Validação da senha atual
        $request->validate([
            'password' => 'required|string|min:6|max:50',
        ]);

        $userId = Auth::id(); // Obtém o ID do usuário autenticado
        $user = User::find($userId); // Busca o usuário pelo ID

        // Verifica se o usuário foi encontrado e se a senha está correta
        if ($user && Hash::check($request->password, $user->password)) {
            // Excluir os registros relacionados nos requerimentos
            $requerimentos = Requerimento::where('id_usuario', $userId)->get();
            foreach ($requerimentos as $requerimento) {
                // Excluir arquivos relacionados
                Arquivo::where('id_requerimento', $requerimento->id)->delete();
                // Excluir marcadores relacionados
                Marker::where('id_requerimento', $requerimento->id)->delete(); // Assumindo que você tem uma relação com marcadores
                // Excluir o requerimento
                $requerimento->delete();
            }

            // Excluir o usuário
            $user->delete();

            // Desloga o usuário após a exclusão
            Auth::logout();

            // Redireciona para a página inicial com uma mensagem de sucesso
            return redirect()->route('index')->with('success', 'Conta deletada com sucesso!');
        } else {
            // Mensagens de erro detalhadas
            if (!$user) {
                return redirect()->back()->withErrors(['error_user' => 'Usuário não encontrado.']);
            } elseif (!Hash::check($request->password, $user->password)) {
                return redirect()->back()->withErrors(['error_user' => 'A senha informada está incorreta.']);
            } else {
                return redirect()->back()->withErrors(['error_user' => 'Erro ao deletar conta.']);
            }
        }
    }
}

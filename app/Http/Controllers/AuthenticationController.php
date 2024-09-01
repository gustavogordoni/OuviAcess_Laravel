<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthenticationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('logout');
    }

    public function auth(Request $request)
    {
        // Validação dos dados de entrada
        $credenciais = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6', 'max:50'],
        ], [
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Informe um email válido.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter no mínimo 6 caracteres.',
            'password.max' => 'A senha deve ter no máximo 50 caracteres.',
        ]);


        // Verifica se o email existe na base de dados
        $user = User::where('email', $credenciais['email'])->first();

        if (!$user) {
            // Se o email não existir, retorna um erro específico no campo email
            return redirect()
                ->route('authentication')
                ->withInput() // Garante que o valor antigo seja preservado
                ->withErrors([
                    'email' => 'Email informado não foi encontrado.',
                ]);
        }

        // Se o email existir, tenta autenticar
        if (Auth::attempt($credenciais, $request->remember)) {
            // Regenera a sessão após a autenticação bem-sucedida
            $request->session()->regenerate();

            // Redireciona para a página inicial com uma mensagem de boas-vindas
            return redirect()
                ->route('index')
                ->with('info', 'Seja bem-vindo(a) ' . auth()->user()->name);
        }

        // Se a senha estiver incorreta, retorna um erro específico no campo senha
        return redirect()
            ->route('authentication')
            ->withInput() // Garante que o valor antigo seja preservado
            ->withErrors([
                'password' => 'Senha inválida. Por favor, tente novamente.',
            ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('index')->with('message', ['logout' => 'success']);
    }

    public function theme(Request $request)
    {

        $tempo_expiracao = time() + (60 * 60 * 24);
        setcookie("tema", $request->theme, $tempo_expiracao, "/");

        return redirect()->back();
    }
}

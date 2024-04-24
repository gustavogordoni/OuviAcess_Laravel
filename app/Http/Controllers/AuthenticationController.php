<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only('logout');
    }

    public function auth(Request $request){
        $credenciais = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ],[
            'email.required' => 'email.required',
            'email.email' => 'email.email',
            'password.required' => 'password.required',
        ]);

        if(Auth::attempt($credenciais, $request->remember)){
            $request->session()->regenerate();
            return redirect()
                ->route('index')
                //->with('message', ['success_authentication' => auth()->user()->name]);
                ->with('info', 'Seja bem-vindo(a) '. auth()->user()->name);
        }else{
            return redirect()
                ->route('authentication')
                /*->with('message', ['error_authentication' => 'any'])*/;
        } 
    }       

    public function logout(Request $request){        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('index')->with('message', ['logout' => 'success']);
    }

    public function theme(Request $request){       
        
        $tempo_expiracao = time() + (60 * 60 * 24);
        setcookie("tema", $request->theme, $tempo_expiracao, "/");
        
        return redirect()->back();
    }
}

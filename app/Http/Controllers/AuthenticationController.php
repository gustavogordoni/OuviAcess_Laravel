<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function auth(Request $request){
        $credenciais = $request->validate([
            'email' => ['required', 'email'],
            'senha' => ['required'],
        ]);

        if(Auth::attempt($credenciais)){
            $request->session()->regenerate();
            return redirect()->intended('home')->with('message', ['success_authentication' => 'Nome do Meliante']);
        }else{
            return redirect()->route('home')->with('message', ['error_authentication' => 'Tipo erro']);
        } 
    }       
}

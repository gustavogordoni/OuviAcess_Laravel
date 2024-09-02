<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Arquivo;
use Illuminate\Http\Request;
use App\Models\Requerimento;
use Illuminate\Support\Facades\Auth;

class AdministratorController extends Controller
{
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

    public function showRequest($id)
    {
        $arquivos = Arquivo::where('id_requerimento', $id)->get();
        $requerimento = Requerimento::where('id', $id)->first();
        $usuario = User::where('id', $requerimento->id_usuario)->first();
        return view('admin.visualizar-requerimento', compact('requerimento', 'arquivos', 'usuario'));
    }

    public function respondRequest($id)
    {
        $arquivos = Arquivo::where('id_requerimento', $id)->get();

        $requerimento = Requerimento::where('id', $id)->first();
        return view('admin.responder', compact('requerimento', 'arquivos'));
    }

    public function destroyRequest(Request $request)
    {
        Arquivo::where('id_requerimento', $request->id)->delete();

        $requerimento = Requerimento::find($request->id);
        $requerimento->delete();
        return redirect()->route('history')->with('success', 'Requerimento excluído com sucesso!');
    }

    public function showUser($id)
    {
        $usuario = User::where('id', $id)->first();
        return view('admin.visualizar-usuario', compact('usuario'));
    }
}

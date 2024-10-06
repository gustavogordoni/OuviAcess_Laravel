<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Arquivo;
use Illuminate\Http\Request;
use App\Models\Requerimento;
use Illuminate\Support\Facades\Auth;

class AdministratorController extends Controller
{
    // public function requests($order = null)
    // {
    //     $layout = $order == "cards" ? "cards" : "table";

    //     if (auth()->check() && auth()->user()->type == 1) {
    //         $query = Requerimento::query();

    //         if ($order == "date") {
    //             $query->orderBy('data', 'asc');
    //             $order = ['date' => 'asc'];
    //         } elseif ($order == "title") {
    //             $query->orderBy('titulo', 'asc');
    //             $order = ['title' => 'asc'];
    //         } elseif ($order == "id") {
    //             $query->orderBy('id', 'asc');
    //             $order = ['id' => 'asc'];
    //         } else {
    //             $query->orderBy('data', 'asc');
    //             $order = ['date' => 'asc'];
    //         }

    //         $requerimentos = $query->paginate(25);

    //         return view('admin.requerimentos', compact('requerimentos', 'order', 'layout'));
    //     } else {
    //         $message = ['requests' => 'guest'];
    //         return view('admin.requerimentos', compact('message'));
    //     }
    // }

    // public function requests(Request $request, $order = null)
    // {
    //     $layout = $order == "cards" ? "cards" : "table";

    //     if (auth()->check() && auth()->user()->type == 1) {
    //         $query = Requerimento::query();

    //         if ($request->has('filterColumn') && $request->has('filterValue')) {
    //             $filterColumn = $request->input('filterColumn');
    //             $filterValue = $request->input('filterValue');
                
    //             $allowedFilters = ['titulo', 'tipo', 'situacao', 'data'];
    //             if (in_array($filterColumn, $allowedFilters)) {
    //                 $query->where($filterColumn, 'like', '%' . $filterValue . '%');
    //             }
    //         }

    //         if ($order == "date") {
    //             $query->orderBy('data', 'asc');
    //             $order = ['date' => 'asc'];
    //         } elseif ($order == "title") {
    //             $query->orderBy('titulo', 'asc');
    //             $order = ['title' => 'asc'];
    //         } elseif ($order == "id") {
    //             $query->orderBy('id', 'asc');
    //             $order = ['id' => 'asc'];
    //         } else {
    //             $query->orderBy('data', 'asc');
    //             $order = ['date' => 'asc'];
    //         }

    //         $requerimentos = $query->paginate(25);

    //         return view('admin.requerimentos', compact('requerimentos', 'order', 'layout'));
    //     } else {
    //         $message = ['requests' => 'guest'];
    //         return view('admin.requerimentos', compact('message'));
    //     }
    // }

    public function requests(Request $request)
{
    $layout = $request->get('layout', 'table'); // Padrão para 'table' se não for definido
    $order = $request->get('order', null); // Ordenação pode ser definida via query string

    if (auth()->check() && auth()->user()->type == 1) {
        $query = Requerimento::query();

        // Lógica de filtragem
        if ($request->has('filterValue')) {
            $filterValue = $request->input('filterValue');
            $filterColumn = $request->input('filterColumn');

            // Verifica se a coluna de filtro foi selecionada
            if ($filterColumn && $filterColumn != '') {
                // Filtra pela coluna específica
                $query->where($filterColumn, 'like', '%' . $filterValue . '%');
            } else {
                // Se nenhuma coluna for selecionada, filtra em todas as colunas definidas
                $query->where(function ($q) use ($filterValue) {
                    $q->where('titulo', 'like', '%' . $filterValue . '%')
                      ->orWhere('tipo', 'like', '%' . $filterValue . '%')
                      ->orWhere('situacao', 'like', '%' . $filterValue . '%')
                      ->orWhere('data', 'like', '%' . $filterValue . '%');
                });
            }
        }

        // Lógica de ordenação
        if ($order == "date") {
            $query->orderBy('data', 'asc');
        } elseif ($order == "title") {
            $query->orderBy('titulo', 'asc');
        } elseif ($order == "id") {
            $query->orderBy('id', 'asc');
        }

        $requerimentos = $query->paginate(25);

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


    public function users($order = null)
    {
        if (auth()->check() && auth()->user()->type == 1) {
            $query = User::query()->where('type', '=', 2); // Apenas clientes

            if ($order == "id") {
                $query->orderBy('id', 'asc');
                $order = ['id' => 'asc'];
            } elseif ($order == "name") {
                $query->orderBy('name', 'asc');
                $order = ['name' => 'asc'];
            } elseif ($order == "email") {
                $query->orderBy('email', 'asc');
                $order = ['email' => 'asc'];
            } else {
                $query->orderBy('id', 'asc');
                $order = ['id' => 'asc'];
            }

            $usuarios = $query->paginate(25);

            return view('admin.usuarios', compact('usuarios', 'order'));
        } else {
            $message = ['users' => 'guest'];
            return view('admin.usuarios', compact('message'));
        }
    }

    public function showUser($id)
    {
        $usuario = User::where('id', $id)->first();
        return view('admin.visualizar-usuario', compact('usuario'));
    }
    public function destroyUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::find($request->user_id);

        if ($user) {
            $user->delete();
            return redirect()->route('users')->with('success', 'Usuário deletado com sucesso!');
        }

        return redirect()->route('users')->with('error', 'Usuário não encontrado.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Marker;
use App\Models\Arquivo;
use Illuminate\Http\Request;
use App\Models\Requerimento;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdministratorController extends Controller
{
    public function requests(Request $request, $order = null)
    {
        $layout = $order == "cards" ? "cards" : "table";

        if (auth()->check() && auth()->user()->type == 1) {
            $query = Requerimento::query();

            if ($request->has('filterValue')) {
                $filterColumn = $request->input('filterColumn');
                $filterValue = $request->input('filterValue');

                $allowedFilters = ['titulo', 'tipo', 'situacao', 'data', 'id', 'id_usuario'];

                if ($filterColumn && in_array($filterColumn, $allowedFilters)) {
                    if ($filterColumn == 'id_usuario') {
                        $query->whereHas('usuario', function ($q) use ($filterValue) {
                            $q->where('id', $filterValue);
                        });
                    } else {
                        $query->where($filterColumn, 'like', '%' . $filterValue . '%');
                    }
                } elseif ($filterValue) {
                    $query->where(function ($q) use ($filterValue) {
                        $q->where('titulo', 'like', '%' . $filterValue . '%')
                            ->orWhere('tipo', 'like', '%' . $filterValue . '%')
                            ->orWhere('situacao', 'like', '%' . $filterValue . '%')
                            ->orWhere('data', 'like', '%' . $filterValue . '%')
                            ->orWhere('id', $filterValue)
                            ->orWhere('id_usuario', $filterValue);
                    });
                }
            }

            if ($order == "date") {
                $query->orderBy('data', 'asc');
            } elseif ($order == "title") {
                $query->orderBy('titulo', 'asc');
            } elseif ($order == "id") {
                $query->orderBy('id', 'asc');
            } elseif ($order == "id_usuario") {
                $query->orderBy('id_usuario', 'asc');
            } else {
                $query->orderBy('data', 'asc');
            }

            $requerimentos = $query->paginate(25)->appends(request()->except('page'));

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
        return redirect()->route('admin.requerimentos')->with('success', 'Requerimento excluído com sucesso!');
    }

    // --------------------------------------------------------------------------------------------------
    public function users(Request $request, $order = null)
    {
        if (auth()->check() && auth()->user()->type == 1) {
            $query = User::query()->where('type', '=', 2);

            if ($request->has('filterValue')) {
                $filterColumn = $request->input('filterColumn');
                $filterValue = $request->input('filterValue');

                $allowedFilters = ['name', 'email', 'id'];

                if ($filterColumn && in_array($filterColumn, $allowedFilters)) {
                    $query->where($filterColumn, 'like', '%' . $filterValue . '%');
                } else {
                    $query->where(function ($q) use ($filterValue) {
                        $q->where('name', 'like', '%' . $filterValue . '%')
                            ->orWhere('email', 'like', '%' . $filterValue . '%')
                            ->orWhere('id', 'like', '%' . $filterValue . '%');
                    });
                }
            }

            if ($order == "id") {
                $query->orderBy('id', 'asc');
            } elseif ($order == "name") {
                $query->orderBy('name', 'asc');
            } elseif ($order == "email") {
                $query->orderBy('email', 'asc');
            } else {
                $query->orderBy('id', 'asc');
            }

            $usuarios = $query->paginate(25)->appends(request()->except('page'));

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
            'id' => 'required|exists:users,id',
            'password' => 'required|string|min:6|max:50',
        ]);

        $userId = $request->id;
        $user = User::find($userId);

        if ($user && Hash::check($request->password, auth()->user()->password)) {
            $requerimentos = Requerimento::where('id_usuario', $userId)->get();

            foreach ($requerimentos as $requerimento) {
                Arquivo::where('id_requerimento', $requerimento->id)->delete();
                Marker::where('id_requerimento', $requerimento->id)->delete();
                $requerimento->delete();
            }

            $user->delete();
            return redirect()->route('users')->with('success', 'Conta banida com sucesso!');
        } else {
            return redirect()->back()->withErrors(['error_user' => 'A senha informada está6 incorreta!']);
        }
    }
}

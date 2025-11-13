<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Marker;
use App\Models\Arquivo;
use App\Models\Requerimento;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AdministratorController extends Controller
{
    public function requests(Request $request, $order = null)
    {
        $validated = $request->validate([
            'filterColumn' => 'nullable|string|in:titulo,tipo,situacao,data,id,id_usuario',
            'filterValue' => 'nullable|string|max:255'
        ]);

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

            switch ($order) {
                case "date":
                    $query->orderBy('data', 'asc');
                    break;
                case "title":
                    $query->orderBy('titulo', 'asc');
                    break;
                case "id":
                    $query->orderBy('id', 'asc');
                    break;
                case "id_usuario":
                    $query->orderBy('id_usuario', 'asc');
                    break;
                default:
                    $query->orderBy('data', 'asc');
                    break;
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
        try {
            $arquivos = Arquivo::where('id_requerimento', $id)->get();
            $requerimento = Requerimento::findOrFail($id);
            $usuario = User::findOrFail($requerimento->id_usuario);
            $admin = User::where('id', $requerimento->id_administrador)->first();

            return view('admin.visualizar-requerimento', compact('requerimento', 'arquivos', 'usuario', 'admin'));
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withErrors(['error_request' => 'Requerimento ou usuário não encontrado.']);
        }
    }

    public function respondRequest($id)
    {
        try {
            $requerimento = Requerimento::findOrFail($id);
            $arquivos = Arquivo::where('id_requerimento', $id)->get();

            return view('admin.responder', compact('requerimento', 'arquivos'));
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withErrors(['error_request' => 'Requerimento não encontrado.']);
        }
    }

    public function updateRequest(Request $request)
    {
        $request->validate([
            'situacao' => 'required|in:Concluído,Recusado,Informações incompletas',
            'resposta' => 'required|min:10',
        ]);

        $requerimento = Requerimento::find($request->id);
        $requerimento->situacao = $request->situacao;
        $requerimento->resposta = $request->resposta;
        $requerimento->id_administrador = auth()->user()->id;
        $requerimento->save();

        return redirect()->route('requests')->with('success', 'Resposta cadastrada com sucesso.');
    }


    public function destroyRequest(Request $request)
    {
        try {
            $requerimento = Requerimento::findOrFail($request->id);
            Arquivo::where('id_requerimento', $request->id)->delete();
            $requerimento->delete();

            return redirect()->route('requests')->with('success', 'Requerimento excluído com sucesso!');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withErrors(['error_request' => 'Requerimento não encontrado.']);
        }
    }
    // --------------------------------------------------------------------------------------------------
    public function users(Request $request, $order = null)
    {
        if (auth()->check() && auth()->user()->type == 1) {
            $query = User::query()->where('type', 2);

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

            $query->when($order, function ($q, $order) {
                $q->orderBy($order, 'asc');
            }, function ($q) {
                $q->orderBy('id', 'asc');
            });

            $usuarios = $query->paginate(25)->appends(request()->except('page'));

            return view('admin.usuarios', compact('usuarios', 'order'));
        } else {
            $message = ['users' => 'guest'];
            return view('admin.usuarios', compact('message'));
        }
    }

    public function showUser($id)
    {
        try {
            $usuario = User::findOrFail($id);
            return view('admin.visualizar-usuario', compact('usuario'));
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withErrors(['error_user' => 'Usuário não encontrado.']);
        }
    }

    public function destroyUser(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'password' => 'required|string|min:6|max:50',
        ]);

        try {
            if (Hash::check($request->password, auth()->user()->password)) {
                $user = User::findOrFail($request->id);

                $requerimentos = Requerimento::where('id_usuario', $user->id)->get();
                foreach ($requerimentos as $requerimento) {
                    Arquivo::where('id_requerimento', $requerimento->id)->delete();
                    Marker::where('id_requerimento', $requerimento->id)->delete();
                    $requerimento->delete();
                }

                $user->delete();
                return redirect()->route('users')->with('success', 'Conta banida com sucesso!');
            } else {
                return redirect()->back()->withErrors(['error_user' => 'A senha informada está incorreta!']);
            }
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withErrors(['error_user' => 'Usuário não encontrado.']);
        }
    }

    public function index($id)
    {
        try {
            $admin = User::where('type', 1)->findOrFail($id);
            return view('admin.visualizar-administrador', compact('admin'));
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withErrors(['error_admin' => 'Administrador não encontrado.']);
        }
    }
}

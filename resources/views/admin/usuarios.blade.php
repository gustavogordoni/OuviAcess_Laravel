@extends('layouts.html')
@section('title', '- Users')

@section('body')
@include ('layouts.funcoes')
@include ('layouts.navbar')

{{-- Verifica se existe usuarios. OBS: não entra aqui (entra no else) quem não estiver logado --}}
@isset($usuarios)

{{-- Verifica se existem usuarios cadastrados pelo user --}}
@if(count($usuarios) > 0)

<form method="GET" action="{{ route('users', ['order' => request('order')]) }}">
    <nav aria-label="..." class="mt-3">
        <ul class="pagination justify-content-center mb-0 ms-3 me-3">
            <li class="page-item disabled me-2">
                <a class="page-link">Filtrar por:</a>
            </li>

            <li class="page-item me-2">
                <select class="form-select" name="filterColumn" id="filterColumn">
                    <option value="" selected>-</option>
                    <option value="id" {{ request('filterColumn')=='id' ? 'selected' : '' }}>ID</option>
                    <option value="name" {{ request('filterColumn')=='name' ? 'selected' : '' }}>Nome</option>
                    <option value="email" {{ request('filterColumn')=='email' ? 'selected' : '' }}>Email</option>
                </select>
            </li>

            <li class="page-item me-2">
                <input type="text" name="filterValue" id="filterValue" class="form-control"
                    placeholder="Informe o parâmetro" value="{{ request('filterValue') }}">
            </li>

            <li class="page-item">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </li>
        </ul>
    </nav>
</form>

<div class="table-responsive mt-2">
    <table class="table table-striped table-md mb-0">
        <thead>
            <tr class="text-center">
                <th scope="col" style="width:5%;">
                    <a class="link-info"
                        href="{{ route('users', ['order' => 'id', 'filterColumn' => request('filterColumn'), 'filterValue' => request('filterValue')]) }}">ID</a>
                </th>
                <th scope="col" style="width:25%;">
                    <a class="link-info"
                        href="{{ route('users', ['order' => 'name', 'filterColumn' => request('filterColumn'), 'filterValue' => request('filterValue')]) }}">Nome</a>
                </th>
                <th scope="col" style="width:25%;">
                    <a class="link-info"
                        href="{{ route('users', ['order' => 'email', 'filterColumn' => request('filterColumn'), 'filterValue' => request('filterValue')]) }}">Email</a>
                </th>
                <th scope="col" style="width:10%;"></th>
            </tr>
        </thead>

        <tbody>
            @foreach($usuarios as $usuario)
            <tr class="text-center">
                <td>{{ $usuario->id }}</td>
                <td>{{ $usuario->name }}</td>
                <td>{{ $usuario->email }}</td>
                <td>
                    <a href="{{ route('admin-show-user', $usuario->id) }}"
                        class=" btn btn-outline-primary my-auto mx-1 rounded-circle p-2" name="visualizar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-eye-fill" viewBox="0 0 16 16">
                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                            <path
                                d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                        </svg>
                    </a>

                    <button type="button" class="btn btn-outline-danger my-auto mx-1 rounded-circle p-2"
                        data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{ $usuario->id }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-trash3-fill" viewBox="0 0 16 16">
                            <path
                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z">
                            </path>
                        </svg>
                    </button>
                </td>
            </tr>

            {{-- <div class="modal fade" id="staticBackdrop-{{ $usuario->id }}" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 text-center text-warning">Deseja excluir permanentemente este
                                usuário?</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-footer mx-auto">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>
                            <form action="{{ route('admin-destroy-user') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger" value="{{ $usuario->id }}"
                                    name="id">Deletar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="modal fade" id="staticBackdrop-{{ $usuario->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog  modal-dialog-centered">
                    <div class="modal-content">
                        <form action="{{ route('admin-destroy-user') }}" method="POST" class="form my-auto">
                            @csrf
                            <div class="modal-header">
                                <p class="modal-title fs-4 text-center" id="staticBackdropLabel">Confirme sua senha,
                                    antes de
                                    realizar o banimento da conta do cliente</p>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <div class="col-12 mt-2">
                                    <label for="password" class="form-label text-center" id="label_atual"><strong>Senha:
                                        </strong></label>
                                    <input type="password" class="form-control" id="password" name="password" required
                                        maxlength="50">
                                </div>
                            </div>
                            <div class="modal-footer mx-auto w-100 d-flex justify-content-center">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>
                                <button type="submit" class="btn btn-danger" value="{{ $usuario->id }}"
                                    name="id">Banir</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Mantenha: Verifica se existe usuarios cadastrados pelo user --}}
@else
<x-HistoryEmpty />
@endif

{{-- Mantenha: Exibe caso o usuário não estiver autenticado --}}
@else
<x-HistoryGuest />
@endisset

<x-alert />

@endsection
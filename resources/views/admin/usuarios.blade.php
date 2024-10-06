@extends('layouts.html')
@section('title', '- Users')

@section('body')
@include ('layouts.funcoes')
@include ('layouts.navbar')

{{-- Verifica se existe usuarios. OBS: não entra aqui (entra no else) quem não estiver logado --}}
@isset($usuarios)

{{-- Verifica se existem usuarios cadastrados pelo user --}}
@if(count($usuarios) > 0)

<div class="table-responsive mt-2">
    <table class="table table-striped table-md mb-0">
        <thead>
            <tr class="table text-center">
                @if (isset($order['id']))
                <th scope="col" style="width:5%;">
                    <strong class="modal-title"><a class="link-info link-offset-1"
                            href="{{ route('users', 'id') }}">ID</a>

                        <svg xmlns="http://www.w3.org/2000/svg" class="m-0 p-0 text-info" width="12" height="12"
                            fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                            <path
                                d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                        </svg>

                    </strong>
                </th>
                @else
                <th scope="col" style="width:5%;">
                    <strong class="modal-title"><a class="link-info link-offset-1"
                            href="{{ route('users', 'id') }}">ID</a></strong>
                </th>
                @endif

                @if (isset($order['name']))
                <th scope="col" style="width:25%;">
                    <strong class="modal-title"><a class="link-info link-offset-1"
                            href="{{ route('users', 'name') }}">Nome</a>

                        <svg xmlns="http://www.w3.org/2000/svg" class="m-0 p-0 text-info" width="12" height="12"
                            fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                            <path
                                d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                        </svg>

                    </strong>
                </th>
                @else
                <th scope="col" style="width:25%;">
                    <strong class="modal-title"><a class="link-info link-offset-1"
                            href="{{ route('users', 'name') }}">Nome</a></strong>
                </th>
                @endif

                @if (isset($order['email']))
                <th scope="col" style="width:25%;">
                    <strong class="modal-title"><a class="link-info link-offset-1"
                            href="{{ route('users', 'email') }}">Email</a>

                        <svg xmlns="http://www.w3.org/2000/svg" class="m-0 p-0 text-info" width="12" height="12"
                            fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                            <path
                                d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                        </svg>

                    </strong>
                </th>
                @else
                <th scope="col" style="width:25%;">
                    <strong class="modal-title"><a class="link-info link-offset-1"
                            href="{{ route('users', 'email') }}">Email</a></strong>
                </th>
                @endif

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

            <div class="modal fade" id="staticBackdrop-{{ $usuario->id }}" data-bs-backdrop="static"
                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog  modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 text-center text-warning" id="staticBackdropLabel">Deseja
                                excluir permanentemente este usuário?</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-footer mx-auto">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>

                            <form action="{{ route('admin-destoy-request') }}" method="POST" class="form my-auto">
                                @csrf
                                <button type="submit" class="btn btn-danger" value="{{ $usuario->id }}"
                                    name="id">Deletar</button>
                            </form>
                        </div>
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
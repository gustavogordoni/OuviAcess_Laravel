@extends('layouts.html')
@section('title', '- Requests')

@section('body')
@include ('layouts.funcoes')
@include ('layouts.navbar')

{{-- Verifica se existe requerimentos. OBS: não entra aqui (entra no else) quem não estiver logado --}}
@isset($requerimentos)

{{-- Verifica se existem requerimentos cadastrados pelo user --}}
@if(count($requerimentos) > 0)

<form method="GET" action="{{ route('requests', ['order' => request('order')]) }}">
    <nav aria-label="..." class="mt-3">
        <ul class="pagination justify-content-center mb-0 ms-3 me-3">
            <li class="page-item disabled me-2">
                <a class="page-link">Filtrar por:</a>
            </li>

            <li class="page-item me-2">
                <select class="form-select" name="filterColumn" id="filterColumn">
                    <option value="" selected>-</option>
                    <option value="id" {{ request('filterColumn')=='id' ? 'selected' : '' }}>ID</option>
                    <option value="titulo" {{ request('filterColumn')=='titulo' ? 'selected' : '' }}>Título</option>
                    <option value="tipo" {{ request('filterColumn')=='tipo' ? 'selected' : '' }}>Tipo</option>
                    <option value="situacao" {{ request('filterColumn')=='situacao' ? 'selected' : '' }}>Situação
                    </option>
                    <option value="data" {{ request('filterColumn')=='data' ? 'selected' : '' }}>Data</option>
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
                        href="{{ route('requests', ['order' => 'id', 'filterColumn' => request('filterColumn'), 'filterValue' => request('filterValue')]) }}">ID</a>
                </th>
                <th scope="col" style="width:15%;">
                    <a class="link-info"
                        href="{{ route('requests', ['order' => 'title', 'filterColumn' => request('filterColumn'), 'filterValue' => request('filterValue')]) }}">Título</a>
                </th>
                <th scope="col" style="width:10%;"><strong>Tipo</strong></th>
                <th scope="col" style="width:10%;"><strong>Situação</strong></th>
                <th scope="col" style="width:10%;">
                    <a class="link-info"
                        href="{{ route('requests', ['order' => 'date', 'filterColumn' => request('filterColumn'), 'filterValue' => request('filterValue')]) }}">Data</a>
                </th>
                <th scope="col" style="width:1%;" colspan="3"></th>
            </tr>
        </thead>

        <tbody class="text-center">

            @foreach($requerimentos as $requerimento)
            <tr>
                <td>{{ $requerimento->id }}</td>
                <td>{{ $requerimento->titulo }}</td>
                <td>{{ $requerimento->tipo }}</td>

                @if ($requerimento->situacao == "Pendente")
                <td data-bs-toggle="popover" data-bs-title="Popover title" data-bs-content="Teste"><strong
                        class="text-secondary">{{ $requerimento->situacao }}</strong></td>
                @elseif ($requerimento->situacao == "Em andamento")
                <td><strong class="text-primary">{{ $requerimento->situacao }}</strong></td>
                @elseif ($requerimento->situacao == "Informações incompletas")
                <td><strong class="text-warning">{{ $requerimento->situacao }}</strong></td>
                @elseif ($requerimento->situacao == "Concluído")
                <td><strong class="text-success">{{ $requerimento->situacao }}</strong></td>
                @elseif ($requerimento->situacao == "Recusado")
                <td><strong class="text-danger">{{ $requerimento->situacao }}</strong></td>
                @endif

                <td>{{ \Carbon\Carbon::parse($requerimento->data)->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('admin-show-request', $requerimento->id) }}"
                        class="btn btn-outline-primary my-auto mx-1 rounded-circle p-2" name="visualizar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-eye-fill" viewBox="0 0 16 16">
                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                            <path
                                d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                        </svg>
                    </a>
                </td>
                <td>
                    <a href="{{ route('admin-respond-request', $requerimento->id) }}"
                        class="btn btn-outline-warning my-auto mx-1 rounded-circle p-2" name="editar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-pencil-fill" viewBox="0 0 16 16">
                            <path
                                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                        </svg>
                    </a>
                </td>
                <td>
                    <button type="button" class="btn btn-outline-danger my-auto mx-1 rounded-circle p-2"
                        data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{ $requerimento->id }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-trash3-fill" viewBox="0 0 16 16">
                            <path
                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z">
                            </path>
                        </svg>
                    </button>
                </td>
            </tr>

            <div class="modal fade" id="staticBackdrop-{{ $requerimento->id }}" data-bs-backdrop="static"
                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog  modal-dialog-centered">
                    <div class="modal-content"> 
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 text-center text-warning" id="staticBackdropLabel">Deseja
                                excluir permanentemente este requerimento?</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-footer mx-auto">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>

                            <form action="{{ route('admin-destoy-request') }}" method="POST" class="form my-auto">
                                @csrf
                                <button type="submit" class="btn btn-danger" value="{{ $requerimento->id }}"
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

{{-- Mantenha: Verifica se existe requerimentos cadastrados pelo user --}}
@else
<x-HistoryEmpty />
@endif

{{-- Mantenha: Exibe caso o usuário não estiver autenticado --}}
@else
<x-HistoryGuest />
@endisset

<x-alert />

@endsection
@extends('layouts.html')
@section('title', '- History')

@section('body')
@include ('layouts.funcoes')
@include ('layouts.navbar')

@php
/*
@if (!autenticado())
    $_SESSION["historico_anonimo"] = true;
    @if($mensagens = Session::get('message'))
    @include('layouts.message', ['mensagens' => $mensagens])           
@endif;
    @include ('layouts.js');
    die();
} else@if (autenticado())
    $id_usuario = $_SESSION["id_usuario"];

    //require '../database/conexao.php';

    @if (isset($_GET["ordem"]) && !empty($_GET["ordem"]))
        $order = filter_input(INPUT_GET, "ordem", FILTER_SANITIZE_SPECIAL_CHARS);

        @if ($order == "id")
            $order = "id_requerimento";
        } else@if ($order == "titulo")
            $order = "titulo";
        } else@if ($order == "data")
            $order = "substring(data, 7, 4) || '-' || substring(data, 4, 2) || '-' || substring(data, 1, 2)";
        } else {
            $order = "substring(data, 7, 4) || '-' || substring(data, 4, 2) || '-' || substring(data, 1, 2)";
        }
    } else {
        $order = "substring(data, 7, 4) || '-' || substring(data, 4, 2) || '-' || substring(data, 1, 2)";
    }

    //$sql = "SELECT * FROM requerimento WHERE id_usuario = ? ORDER BY $order";

    if($order == "substring(data, 7, 4) || '-' || substring(data, 4, 2) || '-' || substring(data, 1, 2)"){
        $order = "data";
    }

    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$id_usuario]);
    $cont = $stmt->rowCount();

    @if ($cont == 0)
        $_SESSION["historico_vazio"] = true;
        @if($mensagens = Session::get('message'))
    @include('layouts.message', ['mensagens' => $mensagens])           
@endif;
        include 'js.php';
        die();
    }
*/
@endphp

@isset($requerimentos)

    @if(count($requerimentos) > 0)

        @empty($layout)
            @php $layout = "table"; @endphp
        @endempty
    
        <nav aria-label="..." class="mt-3">
            <ul class="pagination justify-content-center mb-0 ms-3">
                <li class="page-item disabled">
                    <a class="page-link">Ordenação: </a>
                  </li>
              
                @if($layout == "table")
                    <li class="page-item active" aria-current="page">
                        <span class="page-link">Tabela</span>
                    </li>
                    <li class="page-item"><a class="page-link" href="{{ route('history', 'cards') }}">Cards</a></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ route('history', 'table') }}">Tabela</a></li>
                    <li class="page-item active" aria-current="page">
                        <span class="page-link">Cards</span>
                    </li>
                @endif
            </ul>
        </nav>

        @if($layout == "table")
            <div class="table-responsive mt-2">
                <table class="table table-striped table-md mb-0">
                    <thead>
                        <tr class="table text-center">              
                            @if (isset($order['title']))                                                
                                <th scope="col" style="width:5%;">
                                    <strong class="modal-title"><a class="link-info link-offset-1" href="{{ route('history', 'id') }}">ID</a></strong>
                                </th>
                                @if($order['title'] == "desc")
                                <th scope="col" style="width:15%;">       
                                    <strong class="modal-title text-info"><a class="link-info link-offset-1" href="{{ route('history', 'title') }}">Título</a>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="m-0 p-0 text-info" width="12" height="12" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16">
                                            <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
                                        </svg>
                                    </strong>
                                </th>
                                @else
                                    <th scope="col" style="width:15%;">
                                        <strong class="modal-title text-info"><a class="link-info link-offset-1" href="{{ route('history', 'title') }}">Título</a>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="m-0 p-0 text-info" width="12" height="12" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                                                <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                                            </svg>
                                        </strong>
                                    </th>
                                @endif
                                <th scope="col" style="width:10%;"><strong class="modal-title text-info">Tipo</strong></th>
                                <th scope="col" style="width:10%;"><strong class="modal-title text-info">Situação</strong></th>
                                <th scope="col" style="width:10%;">
                                    <strong class="modal-title"><a class="link-info link-offset-1" href="{{ route('history', 'date') }}">Data</a></strong>
                                </th>
                                <th scope="col" style="width:1%;" colspan="3"></th>
                            @endif
                            @if (isset($order['id']))                
                                @if($order['id'] == "desc")
                                    <th scope="col" style="width:5%;">     
                                        <strong class="modal-title text-info"><a class="link-info link-offset-1" href="{{ route('history', 'id') }}">ID</a>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="m-0 p-0 text-info" width="12" height="12" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16">
                                                <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
                                            </svg>
                                        </strong>
                                    </th>
                                @else
                                    <th scope="col" style="width:5%;">
                                        <strong class="modal-title text-info"><a class="link-info link-offset-1" href="{{ route('history', 'id') }}">ID</a>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="m-0 p-0 text-info" width="12" height="12" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                                                <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                                            </svg>
                                        </strong>
                                    </th>
                                @endif                            
                                <th scope="col" style="width:15%;">
                                    <strong class="modal-title"><a class="link-info link-offset-1" href="{{ route('history', 'title') }}">Título</a></strong>
                                </th>
                                <th scope="col" style="width:10%;"><strong class="modal-title text-info">Tipo</strong></th>
                                <th scope="col" style="width:10%;"><strong class="modal-title text-info">Situação</strong></th>
                                <th scope="col" style="width:10%;">
                                    <strong class="modal-title"><a class="link-info link-offset-1" href="{{ route('history', 'date') }}">Data</a></strong>
                                </th>
                                <th scope="col" style="width:1%;" colspan="3"></th>
                            @endif
                                @if (isset($order['date']))                        
                                <th scope="col" style="width:5%;">
                                    <strong class="modal-title"><a class="link-info link-offset-1" href="{{ route('history', 'id') }}">ID</a></strong>
                                </th>
                                <th scope="col" style="width:15%;">
                                    <strong class="modal-title"><a class="link-info link-offset-1" href="{{ route('history', 'title') }}">Título</a></strong>
                                </th>
                                <th scope="col" style="width:10%;"><strong class="modal-title text-info">Tipo</strong></th>
                                <th scope="col" style="width:10%;"><strong class="modal-title text-info">Situação</strong></th>
                                @if($order['date'] == "desc")
                                    <th scope="col" style="width:10%;">       
                                        <strong class="modal-title text-info"><a class="link-info link-offset-1" href="{{ route('history', 'date') }}">Data</a>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="m-0 p-0 text-info" width="12" height="12" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16">
                                                <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
                                            </svg>
                                        </strong>
                                    </th>
                                @else
                                    <th scope="col" style="width:10%;">
                                        <strong class="modal-title text-info"><a class="link-info link-offset-1" href="{{ route('history', 'date') }}">Data</a>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="m-0 p-0 text-info" width="12" height="12" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                                                <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                                            </svg>
                                        </strong>
                                    </th>
                                @endif
                                <th scope="col" style="width:1%;" colspan="3"></th>                        
                            @endif                    
                        </tr>
                    </thead>

                    <tbody class="text-center">

                        @foreach($requerimentos as $requerimento)
                            <tr>
                                <td>{{ $requerimento->id }}</td>
                                <td>{{ $requerimento->titulo }}</td>
                                <td>{{ $requerimento->tipo }}</td>
                                
                                @if ($requerimento->situacao == "Pendente")
                                <td data-bs-toggle="popover" data-bs-title="Popover title" data-bs-content="Teste"><strong class="text-secondary">{{ $requerimento->situacao }}</strong></td>
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
                                    <a href ="{{ route('show-request', $requerimento->id) }}" class="btn btn-outline-primary my-auto mx-1 rounded-circle p-2" name="visualizar">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                        </svg>
                                    </a>                                                    
                                </td>
                                <td>                                
                                    <a href="{{ route('edit-request', $requerimento->id) }}" class="btn btn-outline-warning my-auto mx-1 rounded-circle p-2" name="editar">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                            <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                        </svg>
                                    </a>                                
                                </td>
                                <td>
                                    <button type="button" class="btn btn-outline-danger my-auto mx-1 rounded-circle p-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{ $requerimento->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"></path>
                                        </svg>
                                    </button>
                                </td>
                            </tr>

                            <div class="modal fade" id="staticBackdrop-{{ $requerimento->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog  modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5 text-center text-warning" id="staticBackdropLabel">Deseja excluir permanentemente este requerimento?</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-footer mx-auto">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>

                                            <form action="{{ route('destoy-request') }}" method="POST" class="form my-auto">
                                                @csrf
                                                <button type="submit" class="btn btn-danger" value="{{ $requerimento->id }}" name="id">Deletar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        @endforeach
                    </tbody>
                </table>
            </div>

        @elseif($layout == "cards")

        <div class="container-fluid mt-3">
            <div class="row row-cols-1 row-cols-md-4 g-4">   
                
                @foreach($requerimentos as $requerimento)

                <div class="col">
                    <div class="card">
                        <img src="../image/vaga_acessibilidade.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <strong><h5 class="card-title">{{ $requerimento->titulo }}</h5></strong>
                        </div>                
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">{{ $requerimento->tipo }}</li>
                            <li class="list-group-item">                        
                                @if ($requerimento->situacao == "Pendente")
                                <strong class="text-secondary">{{ $requerimento->situacao }}</strong>
                                @elseif ($requerimento->situacao == "Em andamento")
                                <strong class="text-primary">{{ $requerimento->situacao }}</strong>
                                @elseif ($requerimento->situacao == "Informações incompletas")
                                <strong class="text-warning">{{ $requerimento->situacao }}</strong>
                                @elseif ($requerimento->situacao == "Concluído")
                                <strong class="text-success">{{ $requerimento->situacao }}</strong>
                                @elseif ($requerimento->situacao == "Recusado")
                                <strong class="text-danger">{{ $requerimento->situacao }}</strong>
                                @endif                        
                            </li>
                            <li class="list-group-item">{{ \Carbon\Carbon::parse($requerimento->data)->format('d/m/Y') }}</li>
                        </ul>    
                        <div class="card-footer text-center">
                            <a href ="{{ route('show-request', $requerimento->id) }}" class="btn btn-outline-primary my-auto mx-1 rounded-circle p-2" name="visualizar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                </svg>
                            </a>  
                            <a href="{{ route('edit-request', $requerimento->id) }}" class="btn btn-outline-warning my-auto mx-1 rounded-circle p-2" name="editar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                    <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                </svg>
                            </a>    
                            <button type="button" class="btn btn-outline-danger my-auto mx-1 rounded-circle p-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{ $requerimento->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"></path>
                                </svg>
                            </button> 
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="staticBackdrop-{{ $requerimento->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog  modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5 text-center text-warning" id="staticBackdropLabel">Deseja excluir permanentemente este requerimento?</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-footer mx-auto">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>

                                <form action="{{ route('destoy-request') }}" method="POST" class="form my-auto">
                                    @csrf
                                    <button type="submit" class="btn btn-danger" value="{{ $requerimento->id }}" name="id">Deletar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> 
                @endforeach

            </div>
        </div>    
        @endif

    @else
        @php 
            Session::put('message', ['history' => 'empty']); 
        @endphp
    @endif

@else
    @php
        Session::put('message', $message);
    @endphp
@endisset
        
@if($mensagens = Session::get('message'))
    @include('layouts.message', ['mensagens' => $mensagens])           
@endif

@endsection
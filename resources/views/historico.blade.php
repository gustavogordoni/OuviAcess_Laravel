@include ('layouts.header')
@include ('layouts.navbar')

@php
/*
if (!autenticado()) {
    $_SESSION["historico_anonimo"] = true;
    @include ('mensagens');
    @include ('layouts.js');
    die();
} elseif (autenticado()) {
    $id_usuario = $_SESSION["id_usuario"];

    //require '../database/conexao.php';

    if (isset($_GET["ordem"]) && !empty($_GET["ordem"])) {
        $ordem = filter_input(INPUT_GET, "ordem", FILTER_SANITIZE_SPECIAL_CHARS);

        if ($ordem == "id") {
            $ordem = "id_requerimento";
        } elseif ($ordem == "titulo") {
            $ordem = "titulo";
        } elseif ($ordem == "data") {
            $ordem = "substring(data, 7, 4) || '-' || substring(data, 4, 2) || '-' || substring(data, 1, 2)";
        } else {
            $ordem = "substring(data, 7, 4) || '-' || substring(data, 4, 2) || '-' || substring(data, 1, 2)";
        }
    } else {
        $ordem = "substring(data, 7, 4) || '-' || substring(data, 4, 2) || '-' || substring(data, 1, 2)";
    }

    $sql = "SELECT * FROM requerimento WHERE id_usuario = ? ORDER BY $ordem";

    if($ordem == "substring(data, 7, 4) || '-' || substring(data, 4, 2) || '-' || substring(data, 1, 2)"){
        $ordem = "data";
    }

    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$id_usuario]);
    $cont = $stmt->rowCount();

    if ($cont == 0) {
        $_SESSION["historico_vazio"] = true;
        @include ('mensagens');
        include 'js.php';
        die();
    }
    */
@endphp
    <div class="table-responsive mt-2">
        <table class="table table-striped table-md mb-0">
            <thead>
                <tr class="table text-center">
                    
                {{--
                    @php
                    if ($ordem == "titulo") {
                    @endphp
                        <th scope="col" style="width:5%;">
                            <strong class="modal-title"><a class="link-info link-offset-1" href="?ordem=id">ID</a></strong>
                        </th>
                        <th scope="col" style="width:15%;"><strong class="modal-title text-info">Título
                                <svg xmlns="http://www.w3.org/2000/svg" class="m-0 p-0 text-info" width="12" height="12" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                                    <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                                </svg>
                            </strong></th>
                        <th scope="col" style="width:10%;"><strong class="modal-title text-info">Tipo</strong></th>
                        <th scope="col" style="width:10%;"><strong class="modal-title text-info">Situação</strong></th>
                        <th scope="col" style="width:10%;">
                            <strong class="modal-title"><a class="link-info link-offset-1" href="?ordem=data">Data</a></strong>
                        </th>
                        <th scope="col" style="width:1%;" colspan="3"></th>
                    @php
                    }
                    if ($ordem == "id_requerimento") {
                    @endphp
                        <th scope="col" style="width:5%;"><strong class="modal-title text-info">ID
                                <svg xmlns="http://www.w3.org/2000/svg" class="m-0 p-0 text-info" width="12" height="12" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                                    <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                                </svg>
                            </strong></th>
                        <th scope="col" style="width:15%;">
                            <strong class="modal-title"><a class="link-info link-offset-1" href="?ordem=titulo">Título</a></strong>
                        </th>
                        <th scope="col" style="width:10%;"><strong class="modal-title text-info">Tipo</strong></th>
                        <th scope="col" style="width:10%;"><strong class="modal-title text-info">Situação</strong></th>
                        <th scope="col" style="width:10%;">
                            <strong class="modal-title"><a class="link-info link-offset-1" href="?ordem=data">Data</a></strong>
                        </th>
                        <th scope="col" style="width:1%;" colspan="3"></th>
                    @php
                    }
                    if ($ordem == "data") {
                    @endphp
                    --}}
                        <th scope="col" style="width:5%;">
                            <strong class="modal-title"><a class="link-info link-offset-1" href="?ordem=id">ID</a></strong>
                        </th>
                        <th scope="col" style="width:15%;">
                            <strong class="modal-title"><a class="link-info link-offset-1" href="?ordem=titulo">Título</a></strong>
                        </th>
                        <th scope="col" style="width:10%;"><strong class="modal-title text-info">Tipo</strong></th>
                        <th scope="col" style="width:10%;"><strong class="modal-title text-info">Situação</strong></th>
                        <th scope="col" style="width:10%;"><strong class="modal-title text-info">Data
                                <svg xmlns="http://www.w3.org/2000/svg" class="m-0 p-0 text-info" width="12" height="12" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                                    <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                                </svg>
                            </strong></th>
                        <th scope="col" style="width:1%;" colspan="3"></th>
                        {{--
                    @php
                    }
                    @endphp
                    --}}
                </tr>
            </thead>

            <tbody class="text-center">

                @php //while ($row =  $stmt->fetch()) { @endphp
                @foreach($requerimentos as $requerimento)
                    <tr>
                        <td>{{ $requerimento->id }}</td>
                        <td>{{ $requerimento->titulo }}</td>
                        <td>{{ $requerimento->tipo }}</td>
                        
                        @if ($requerimento->situacao == "Pendente")
                        <td><strong class="text-secondary">{{ $requerimento->situacao }}</strong></td>                        
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
                            <form action="show-request" method="GET" class="form my-auto">
                                <button class="btn btn-outline-primary my-auto mx-1 rounded-circle p-2" type="submit" value="{{ $requerimento->id }}" name="visualizar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                    </svg>
                                </button>
                            </form>                      
                        </td>
                        <td>
                            <form action="edit-request" method="GET" class="form my-auto">
                                <button class="btn btn-outline-warning my-auto mx-1 rounded-circle p-2" type="submit" value="{{ $requerimento->id }}" name="editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                        <td>
                            <button type="button" class="btn btn-outline-danger my-auto mx-1 rounded-circle p-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog  modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5 text-center text-warning" id="staticBackdropLabel">Deseja excluir permanentemente este requerimento?</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-footer mx-auto">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>

                                    <form action="delete-request" method="POST" class="form my-auto">
                                        <button type="submit" class="btn btn-danger" value="{{ $requerimento->id }}" name="deletar">Deletar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @php //} @endphp
                @endforeach
            </tbody>
        </table>
    </div>
{{--
@php
}
@endphp
--}}

@include ('mensagens')
@include ('layouts.js')
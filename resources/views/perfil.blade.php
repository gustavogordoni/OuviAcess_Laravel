@extends('layouts.html')
@section('title', '- Profile')

@section('body')
@include ('layouts.funcoes')

@php
/*
if (autenticado()) {
    $id_usuario = $_SESSION["id_usuario"];
} elseif (!autenticado()) {
    $_SESSION["realizar_login"] = "perfil";
    redireciona("login.php");
    die();
}

require '../database/conexao.php';

$sql = "SELECT nome, ddd, telefone, email, senha FROM usuario WHERE id_usuario = ?";

$stmt = $conn->prepare($sql);
$result = $stmt->execute([$id_usuario]);
$rowUsuario = $stmt->fetch();
$cont =  $stmt->rowCount();

$nome = explode(' ', $rowUsuario['nome']);
$firstName = $nome[0];
*/
@endphp
@include ('layouts.navbar')

<div class="container h-75">
    <main>
        <div class="py-3 text-center mt-4">
            <strong>
                <h2>Informações do seu perfil <strong> <br>{{ $usuario->name }}</strong></h2>
            </strong>
        </div>

        <div class="row">
            <div class="col-11 mx-auto mb-4">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="titulo" class="form-label"><strong>Nome completo: </strong></label>
                        <input readonly type="text" class="form-control" id="titulo" value="{{ $usuario->name }}" name="titulo">
                    </div>

                    <div class="col-md-3">
                        <label for="tipo" class="form-label"><strong>DDD:</strong></label>
                        <input readonly type="text" class="form-control" id="tipo" value="{{ $usuario->ddd }}" name="tipo">
                    </div>

                    <div class="col-md-9">
                        <label for="bairro" class="form-label"><strong>Telefone: </strong></label>
                        <input readonly type="text" class="form-control" id="telefone" name="telefone" value="{{ $usuario->phone }}">
                    </div>

                    <div class="col-12">
                        <label for="email" class="form-label"><strong>E-mail: </strong></label>
                        <div class="input-group has-validation">
                            <span class="input-group-text">@</span>
                            <input readonly type="email" class="form-control" id="email" name="email" value="{{ $usuario->email }}">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="mt-4 col-12 row">
                        <div class="col-lg-6 mb-3">
                            <a class="w-100 btn btn-secondary rounded-pill px-3 btn-lg" href="{{ route('index') }}">Voltar ao início</a>
                        </div>
                        <div class="col-lg-6">
                            <a href="edit-profile" class="w-100 btn btn-warning rounded-pill px-3 btn-lg" value="{{ $usuario->id }}">
                                Alterar informações do perfil
                            </a>
                        </div>                        
                        
                    </div>
                    <div class="mt-1 col-12 row">
                        <button type="button" class="w-100 btn btn-danger btn-lg rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            Deletar conta
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </main>
</div>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <form action="excluir-usuario.php" method="POST" class="form my-auto">

                <div class="modal-header">
                    <p class="modal-title fs-4 text-center" id="staticBackdropLabel">Confirme sua senha atual, antes de realizar a exclusão da conta</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12 mt-2">
                        <label for="senha_atual" class="form-label text-center" id="label_atual"><strong>Senha atual: </strong></label>
                        <input type="password" class="form-control" id="senha_atual" name="senha_atual" required maxlength="150">
                    </div>
                </div>
                <div class="modal-footer mx-auto w-100 d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>
                    <button type="submit" class="btn btn-danger" name="deletar">Excluir</button>
                </div>

            </form>
        </div>
    </div>
</div>

@if($mensagens = Session::get('message'))
        @include('layouts.message', ['mensagens' => $mensagens])           
    @endif
@include ('layouts.footer')

@endsection
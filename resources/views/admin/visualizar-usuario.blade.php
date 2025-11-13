@extends('layouts.html')
@section('title', '- Show user')

@section('body')
@include ('layouts.funcoes')
@include ('layouts.navbar')

<div class="container h-75">
    <main>
        <div class="py-3 text-center mt-4">
            <strong>
                <h2>Detalhes sobre o cliente</h2>
            </strong>
        </div>

        <div class="row">
            <div class="col-11 mx-auto mb-4">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="titulo" class="form-label"><strong>Nome completo: </strong></label>
                        <input readonly type="text" class="form-control" id="titulo" value="{{ $usuario->name }}"
                            name="name">
                    </div>

                    <div class="col-md-12">
                        <label for="bairro" class="form-label"><strong>Telefone: </strong></label>
                        <input readonly type="text" class="form-control" id="phone" value="{{ $usuario->phone }}"
                            name="phone">
                    </div>

                    <div class="col-12">
                        <label for="email" class="form-label"><strong>E-mail: </strong></label>
                        <div class="input-group has-validation">
                            <span class="input-group-text">@</span>
                            <input readonly type="email" class="form-control" id="email" value="{{ $usuario->email }}"
                                name="email">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="mt-5 col-12 row">
                        <div class="col-md-6 mb-3">
                            <a class="w-100 btn btn-warning rounded-pill px-3 btn-lg"
                                href=" {{ route('requests', ['filterColumn' => 'id_usuario', 'filterValue' => $usuario->id]) }}">Requerimentos
                                realizados</a>
                        </div>
                        <div class="col-md-6">
                            <button class="w-100 btn btn-danger btn-lg rounded-pill px-3" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">Banir conta</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </main>
</div>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin-destroy-user') }}" method="POST" class="form my-auto">
                @csrf
                <div class="modal-header">
                    <p class="modal-title fs-4 text-center" id="staticBackdropLabel">Confirme sua senha, antes de
                        realizar o banimento da conta do cliente</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <button type="submit" class="btn btn-danger" value="{{ $usuario->id }}" name="id">Banir</button>
                </div>

            </form>
        </div>
    </div>
</div>

<x-alert />

@include ('layouts.footer')

@endsection
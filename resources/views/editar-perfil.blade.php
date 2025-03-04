@extends('layouts.html')
@section('title', '- Edit profile')

@section('body')
@include ('layouts.funcoes')

@include ('layouts.navbar')

<div class="container mx-auto h-75">
    <main>
        <div class="py-3 text-center mt-4">
            <strong>
                <h2>Olá <strong>{{ $usuario->name }}</strong> <span class="fs-2">&#128075;</span></h2>
            </strong>
        </div>

        <div class="row">
            <div class="col-11 mx-auto mb-4">

                <form class="needs-validation" action="{{ route('update-profile')}}" method="POST">
                    @csrf
                    <div class="row g-3">

                        <div class="col-sm-12">
                            <label for="name" class="form-label" id="label_nome"><strong>Nome completo:
                                </strong></label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Ex: Carlos Alberto" required pattern="[A-Za-zÀ-ÿ\s]+"
                                title="Não informe caracteres que não sejam letras" onblur="nome();"
                                value="{{ $usuario->name }}" maxlength="150">
                            <div class="invalid-feedback">
                                Informe seu nome completo
                            </div>
                        </div>

                        {{-- <div class="col-sm-3">
                            <label for="ddd" class="form-label"><strong>DDD: </strong></label>
                            <input type="tel" class="form-control" id="ddd" name="ddd" required pattern="\([0-9]{2}\)$"
                                title="Digite o DDD no formato (DD)" placeholder="Ex: (17)" value="{{ $usuario->ddd }}"
                                maxlength="4">

                            <div class="invalid-feedback">
                                Informe um valor válido
                            </div>
                        </div> --}}

                        <div class="col-sm-12">
                            <label for="phone" class="form-label"><strong>Número de telefone: </strong></label>
                            <input type="tel" class="form-control" id="phone" name="phone" required
                                pattern="\(\d{2}\) \d{5}-\d{4}" title="Digite o telefone no formato (99) 99999-9999"
                                placeholder="Ex: (99) 99999-9999" maxlength="15" value="{{ $usuario->phone }}">
                            <div class="invalid-feedback">
                                Informe um valor válido
                            </div>
                        </div>


                        <div class="col-12">
                            <label for="email" class="form-label"><strong>E-mail: </strong></label>
                            <div class="input-group has-validation">
                                <span class="input-group-text">@</span>
                                <input readonly type="email" class="form-control" id="email" name="email"
                                    placeholder="voce@exemplo.com" required
                                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" value="{{ $usuario->email }}"
                                    maxlength="150">
                                <div class="invalid-feedback">
                                    Por favor, insira um endereço de e-mail válido para efetuar login
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 col-12 row">
                            <div class="col-md-6 mb-3">
                                <button type="button" class="w-100 btn btn-warning btn-lg rounded-pill px-3"
                                    data-bs-toggle="modal" data-bs-target="#staticBackdrop">Alterar senha</button>
                            </div>
                            <div class="col-md-6 mb-3">
                                <button class="w-100 btn btn-primary btn-lg rounded-pill px-3"
                                    type="submit">Enviar</button>
                            </div>
                            <div class="col-md-12 mb-3">
                                <a href="{{ route('profile') }}"
                                    class="w-100 btn btn-secondary btn-lg rounded-pill px-3">Cancelar alteração</a>
                            </div>
                        </div>

                </form>

                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog  modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('update-password') }}" method="POST" class="form my-auto">
                                @csrf
                                <div class="modal-header">
                                    <p class="modal-title fs-4 text-center" id="staticBackdropLabel">Confirme sua senha
                                        atual, antes de realizar a modificação</p>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="col-12 mt-2">
                                        <label for="password" class="form-label text-center"
                                            id="label_atual"><strong>Senha atual: </strong></label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            required maxlength="150">
                                    </div>
                                    <div class="col-12 mt-2">
                                        <label for="newpassword" class="form-label text-center"
                                            id="label_nova"><strong>Nova senha: </strong></label>
                                        <input type="password" class="form-control" id="newpassword" name="newpassword"
                                            required maxlength="150">
                                    </div>
                                    <div class="col-12 mt-2">
                                        <label for="confirmpassword" class="form-label text-center"
                                            id="label_confirmacao"><strong>Confirme a nova senha: </strong></label>
                                        <input type="password" class="form-control" id="confirmpassword"
                                            name="confirmpassword" required maxlength="150" onblur="verifica_senhas();">
                                        <div id="confsenhaFeedback" class="invalid-feedback">
                                            As senhas informadas não estão iguais.
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer mx-auto w-100 d-flex justify-content-center">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Voltar</button>
                                    <button type="submit" class="btn btn-success" name="deletar">Confirmar</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</div>

</main>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const telefoneInput = document.getElementById("phone");

        telefoneInput.addEventListener("input", function() {
            const inputValue = telefoneInput.value.replace(/\D/g, "");
            const maxLength = 11;
            const truncatedValue = inputValue.slice(0, maxLength);
            const formattedValue = formatTelefoneComDDD(truncatedValue);
            telefoneInput.value = formattedValue;
        });

        function formatTelefoneComDDD(value) {
            let formattedValue = value;

            if (value.length <= 2) {
                formattedValue = value.replace(/^(\d{0,2})/, "($1");
            } else if (value.length <= 7) {
                formattedValue = value.replace(/^(\d{2})(\d{0,5})/, "($1) $2");
            } else {
                formattedValue = value.replace(/^(\d{2})(\d{5})(\d{0,4})/, "($1) $2-$3");
            }

            return formattedValue;
        }
    });

    function verifica_senhas() {
        var senha = document.getElementById("newpassword");
        var confirme = document.getElementById("confirmpassword");
        var label_senha = document.getElementById("label_nova");
        var label_confirme = document.getElementById("label_confirmacao");

        if (senha.value && confirme.value) {
            if (senha.value != confirme.value) {
                senha.classList.add("is-invalid");
                confirme.classList.add("is-invalid");
                confirme.value = null;

                label_senha.classList.add("text-danger");
                label_confirme.classList.add("text-danger");

            } else {
                senha.classList.remove("is-invalid");
                confirme.classList.remove("is-invalid");
                label_senha.classList.remove("text-danger");
                label_confirme.classList.remove("text-danger");
            }
        }
    }

    const nomeInput = document.getElementById("name");
    const labelNome = document.querySelector("label[for='name']");

    nomeInput.addEventListener("keydown", function(event) {
        if (event.key >= '0' && event.key <= '9') {
            event.preventDefault();
        }
    });

    nomeInput.addEventListener("input", function() {
        const inputValue = nomeInput.value.replace(/\s+/g, "");
        const minLength = 4;
        const patternRegex = /^[A-Za-zÀ-ÿ\s]+$/;

        if (inputValue.length >= minLength && patternRegex.test(inputValue)) {
            nomeInput.setCustomValidity("");
            nomeInput.classList.remove("is-invalid");
            labelNome.classList.remove("text-danger");
        } else {
            nomeInput.classList.add("is-invalid");
            labelNome.classList.add("text-danger");

            if (inputValue.length < minLength) {
                nomeInput.setCustomValidity(`Informe um nome com pelo menos ${minLength} caracteres, sem contar os espaços.`);
            } else if (!patternRegex.test(inputValue)) {
                nomeInput.setCustomValidity("O nome deve conter apenas letras e espaços.");
            }
        }
    });
</script>

@if($mensagens = Session::get('message'))
@include('layouts.message', ['mensagens' => $mensagens])
@endif
@include ('layouts.footer')

@endsection
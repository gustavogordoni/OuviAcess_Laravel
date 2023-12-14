@extends('layouts.html')
@section('title', '- Register')

@section('body')
@include ('layouts.funcoes')
@include ('layouts.navbar')

@php
if (isset($_SESSION["error_cadastro"]) || isset($_SESSION["caracteres_cadastro"])) {
  $nome = $_SESSION["nome_cadastro"];
  $ddd = $_SESSION["ddd_cadastro"];
  $telefone = $_SESSION["telefone_cadastro"];
  $email = $_SESSION["email_cadastro"];

  unset($_SESSION["nome_cadastro"]);
  unset($_SESSION["ddd_cadastro"]);
  unset($_SESSION["telefone_cadastro"]);
  unset($_SESSION["email_cadastro"]);
}
@endphp

<div class="container mx-auto">
  <main>
    <div class="py-3 text-center mt-4">

      <strong>
        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-person-add cor_tema" viewBox="0 0 16 16">
          <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" />
          <path d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z" />
        </svg>
        <h2>Informe os dados para <br> efetuar seu cadastro no sistema</h2>
      </strong>

    </div>

    <div class="row">
      <div class="col-11 mx-auto">

        <form class="needs-validation" action="{{ route('store-user') }}" method="POST">
        @csrf
          <div class="row g-3">

            <div class="col-sm-12">
              <label for="nome" class="form-label" id="label_nome"><strong>Nome completo: </strong></label>
              <input type="text" class="form-control" id="nome" name="nome" placeholder="Ex: Carlos Alberto" required pattern="[A-Za-zÀ-ÿ\s]+" title="Não informe caracteres que não sejam letras" onblur="nome();" value="@php if (isset($nome)) {echo $nome;} @endphp" maxlength="150">
              <div class="invalid-feedback">
                Informe seu nome completo
              </div>
            </div>

            <div class="col-sm-3">
              <label for="ddd" class="form-label"><strong>DDD: </strong></label>
              <input type="tel" class="form-control" id="ddd" name="ddd" required pattern="\([0-9]{2}\)$" title="Digite o DDD no formato (DD)" placeholder="Ex: (17)" value="@php if (isset($ddd)) {echo $ddd;} @endphp" maxlength="4">

              <div class="invalid-feedback">
                Informe um valor válido
              </div>
            </div>

            <div class="col-sm-9">
              <label for="telefone" class="form-label"><strong>Número de telefone: </strong></label>
              <input type="tel" class="form-control" id="telefone" name="telefone" required pattern="[0-9]{4,6}-[0-9]{3,4}$" title="Digite o telefone no formato XXXXX-XXXX" placeholder="Ex: 99999-9999" maxlength="10" value="@php if (isset($telefone)) {echo $telefone;} @endphp" maxlength="10">
              <div class="invalid-feedback">
                Informe um valor válido
              </div>
            </div>

            <div class="col-12">
              <label for="email" class="form-label"><strong>E-mail: </strong><span class="text-body-secondary">(Para efetuar login)</span></label>
              <div class="input-group has-validation">
                <span class="input-group-text">@</span>
                <input type="email" class="form-control" id="email" name="email" placeholder="voce@exemplo.com" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" value="@php if (isset($email)) {echo $email;} @endphp" maxlength="150">
                <div class="invalid-feedback">
                  Por favor, insira um endereço de e-mail válido para efetuar login
                </div>
              </div>
            </div>

            <div class="col-12">
              <label for="senha" class="form-label" id="label_senha"><strong>Senha: </strong><span class="text-body-secondary">(Para efetuar login)</span></label>
              <input type="password" class="form-control" id="senha" name="senha" required maxlength="150">
            </div>

            <div class="col-12">
              <label for="confirme" class="form-label" id="label_confirme"><strong>Confirme a senha: </strong></label>
              <input type="password" class="form-control" id="confirme" name="confirme" required aria-describedby="confsenha confsenhaFeedback" onblur="verifica_senhas();" maxlength="150">
              <div id="confsenhaFeedback" class="invalid-feedback">
                As senhas informadas não estão iguais.
              </div>
            </div>

            <div class="mt-4 col-12 row">
              <div class="col-md-6 mb-3">
                <button class="w-100 btn btn-warning btn-lg rounded-pill px-3" type="reset">Limpar</button>
              </div>
              <div class="col-md-6">
                <button class="w-100 btn btn-primary btn-lg rounded-pill px-3" type="submit">Enviar</button>
              </div>
            </div>
        </form>
      </div>
    </div>
  </main>


  <script>
    const dddInput = document.getElementById("ddd");
    const telefoneInput = document.getElementById("telefone");

    dddInput.addEventListener("input", function() {
      const inputValue = dddInput.value.replace(/\D/g, ""); // Remove todos os caracteres não numéricos
      const maxLength = 2;
      const truncatedValue = inputValue.slice(0, maxLength);
      const formattedValue = formatDDD(truncatedValue);
      dddInput.value = formattedValue;
    });

    telefoneInput.addEventListener("input", function() {
      const inputValue = telefoneInput.value.replace(/\D/g, ""); // Remove todos os caracteres não numéricos
      const maxLength = 10;
      const truncatedValue = inputValue.slice(0, maxLength);
      const formattedValue = formatTelefone(truncatedValue);
      telefoneInput.value = formattedValue;
    });

    function formatDDD(value) {
      const regex = /^(\d{2})$/;
      const formattedValue = value.replace(regex, "($1)");
      return formattedValue;
    }

    function formatTelefone(value) {
      const regex = /^(\d{5})(\d{4})$/;
      const formattedValue = value.replace(regex, "$1-$2");
      return formattedValue;
    }

    function verifica_senhas() {
      var senha = document.getElementById("senha");
      var confirme = document.getElementById("confirme");
      var label_senha = document.getElementById("label_senha");
      var label_confirme = document.getElementById("label_confirme");

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

    const nomeInput = document.getElementById("nome");
    const labelNome = document.querySelector("label[for='nome']");

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
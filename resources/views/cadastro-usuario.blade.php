@extends('layouts.html')

@section('title', ' - Register')

@section('body')
@include ('layouts.funcoes')
@include ('layouts.navbar')

<div class="container mx-auto">
  <main>
    <div class="py-3 text-center mt-4">

      <strong>
        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor"
          class="bi bi-person-add cor_tema" viewBox="0 0 16 16">
          <path
            d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" />
          <path
            d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z" />
        </svg>
        <h2>Informe os dados para <br> efetuar seu cadastro no sistema</h2>
      </strong>

    </div>

    <div class="row">
      <div class="col-11 mx-auto">

        <!-- Formulário para cadastrar um usuário -->
        <form class="needs-validation" action="{{ route('store-user') }}" method="POST"
          onsubmit="return verifica_senhas()">
          @csrf
          <div class="row g-3">

            <!-- Input para o nome completo -->
            <div class="col-sm-12">
              <label for="name" class="form-label" id="label_nome"><strong>Nome completo: </strong></label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Ex: Carlos Alberto" required
                pattern="[A-Za-zÀ-ÿ\s]+" title="Não informe caracteres que não sejam letras" onblur="nome();"
                value="{{ old('name') }}" maxlength="150">
              <div class="invalid-feedback">
                Informe seu nome completo
              </div>
            </div>

            <!-- Input para o número de telefone -->
            <div class="col-sm-12">
              <label for="phone" class="form-label"><strong>Número de telefone: </strong></label>
              <input type="tel" class="form-control" id="phone" name="phone" required pattern="\(\d{2}\) \d{5}-\d{4}"
                title="Digite o telefone no formato (XX) XXXXX-XXXX" placeholder="Ex: (99) 99999-9999" maxlength="15"
                value="{{ old('phone') }}">
              <div class="invalid-feedback">
                Informe um valor válido
              </div>
            </div>

            <!-- Input para o e-mail -->
            <div class="col-12">
              <label for="email" class="form-label"><strong>E-mail: </strong><span class="text-body-secondary">(Para
                  efetuar login)</span></label>
              <div class="input-group has-validation">
                <span class="input-group-text">@</span>
                <input type="email" class="form-control" id="email" name="email" placeholder="voce@exemplo.com" required
                  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" value="{{ old('email') }}" maxlength="150">
                <div class="invalid-feedback">
                  Por favor, insira um endereço de e-mail válido para efetuar login
                </div>
              </div>
            </div>

            <!-- Input para a senha -->
            <div class="col-12">
              <label for="password" class="form-label" id="label_senha"><strong>Senha: </strong><span
                  class="text-body-secondary">(Para efetuar login)</span></label>
              <input type="password" class="form-control" id="password" name="password" required maxlength="150">
            </div>

            <!-- Input para confirmar a senha -->
            <div class="col-12">
              <label for="confirm" class="form-label" id="label_confirme"><strong>Confirme a senha: </strong></label>
              <input type="password" class="form-control" id="confirm" required
                aria-describedby="confsenha confsenhaFeedback" onblur="verifica_senhas();" maxlength="150">
              <div id="confsenhaFeedback" class="invalid-feedback">
                As senhas informadas não estão iguais.
              </div>
            </div>

            <!-- Botões de envio e limpeza -->
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

    function verifica_senhas() {
      var senha = document.getElementById("password");
      var confirme = document.getElementById("confirm");
      var label_senha = document.getElementById("label_senha");
      var label_confirme = document.getElementById("label_confirme");

      if (senha.value && confirme.value) {
        if (senha.value != confirme.value) {
          senha.classList.add("is-invalid");
          confirme.classList.add("is-invalid");
          confirme.value = null;

          label_senha.classList.add("text-danger");
          label_confirme.classList.add("text-danger");

          return false;
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

  <x-alert />

  @include ('layouts.footer')

  @endsection
@extends('layouts.html')
@section('title', '- Request')

@section('body')
@include ('layouts.funcoes')

@php 
if (isset($_SESSION["error_requerimento"]) || isset($_SESSION["caracteres_requerimento"])) {
  $titulo = $_SESSION["titulo_requerimento"];
  $tipo = $_SESSION["tipo_requerimento"];
  $cidade = $_SESSION["cidade_requerimento"];
  $cep = $_SESSION["cep_requerimento"];
  $bairro = $_SESSION["bairro_requerimento"];
  $logradouro = $_SESSION["logradouro_requerimento"];
  $descricao = $_SESSION["descricao_requerimento"];
  $anonimo = $_SESSION["anonimo_requerimento"];

  unset($_SESSION["titulo_requerimento"]);
  unset($_SESSION["tipo_requerimento"]);
  unset($_SESSION["cidade_requerimento"]);
  unset($_SESSION["cep_requerimento"]);
  unset($_SESSION["bairro_requerimento"]);
  unset($_SESSION["logradouro_requerimento"]);
  unset($_SESSION["descricao_requerimento"]);
  unset($_SESSION["anonimo_requerimento"]);
}
@endphp

@include ('layouts.navbar')

<div class="container mx-auto">
  <main>
    <div class="py-3 text-center mt-4">
      <strong class="cor_tema">
        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-megaphone me-5 mb-2" viewBox="0 0 16 16">
          <path d="M13 2.5a1.5 1.5 0 0 1 3 0v11a1.5 1.5 0 0 1-3 0v-.214c-2.162-1.241-4.49-1.843-6.912-2.083l.405 2.712A1 1 0 0 1 5.51 15.1h-.548a1 1 0 0 1-.916-.599l-1.85-3.49a68.14 68.14 0 0 0-.202-.003A2.014 2.014 0 0 1 0 9V7a2.02 2.02 0 0 1 1.992-2.013 74.663 74.663 0 0 0 2.483-.075c3.043-.154 6.148-.849 8.525-2.199V2.5zm1 0v11a.5.5 0 0 0 1 0v-11a.5.5 0 0 0-1 0zm-1 1.35c-2.344 1.205-5.209 1.842-8 2.033v4.233c.18.01.359.022.537.036 2.568.189 5.093.744 7.463 1.993V3.85zm-9 6.215v-4.13a95.09 95.09 0 0 1-1.992.052A1.02 1.02 0 0 0 1 7v2c0 .55.448 1.002 1.006 1.009A60.49 60.49 0 0 1 4 10.065zm-.657.975 1.609 3.037.01.024h.548l-.002-.014-.443-2.966a68.019 68.019 0 0 0-1.722-.082z" />
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-chat-dots ms-5 mb-2" viewBox="0 0 16 16">
          <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
          <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9.06 9.06 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.437 10.437 0 0 1-.524 2.318l-.003.011a10.722 10.722 0 0 1-.244.637c-.079.186.074.394.273.362a21.673 21.673 0 0 0 .693-.125zm.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6c0 3.193-3.004 6-7 6a8.06 8.06 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a10.97 10.97 0 0 0 .398-2z" />
        </svg>
        <h2>Informe os dados para <br> registrar seu requerimento no sistema</h2>
      </strong>

    </div>

    <div class="row">
      <div class="col-11 mx-auto">

        <form class="needs-validation" action="{{ route('store-request') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row g-3">

            <div class="col-md-8">
              <label for="titulo" class="form-label" id="label_titulo"><strong>Título do requerimento: </strong></label>
              <input type="text" class="form-control" required id="titulo" placeholder="Ex: Falta de rampas de acesso" name="titulo" value="@php if (isset($titulo)) { echo $titulo; } @endphp" pattern="[A-Za-zÀ-ÿ\s]+" title="Insira um título que contenha apenas letras. Nenhum outro tipo de caracter será válido" maxlength="150">
              <div class="invalid-feedback">
                Informe um título formado apenas por letras, tendo como mínimo de 10 caracteres.
              </div>
            </div>

            <div class="col-md-4">
              <label for="tipo" class="form-label"><strong>Tipo:</strong></label>
              <select class="form-select" required id="tipo" name="tipo" title="Selecione um tipo de requerimento">
                @php
                if (!isset($tipo) || empty($tipo)) { @endphp
                  <option value="">Escolha uma opção</option>
                  <option value="Denúncia">Denúncia</option>
                  <option value="Sugestão">Sugestão</option>
                @php
                } elseif (isset($tipo) && $tipo == "Denúncia") { @endphp
                  <option value="Denúncia">Denúncia</option>
                  <option value="Sugestão">Sugestão</option>
                @php
                } elseif (isset($tipo) && $tipo == "Sugestão") { @endphp
                  <option value="Sugestão">Sugestão</option>
                  <option value="Denúncia">Denúncia</option>
                @php
                }
                @endphp
              </select>
              <div class="invalid-feedback">
                Selecione um tipo de requerimento
              </div>
            </div>

            <div class="col-md-8">
              <label for="cidade" class="form-label"><strong>Cidade: </strong></label>
              <input type="text" class="form-control" required id="cidade" placeholder="Ex: Votuporanga" name="cidade" value="@php if (isset($cidade)) { echo $cidade; } @endphp" pattern="[A-Za-zÀ-ÿ\s]+" maxlength="150">
              <div class="invalid-feedback">
                Será aceito apenas letras, tendo como mínimo 3 caracteres.
              </div>
            </div>

            <div class="col-md-4">
              <label for="cep" class="form-label"><strong>CEP: </strong></label>
              <input type="text" class="form-control" required id="cep" name="cep" value="@php if (isset($cep)) { echo $cep; } @endphp" title="Digite o CEP no formato XX.XXX-XXX" placeholder="XX.XXX-XXX" pattern="\d{2}\.\d{3}-\d{3}" maxlength="10">
              <div class="invalid-feedback">
                Informe o CEP no formato XX.XXX-XXX
              </div>
            </div>

            <div class="col-md-6">
              <label for="bairro" class="form-label"><strong>Bairro: </strong></label>
              <input type="text" class="form-control" required id="bairro" placeholder="Ex: Centro" name="bairro" value="@php if (isset($bairro)) { echo $bairro; } @endphp" pattern="[A-Za-zÀ-ÿ0-9\s]+" maxlength="150">
              <div class="invalid-feedback">
                Informe um bairro válido
              </div>
            </div>

            <div class="col-md-6">
              <label for="logradouro" class="form-label"><strong>Logradouro: </strong></label>
              <input type="text" class="form-control" required id="logradouro" placeholder="Ex: Rua Amazonas" name="logradouro" value="@php if (isset($logradouro)) { echo $logradouro; } @endphp" pattern="[A-Za-zÀ-ÿ0-9\s]+" maxlength="150">
              <div class="invalid-feedback">
                Informe uma logradouro válida
              </div>
            </div>

            <div class="col-12 input-group mt-4">
              <label class="input-group-text px-5" for="arquivo"><strong>Foto do local:</strong></label>
              <input type="file" class="form-control" id="arquivo" accept="image/*" name="arquivo">
            </div>

            <div class="col-12">
              <label for="descricao" class="form-label"><strong>Descrição: </strong></label>
              <textarea class="form-control" required placeholder="Insira uma descrição detalhada sobre o ambiente em discussão" id="descricao" style="height: 130px" name="descricao" maxlength="2000">@php if (isset($descricao)){ echo $descricao; } @endphp</textarea>
              <div class="invalid-feedback">
                Insira uma descrição, com no mínimo 50 caracteres, sobre o ambiente em discussão
              </div>
            </div>

            <div class="col-12 form-check d-flex justify-content-center">
              @php if (!autenticado()) {
                $checked  = 'checked disabled';
              } elseif (autenticado()) {
                $checked = 'value = "true" ';
              } elseif (autenticado() && $anonimo == true) {
                $checked = 'value = "true" checked';
              } @endphp

              <input class="form-check-input" type="checkbox" id="anonimo" name="anonimo" @php echo $checked @endphp>
              <label class="form-check-label ms-1" for="anonimo">
                Enviar <strong>anonimamente</strong>
              </label>
            </div>

            <div class="mt-4 col-12 row">
              <div class="col-md-6 mb-3">
                <button class="w-100 btn btn-warning btn-lg rounded-pill px-3" type="reset">Limpar</button>
              </div>
              <div class="col-md-6">
                <button class="w-100 btn btn-primary btn-lg rounded-pill px-3" type="submit">Enviar</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </main>
</div>

  <script>
    const tituloInput = document.getElementById("titulo");
    const labelTitulo = document.querySelector("label[for='titulo']");

    tituloInput.addEventListener("keydown", function(event) {
      if (event.key >= '0' && event.key <= '9') {
        event.preventDefault();
      }
    });

    tituloInput.addEventListener("input", function() {
      const inputValue = tituloInput.value.replace(/\s+/g, "");
      const minLength = 10;
      const patternRegex = /^[A-Za-zÀ-ÿ\s]+$/;

      if (inputValue.length >= minLength && patternRegex.test(inputValue)) {
        tituloInput.setCustomValidity("");
        tituloInput.classList.remove("is-invalid");
        labelTitulo.classList.remove("text-danger");
      } else {
        tituloInput.classList.add("is-invalid");
        labelTitulo.classList.add("text-danger");

        if (inputValue.length < minLength) {
          tituloInput.setCustomValidity(`Informe um título com pelo menos ${minLength} caracteres, sem contar os espaços.`);
        } else if (!patternRegex.test(inputValue)) {
          tituloInput.setCustomValidity("O título deve conter apenas letras e espaços.");
        }
      }
    });

    const tipo = document.getElementById("tipo");
    const labelTipo = document.querySelector("label[for='tipo']");

    tipo.addEventListener("blur", function() {
      if (tipo.value !== "") {
        tipo.classList.remove("is-invalid");
        labelTipo.classList.remove("text-danger");
      } else {
        tipo.classList.add("is-invalid");
        labelTipo.classList.add("text-danger");
      }
    });

    const cidadeInput = document.getElementById("cidade");
    const labelCidade = document.querySelector("label[for='cidade']");

    cidadeInput.addEventListener("keydown", function(event) {
      if (event.key >= '0' && event.key <= '9') {
        event.preventDefault();
      }
    });

    cidadeInput.addEventListener("input", function() {
      const inputValue = cidadeInput.value.replace(/\s+/g, "");
      const minLength = 3;
      const patternRegex = /^[A-Za-zÀ-ÿ\s]+$/;

      if (inputValue.length >= minLength && patternRegex.test(inputValue)) {
        cidadeInput.setCustomValidity("");
        cidadeInput.classList.remove("is-invalid");
        labelCidade.classList.remove("text-danger");
      } else {
        cidadeInput.classList.add("is-invalid");
        labelCidade.classList.add("text-danger");

        if (inputValue.length < minLength) {
          cidadeInput.setCustomValidity(`Informe uma cidade com pelo menos ${minLength} letras.`);
        } else if (!patternRegex.test(inputValue)) {
          cidadeInput.setCustomValidity("Apenas serão aceitas letras.");
        }
      }
    });

    const cepInput = document.getElementById("cep");
    const labelCep = document.querySelector("label[for='cep']");

    cepInput.addEventListener("input", function() {
      const inputValue = cepInput.value.replace(/\D/g, ""); // Remove todos os caracteres não numéricos
      const maxLength = 8;
      const truncatedValue = inputValue.slice(0, maxLength);
      const formattedValue = formatCEP(truncatedValue);
      cepInput.value = formattedValue;

      validateCep(inputValue);
    });

    cepInput.addEventListener("blur", function() {
      const inputValue = cepInput.value.replace(/\D/g, ""); // Remove todos os caracteres não numéricos
      validateCep(inputValue);
    });

    function validateCep(value) {
      const cepRegex = /^\d{8}$/;
      const isValid = cepRegex.test(value);

      if (isValid) {
        cepInput.classList.remove("is-invalid");
        labelCep.classList.remove("text-danger");
      } else {
        cepInput.classList.add("is-invalid");
        labelCep.classList.add("text-danger");
      }
    }

    function formatCEP(value) {
      const regex = /^(\d{2})(\d{3})(\d{3})$/;
      const formattedValue = value.replace(regex, "$1.$2-$3");
      return formattedValue;
    }

    const bairroInput = document.getElementById("bairro");
    const labelBairro = document.querySelector("label[for='bairro']");

    bairroInput.addEventListener("input", function() {
      const inputValue = bairroInput.value.replace(/\s+/g, "");
      const minLength = 3;
      const patternRegex = /^[A-Za-zÀ-ÿ0-9\s]+$/;

      if (inputValue.length >= minLength && patternRegex.test(inputValue)) {
        bairroInput.setCustomValidity("");
        bairroInput.classList.remove("is-invalid");
        labelBairro.classList.remove("text-danger");
      } else {
        bairroInput.classList.add("is-invalid");
        labelBairro.classList.add("text-danger");

        if (inputValue.length < minLength) {
          bairroInput.setCustomValidity(`Informe um bairro com pelo menos ${minLength} caracteres.`);
        } else if (!patternRegex.test(inputValue)) {
          bairroInput.setCustomValidity("Apenas serão aceitas letras e números.");
        }
      }
    });

    const logradouroInput = document.getElementById("logradouro");
    const labelLogradouro = document.querySelector("label[for='logradouro']");

    logradouroInput.addEventListener("input", function() {
      const inputValue = logradouroInput.value.replace(/\s+/g, "");
      const minLength = 2;
      const patternRegex = /^[A-Za-zÀ-ÿ0-9\s]+$/;

      if (inputValue.length >= minLength && patternRegex.test(inputValue)) {
        logradouroInput.setCustomValidity("");
        logradouroInput.classList.remove("is-invalid");
        labelLogradouro.classList.remove("text-danger");
      } else {
        logradouroInput.classList.add("is-invalid");
        labelLogradouro.classList.add("text-danger");

        if (inputValue.length < minLength) {
          logradouroInput.setCustomValidity(`Informe uma logradouro com pelo menos ${minLength} caracteres.`);
        } else if (!patternRegex.test(inputValue)) {
          logradouroInput.setCustomValidity("Apenas serão aceitas letras e números.");
        }
      }
    });

    const descricaoInput = document.getElementById("descricao");
    const labelDescricao = document.querySelector("label[for='descricao']");
    const descricaoErrorMessage = descricaoInput.nextElementSibling;

    const minDescricaoLength = 50;

    descricaoInput.addEventListener("input", function() {
      const inputValue = descricaoInput.value.trim();
      if (inputValue.length < minDescricaoLength) {
        descricaoInput.classList.add("is-invalid");
        labelDescricao.classList.add("text-danger"); // Adicione a classe text-danger
        descricaoErrorMessage.style.display = "block";
      } else {
        descricaoInput.classList.remove("is-invalid");
        labelDescricao.classList.remove("text-danger"); // Remova a classe text-danger
        descricaoErrorMessage.style.display = "none";
      }
    });
  </script>

@if($mensagens = Session::get('message'))
        @include('layouts.message', ['mensagens' => $mensagens])           
    @endif
@include ('layouts.footer')

@endsection
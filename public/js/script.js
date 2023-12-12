/*
function validacaoRequerimentos() {

  const tituloInput = document.getElementById("titulo");
  const labelTitulo = document.querySelector("label[for='titulo']");

  tituloInput.addEventListener("keydown", function (event) {
    if (event.key >= '0' && event.key <= '9') {
      event.preventDefault();
    }
  });

  tituloInput.addEventListener("input", function () {
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

  tipo.addEventListener("blur", function () {
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

  cidadeInput.addEventListener("keydown", function (event) {
    if (event.key >= '0' && event.key <= '9') {
      event.preventDefault();
    }
  });

  cidadeInput.addEventListener("input", function () {
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

  cepInput.addEventListener("input", function () {
    const inputValue = cepInput.value.replace(/\D/g, ""); // Remove todos os caracteres não numéricos
    const maxLength = 8;
    const truncatedValue = inputValue.slice(0, maxLength);
    const formattedValue = formatCEP(truncatedValue);
    cepInput.value = formattedValue;

    validateCep(inputValue);
  });

  cepInput.addEventListener("blur", function () {
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

  bairroInput.addEventListener("input", function () {
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

  logradouroInput.addEventListener("input", function () {
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

  descricaoInput.addEventListener("input", function () {
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

}
/////////////////////////////////////////////////////////////////////////////////////////////
function validacaoUsuarios() {

  const dddInput = document.getElementById("ddd");
  const telefoneInput = document.getElementById("telefone");

  dddInput.addEventListener("input", function () {
    const inputValue = dddInput.value.replace(/\D/g, ""); // Remove todos os caracteres não numéricos
    const maxLength = 2;
    const truncatedValue = inputValue.slice(0, maxLength);
    const formattedValue = formatDDD(truncatedValue);
    dddInput.value = formattedValue;
  });

  telefoneInput.addEventListener("input", function () {
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

  const nomeInput = document.getElementById("nome");
  const labelNome = document.querySelector("label[for='nome']");

  nomeInput.addEventListener("keydown", function (event) {
    if (event.key >= '0' && event.key <= '9') {
      event.preventDefault();
    }
  });

  nomeInput.addEventListener("input", function () {
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

}
*/
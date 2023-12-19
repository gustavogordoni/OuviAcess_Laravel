document.addEventListener("DOMContentLoaded", function() {
  function adicionarCampo() {
    // Crie um novo elemento div
    var novoCampo = document.createElement('div');
    novoCampo.className = 'col-12 input-group mt-4';

    // Conteúdo do novo campo HTML
    novoCampo.innerHTML = `
      <label class="input-group-text px-5" for="image"><strong>Foto do local:</strong></label>
      <input type="file" class="form-control" id="image" accept="image/*" name="image">
    `;

    // Adicione o novo campo ao container
    document.getElementById('container').appendChild(novoCampo);
  }

  // Verificar se a página atual é a página de requerimentos
  if (window.location.pathname === '/requerimentos') {
      // Se sim, execute o código do seu script aqui

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

  }

});


@extends('layouts.html')
@section('title', '- Respond request')

@section('body')
@include ('layouts.funcoes')

@include ('layouts.navbar')

<div class="container mx-auto">
    <main>
        <div class="py-3 text-center mt-4">
            <strong>
                <h2>Altere situação e submeta uma resposta condizente</h2>
            </strong>
        </div>

        <div class="row">
            <div class="col-11 mx-auto mb-4">
                <form class="needs-validation" action="{{ route('admin-update-request') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf                    
                    <input type="hidden" name="id" value="{{ $requerimento->id }}">

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label for="titulo" class="form-label"><strong>Título do requerimento:</strong></label>
                            <input readonly type="text" class="form-control" id="titulo" name="titulo"
                                value="{{ $requerimento->titulo }}">
                        </div>

                        <div class="col-md-4">
                            <label for="situacao" class="form-label"><strong>Situação:</strong></label>
                            <select class="form-select" id="situacao" name="situacao" required>
                                <option value="">Escolha uma situação</option>
                                @foreach(['Concluído', 'Recusado', 'Informações incompletas'] as $situacao)
                                    <option value="{{ $situacao }}" {{ $requerimento->situacao === $situacao ? 'selected' : '' }}>
                                        {{ $situacao }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Selecione uma situação válida.
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="resposta" class="form-label"><strong>Resposta:</strong></label>
                            <textarea class="form-control" id="resposta" name="resposta" required
                                placeholder="Justifique a alteração da situação"
                                style="height: 130px">{{ $requerimento->resposta ?? '' }}</textarea>
                            <div class="invalid-feedback">
                                Por favor, insira uma resposta justificando a alteração da situação.
                            </div>
                        </div>

                        <div class="mt-5 col-12 row">
                            <div class="col-md-6 mb-3">
                                <a class="w-100 btn btn-secondary rounded-pill px-3 btn-lg"
                                    href="{{ route('requests') }}">Voltar à lista de requerimentos</a>
                            </div>
                            <div class="col-md-6">
                                <button class="w-100 btn btn-primary btn-lg rounded-pill px-3"
                                    type="submit">Enviar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    const situacaoInput = document.getElementById("situacao");
    const labelSituacao = document.querySelector("label[for='situacao']");
    const respostaInput = document.getElementById("resposta");
    const labelResposta = document.querySelector("label[for='resposta']");
    
    situacaoInput.addEventListener("blur", function() {
        if (situacaoInput.value !== "") {
            situacaoInput.classList.remove("is-invalid");
            labelSituacao.classList.remove("text-danger");
        } else {
            situacaoInput.classList.add("is-invalid");
            labelSituacao.classList.add("text-danger");
        }
    });
    
    respostaInput.addEventListener("input", function() {
        const inputValue = respostaInput.value.trim();
        const minLength = 10;

        if (inputValue.length >= minLength) {
            respostaInput.setCustomValidity("");
            respostaInput.classList.remove("is-invalid");
            labelResposta.classList.remove("text-danger");
        } else {
            respostaInput.classList.add("is-invalid");
            labelResposta.classList.add("text-danger");

            respostaInput.setCustomValidity(`A resposta deve ter pelo menos ${minLength} caracteres.`);
        }
    });
    
    const form = document.querySelector("form");
    form.addEventListener("submit", function(event) {
        if (situacaoInput.value === "") {
            situacaoInput.classList.add("is-invalid");
            labelSituacao.classList.add("text-danger");
            event.preventDefault(); 
        }

        if (respostaInput.value.trim().length < 10) {
            respostaInput.classList.add("is-invalid");
            labelResposta.classList.add("text-danger");
            event.preventDefault(); 
        }
    });
});

</script>

<x-alert />
@include ('layouts.footer')

@endsection
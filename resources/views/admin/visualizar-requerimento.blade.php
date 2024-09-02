@extends('layouts.html')
@section('title', '- Show request')

@section('body')
@include ('layouts.funcoes')

@include ('layouts.navbar')

<div class="container">
    <main>
        <div class="py-3 text-center mt-4">
            <strong>
                <h2>Detalhes do Requerimento {{ $requerimento->id }}</h2>
            </strong>
        </div>

        <div class="row">
            <div class="col-11 mx-auto mb-4">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label for="titulo" class="form-label"><strong>Título do requerimento: </strong></label>
                        <input readonly type="text" class="form-control" id="titulo" value="{{ $requerimento->titulo }}"
                            name="titulo">
                    </div>

                    <div class="col-md-4">
                        <label for="tipo" class="form-label"><strong>Tipo:</strong></label>
                        <input readonly type="text" class="form-control" id="tipo" value="{{ $requerimento->tipo }}"
                            name="tipo">
                    </div>

                    <div class="col-md-8">
                        <label for="bairro" class="form-label"><strong>Situação: </strong></label>
                        <input readonly type="text" class="form-control" id="bairro" name="bairro"
                            value="{{ $requerimento->situacao }}">
                    </div>

                    <div class="col-md-4">
                        <label for="logradouro" class="form-label"><strong>Data: </strong></label>
                        <input readonly type="text" class="form-control" id="logradouro" name="logradouro"
                            value="{{ \Carbon\Carbon::parse($requerimento->data)->format('d/m/Y') }}">
                    </div>

                    <div class="col-md-8">
                        <label for="cidade" class="form-label"><strong>Cidade: </strong></label>
                        <input readonly type="text" class="form-control" id="cidade" name="cidade"
                            value="{{ $requerimento->cidade }}">
                    </div>

                    <div class="col-md-4">
                        <label for="cep" class="form-label"><strong>CEP: </strong></label>
                        <input readonly type="text" class="form-control" id="cep" name="cep"
                            value="{{ $requerimento->cep }}">
                    </div>

                    <div class="col-md-6">
                        <label for="bairro" class="form-label"><strong>Bairro: </strong></label>
                        <input readonly type="text" class="form-control" id="bairro" name="bairro"
                            value="{{ $requerimento->bairro }}">
                    </div>

                    <div class="col-md-6">
                        <label for="logradouro" class="form-label"><strong>Logradouro: </strong></label>
                        <input readonly type="text" class="form-control" id="logradouro" name="logradouro"
                            value="{{ $requerimento->logradouro }}">
                    </div>

                    <div class="col-12">
                        <label for="descricao" class="form-label"><strong>Descrição: </strong></label>
                        <textarea readonly class="form-control" id="descricao" style="height: 150px"
                            name="descricao">{{ $requerimento->descricao }}</textarea>
                    </div>

                    @isset($arquivos)
                        @if($arquivos->isNotEmpty())
                            <div class="col-md-12 mt-4">
                                <button type="button" class="d-block mx-auto w-25 btn btn-primary rounded-pill px-3 btn-lg"
                                    data-bs-toggle="modal" data-bs-target="#exampleModalFullscreen">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                        class="bi bi-image-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M.002 3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-12a2 2 0 0 1-2-2V3zm1 9v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V9.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12zm5-6.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0z" />
                                    </svg>
                                    <br>
                                    Imagens anexadas
                                </button>
                            </div>

                            <div class="modal fade m-0 ps-0" id="exampleModalFullscreen" tabindex="-1"
                                aria-labelledby="exampleModalFullscreenLabel" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog modal-fullscreen">
                                    <div class="modal-content">
                                        {{--
                                        <div class="modal-header py-1">
                                            <h3 class="d-block mx-auto cor_tema">Imagens</h3>
                                            <button type="button" class="btn-close ms-0" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        --}}
                                        <div class="modal-header py-1">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body d-flex justify-content-center align-items-center py-0">
                                            <div id="carouselExampleControls"
                                                class="carousel slide d-flex justify-content-center" data-bs-ride="carousel">
                                                <div class="carousel-indicators">
                                                    @foreach($arquivos as $index => $arquivo)
                                                    <button type="button" data-bs-target="#carouselExampleControls"
                                                        data-bs-slide-to="{{ $index }}" @if($index===0) class="active" @endif
                                                        aria-label="Slide {{ $index + 1 }}"></button>
                                                    @endforeach
                                                </div>
                                                <div class="carousel-inner d-block h-100" style="width: 80%;">
                                                    @foreach($arquivos as $index => $arquivo)
                                                    <div class="carousel-item @if($index === 0) active @endif">
                                                        <img src="/image/imageRequest/{{ $arquivo->name }}"
                                                            alt="Imagem {{ $index + 1 }}" class="d-block w-100 h-100">
                                                    </div>
                                                    @endforeach
                                                </div>
                                                <button class="carousel-control-prev" type="button"
                                                    data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button"
                                                    data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endisset

                    <div class="col-12 border p-3 rounded-5 mt-5">
                        <h3 class="">Cliente responsável:
                            <a class="cor_tema link-underline link-underline-opacity-0"
                                href="{{ route('show-user', $requerimento->id_usuario) }}">
                                {{ $usuario->name }}
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor"
                                    class="bi bi-info-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z">
                                    </path>
                                    <path
                                        d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z">
                                    </path>
                                </svg>
                            </a>
                        </h3>                       
                    </div>

                    {{-- @if(isset($requerimento->resposta ) && !empty($requerimento->resposta))
                    <div class="col-12 border p-4 rounded-5 mt-5">
                        @isset($requerimento->id_usuario)
                        <h3 class="mb-3">Administrador:
                            <a class="cor_tema link-underline link-underline-opacity-0"
                                href="visualizar-administrador.php?id={{ $requerimento->id_usuario }}">
                                {{ $requerimento->resposta }}
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor"
                                    class="bi bi-info-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z">
                                    </path>
                                    <path
                                        d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z">
                                    </path>
                                </svg>
                            </a>
                        </h3>
                        @endif

                        <label for="situacao_label" class="form-label"><strong>Situação definida como: </strong>
                            @switch($requerimento->situacao)
                                @case('Pendente')
                                    <strong class="text-secondary">{{ strtoupper($requerimento->situacao) }}</strong>
                                    @break
                                @case('Em andamento')
                                    <strong class="text-primary">{{ strtoupper($requerimento->situacao) }}</strong>
                                    @break
                                @case('Informações incompletas')
                                    <strong class="text-warning">{{ strtoupper($requerimento->situacao) }}</strong>
                                    @break
                                @case('Concluído')
                                    <strong class="text-success">{{ strtoupper($requerimento->situacao) }}</strong>
                                    @break
                                @case('Recusado')
                                    <strong class="text-danger">{{ strtoupper($requerimento->situacao) }}</strong>
                                    @break
                            @endswitch
                        </label>
                        <br>
                        <label for="resposta" class="form-label"><strong>Resposta: </strong></label>
                        <textarea readonly class="form-control" id="resposta" style="height: 150px"
                            name="resposta">{{ $rowRequeriemento['resposta'] }}</textarea>
                    </div>
                    @endif --}}

                    <div class="mt-4 col-12 row">
                        <div class="col-md-6 mb-3">
                            <a class="w-100 btn btn-secondary rounded-pill px-3 btn-lg"
                                href="{{ route('requests') }}">Voltar à lista de requerimentos</a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('admin-respond-request', $requerimento->id) }}"
                                class="w-100 btn btn-warning rounded-pill px-3 btn-lg" value="{{ $requerimento->id }}"
                                name="editar">
                                Responder requerimento
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<x-alert />
@include ('layouts.footer')

@endsection
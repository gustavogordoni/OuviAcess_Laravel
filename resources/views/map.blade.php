@extends('layouts.html')
@section('title', '- Map')

@section('body')
@include ('layouts.funcoes')
@include ('layouts.navbar')

    <script type="text/javascript">
        var centreGot = false;
    </script>

    {!! $map['js'] !!}

    @if($conexaoDatabase)
        <h1 class="text-center text-info">Conectado ao DataBase</h1>
    @else
        <h1 class="text-center text-danger">Não conectado ao DataBase</h1>
    @endif
    {!! $map['html'] !!}
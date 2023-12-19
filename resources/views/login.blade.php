@extends('layouts.html')
@section('title', '- Login')

@section('body')
@include ('layouts.funcoes')

@php
if (isset($_SESSION["error_senha"])) {
  $email = $_SESSION["error_senha"];
  unset($_SESSION["error_senha"]);
}
@endphp
<div class="row p-5 py-2 my-auto h-100">

  <form action="{{ route('auth')}}" method="POST" class="border border border-opacity-50 border-info-subtle border-3 rounded-4 bg-body-tertiary bg-opacity-75 my-auto row d-flex justify-content-center align-items-center col-lg-6 py-5">
    @csrf
    <div class="form-floating mb-2 col-md-12">
      <a href="{{ route('index') }}">
        <img src="../image/OuviAcess.png" alt="" width="200vw" class="mb-4 d-block mx-auto">
      </a>
    </div>

    <div class="form-floating mb-2 col-md-7">
      <input type="email" class="form-control" required id="email" placeholder="name@example.com name=" name="email" value="@php if(isset($email)){ echo $email; }@endphp">
      <label for="email" class="ms-2">Endereço de email</label>
    </div>
    <div class="form-floating col-md-7">
      <input type="password" class="form-control" required id="floatingPassword" placeholder="Password" name="password">
      <label for="floatingPassword" class="ms-2">Senha</label>
    </div>
    <div class="form-check my-2 col-md-7 d-flex justify-content-center">
      <input class="form-check-input" type="checkbox" id="flexCheckDefault" name="remember">
      <label class="form-check-label ms-2" for="flexCheckDefault">
        Remember me
      </label>
    </div>

    <div class="form-floating col-md-7 mt-3">
      <button class="btn btn-primary py-2 w-100 rounded-pill" type="submit">Acessar</button>
      <p class="mt-5 mb-3 text-body-secondary text-center">Não está registrado? <a href="{{ route('register') }}" class="link-primary">Cadastre-se</a></p>
    </div>

  </form>

  <div class="mx-auto d-flex justify-content-center p-1 col-lg-6 my-auto">
    <img src="../image/login.png" alt="" width="500vw" height="500vw">
  </div>
</div>

@if($errors->any())
  @php Session::put('message', ['error_authentication' => $errors->all()[0]]); @endphp
@endif

@if($mensagens = Session::get('message'))
  @include('layouts.message', ['mensagens' => $mensagens])           
@endif

@endsection
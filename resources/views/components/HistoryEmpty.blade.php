{{-- Fundo caso o usuário não tenha criado algum requerimento --}}
<div class="row d-flex align-items-center ps-4 h-75 w-100 mx-auto">
    <div class="col-md-6 text-center">
        <h2 class="mt-2">Você ainda não realizou nenhum</h2>
        <a href=" {{ route('request') }}" class="btn btn-outline-info p-2 px-4 rounded-pill fs-5 mt-2 fs-2">Requerimento</a>
    </div>
    <div class=" mx-auto col-md-6 text-center">
        <img src="../image/historico_vazio.png" alt="" width="80%">
    </div>
</div>
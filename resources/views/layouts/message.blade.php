@php
function success($title){
    $return = '<div class="alert alert-success alert-dismissible fade show position-fixed bottom-0 end-0 py-auto" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill me-1" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
        </svg>' .
        $title .
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    return $return;
}
/*
function info($title){
    $return = '<div class="alert alert-success alert-dismissible fade show position-fixed bottom-0 end-0 py-auto" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill me-1" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
        </svg>' .
        $title .
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    return $return;
}
*/
@endphp

{{-- SUCESSO: Requerimento--}}
@if(isset($mensagens['success_request']))
    @php
        $successRequest = $mensagens['success_request'];
        // ADD REQUERIMENTO
        if ($successRequest == "store") {
            $title = "Requerimento realizado com <strong>SUCESSO</strong>";
        }
        // EXCLUIR REQUERIMENTO
        elseif ($successRequest == "destroy") {
            $title = "Requerimento excluído com <strong>SUCESSO</strong>";
        }
        // ALTERAR REQUERIMENTO
        elseif ($successRequest == "update") {
            $title = "Dados do requerimento alterados com <strong>SUCESSO</strong>";
        }        
        echo success($title);

    @endphp
    session()->forget('message');

{{-- SUCESSO: Usuario --}}
@elseif(isset($mensagens['success_user']))
    @php
        $successUser = $mensagens['success_user'];
        // ADD USUÁRIO
        if ($successUser == "store") {
            $title = "Cadastro realizado com <strong>SUCESSO</strong>";
        }
        // EXCLUIR USUÁRIO
        elseif ($successUser == "destroy") {
            $title = "Perfil excluído com <strong>SUCESSO</strong>";
        }
        // ALTERAR USUÁRIO
        elseif ($successUser == "update") {
            $title = "Perfil atualizado com <strong>SUCESSO</strong>";
        }        
        echo success($title);

    @endphp
    session()->forget('message');
@endif
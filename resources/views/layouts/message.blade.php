@php
function success($title){
    $return = 
    '<div class="alert alert-success alert-dismissible fade show position-fixed bottom-0 end-0 py-auto" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill me-1" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" /></svg>' .
        $title .
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    return $return;
}

function welcome($title){
    $return = 
    '<div class="alert alert-primary alert-dismissible fade show position-fixed bottom-0 end-0 py-auto" role="alert">' .
        $title .
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    return $return;
}

function error($title){
    $return = 
    '<div class="alert alert-danger alert-dismissible fade show position-fixed bottom-0 end-0 py-auto" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" /></svg>' .
        $title . 
        '<button type="button" class="btn-close my-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    return $return;
}

function historyEmpty(){
    $return = 
    '<div class="row d-flex align-items-center ps-4 h-75 w-100 mx-auto">
        <div class="col-md-6 text-center">
            <h2 class="mt-2">Você ainda não realizou nenhum</h2>
            <a href="' . route('request') . '" class="btn btn-outline-info p-2 px-4 rounded-pill fs-5 mt-2 fs-2">Requerimento</a>
        </div>
        <div class=" mx-auto col-md-6 text-center">
            <img src="../image/historico_vazio.png" alt="" width="80%">
        </div>
    </div>';
    return $return;
}

function historyGuest(){
    $return = 
    '<div class="row d-flex align-items-center ps-4 h-75 w-100">
        <div class="col-md-6 text-center">
            <h2 class="mt-2">Efetue sua autenticação para ter acesso ao seu histórico de requerimentos</h2>
            <h2><a href="' . route('authentication') . '" class="btn btn-outline-info p-2 px-4 rounded-pill fs-5 mt-2">Faça Login</a></h2>
        </div>
        <div class=" mx-auto col-md-6 text-center">
            <img src="../image/identifique-se.png" alt="" width="80%">
        </div>
    </div>';
    return $return;
}
@endphp

{{------------------------------------------------------------------------------------------------------}}

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

{{-- SUCESSO: Autenticação --}}
@elseif(isset($mensagens['success_authentication']))
    @php
        $title = "Seja bem-vindo(a) ". $mensagens['success_authentication'] . "&#128075;";    
        echo welcome($title);
    @endphp

{{-- SUCESSO: Logout --}}
@elseif(isset($mensagens['logout']))
    @php
        $title = "Conta desvinculada com <strong>SUCESSO</strong>";    
        echo success($title);
    @endphp

{{-- ERRO: Autenticação --}}
@elseif(isset($mensagens['error_authentication']))
    @php
        $errorAuthentication = $mensagens['error_authentication'];
        // EMAIL NECESSÁRIO
        if ($errorAuthentication == "email.required") {
            $title = "O campo de e-mail é obrigatório!";
        }
        // EMAIL INVÁLIDO 
        elseif ($errorAuthentication == "email.email") {
            $title = "O email informado é inválido!";
        }    
        // SENHA NECESSÁRIA
        elseif ($errorAuthentication == "email.email") {
            $title = "O campo de senha é obrigatório";
        }    
        // EMAIL/SENHA INCORRETO
        else {
            $title = "E-mail ou senha inválida!";
        }     
        echo error($title);       
    @endphp

{{-- ERRO: Acesso Guest --}}
@elseif(isset($mensagens['guest_acess']))
    @php
        $guestAcess = $mensagens['guest_acess'];
        // PERFIL
        if ($guestAcess == "profile") {
            $title = "Realize sua autenticação para ter acessar seu perfil";
        }
        // HISTORICO
        elseif ($guestAcess == "senha") {
            $title = "Realize sua autenticação para ";
        }       
        echo error($title);       
    @endphp

{{-- ATENÇÃO: Histórico - Vazio / Não autenticado --}}
@elseif(isset($mensagens['history']))
    @php
        $history = $mensagens['history'];
        // EMPTY
        if ($history == "empty") {
            echo historyEmpty();
        }
        // GUEST
        elseif ($history == "guest") {
            echo historyGuest();;
        }            
    @endphp

@php Session::forget('message'); @endphp
@endif
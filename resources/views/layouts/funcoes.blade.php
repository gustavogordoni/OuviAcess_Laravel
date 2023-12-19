@php
if (!function_exists('autenticado')) {
    function autenticado(){
        if (isset($_SESSION["id_usuario"])) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('redireciona')) {
    function redireciona($pagina = null){
        if (empty($pagina)){
            $pagina = "index.php";
        }
        header("Location: " . $pagina);
    }
}

if (!function_exists('ativar')) {
    function ativar($pagina){
        $url = url()->current();

        // Verifica se a URL está na raiz do diretório
        if ($pagina === '/' && $url === url('/')) {
            return " active rounded-4";
        }

        // Verifica se a URL corresponde ao padrão fornecido
        if (request()->is($pagina)) {
            return " active rounded-4";
        } else {
            return null;
        }
    }
}


  //request()->is('requerimentos'
@endphp

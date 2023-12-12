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
@endphp

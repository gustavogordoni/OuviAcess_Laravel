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
          if (basename($_SERVER["PHP_SELF"]) == $pagina) {
              return " active rounded-4";
          } else {
              return null;
          }
      }
  }
@endphp

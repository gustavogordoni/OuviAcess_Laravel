<?php
session_start();
require '../database/conexao.php';
include 'funcoes.php';

//$id_requerimento = filter_input(INPUT_GET, "requerimento");

if(isset($_SESSION["id_requerimento"])){
    $id_requerimento = $_SESSION["id_requerimento"];
}
if (empty($id_requerimento)) {
    $_SESSION["mostrar_imagem"] = "acesso_url";
    die();
}

if (autenticado()) {
    $id_usuario = $_SESSION["id_usuario"];
} elseif (!autenticado()) {
    $_SESSION["realizar_login"] = "mostrar-imagem";
    redireciona("login.php");
    die();
}

// Preparar a consulta
$sql = "SELECT dados_arquivo FROM arquivo a INNER JOIN requerimento r
ON a.id_requerimento = r.id_requerimento
WHERE a.id_requerimento = $id_requerimento AND r.id_usuario = $id_usuario";

$result = pg_query($conn_imagem, $sql);
$dados = pg_fetch_assoc($result);
$dados_arquivo = $dados["dados_arquivo"];
echo pg_unescape_bytea($dados_arquivo);
?>
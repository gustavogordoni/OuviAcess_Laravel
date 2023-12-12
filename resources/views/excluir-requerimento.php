<?php
include 'header.php';

$id_requerimento = filter_input(INPUT_POST, "deletar", FILTER_SANITIZE_NUMBER_INT);

if (autenticado()) {
    $id_usuario = $_SESSION["id_usuario"];
} elseif (!autenticado()) {
    $_SESSION["realizar_login"] = "excluir-requerimento";
    redireciona("login.php");
    die();
}

if (empty($id_requerimento)) {
    $_SESSION["crud_requerimento"] = "excluir_id";
    include 'mensagens.php';
    die();
}

if (!is_numeric($id_requerimento) || stripos($id_requerimento, "-")) {
    $_SESSION["id_not_numeric"] = "requerimento";   
    redireciona("historico.php");
    die();
}

require '../database/conexao.php';

// VERIFICAR SE HÁ IMAGEM DE UM REQUERIMENTO, ANTES DE EXCLUIR A TABELA REQUERIMENTO
$sql = "SELECT id_requerimento FROM arquivo WHERE id_requerimento = ?";

$stmt = $conn->prepare($sql);
$result = $stmt->execute([$id_requerimento]);
$cont = $stmt->rowCount();

if ($cont == 0) {
} elseif ($cont >= 1) {
    $sql = "DELETE FROM arquivo WHERE id_requerimento = ?";

    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$id_requerimento]);
}

$sql = "DELETE FROM requerimento WHERE id_requerimento = ? AND id_usuario = ?";

$stmt = $conn->prepare($sql);
$result = $stmt->execute([$id_requerimento, $id_usuario]);
$cont =  $stmt->rowCount();

if ($result == true && $cont == 1) {
    $_SESSION["excluir_requerimento"] = true;
    redireciona("historico.php");
    die();
} elseif ($cont == 0) {
    $_SESSION["id_requerimento_inexistente"] = true;
    include 'mensagens.php';
    die();
} else {
    $errorArray = $stmt->errorInfo();
?>
    <div class="row d-flex align-items-center ps-4">
        <div class="col-md-6 text-center">
            <h1 class="mt-2 text-danger">Falha ao ao efetuar a exclusão dos dodos do requerimento</h1>
            <p class="fs-5s"><?= $errorArray[2]; ?></p>
            <h2><a href="historico.php" class="btn btn-outline-info p-2 px-4 rounded-pill fs-3 mt-2">Retornar ao histórico</a></h2>

        </div>
        <div class="mx-auto col-md-6">
            <img src="../image/warning.png" alt="" width="80%" class="d-block mx-auto">
        </div>
    <?php

}
include 'footer.php';
include 'js.php'; ?>
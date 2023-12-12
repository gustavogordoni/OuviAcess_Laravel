<?php
include 'header.php';


$id_requerimento = filter_input(INPUT_POST, "alterar", FILTER_SANITIZE_NUMBER_INT);

if (autenticado()) {
    $id_usuario = $_SESSION["id_usuario"];
} elseif (!autenticado()) {
    $_SESSION["realizar_login"] = "alterar-perfil";
    redireciona("login.php");
    die();
}

$nome = trim(filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS));
$ddd = trim(filter_input(INPUT_POST, "ddd", FILTER_SANITIZE_SPECIAL_CHARS));
$telefone = trim(filter_input(INPUT_POST, "telefone", FILTER_SANITIZE_SPECIAL_CHARS));
//$email = trim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL));

///////////////////////////////////// VALIDAÇÕES /////////////////////////////////////

if (
    empty($nome) &&
    empty($ddd) &&
    empty($telefone) &&
    empty($email)
) {
    $_SESSION["error_perfil"] = "acesso_url";
    redireciona("perfil.php");
    die();
}

/// NOME
if (empty($nome)) {
    $_SESSION["error_perfil"] = "nome";
    redireciona("perfil.php");
    die();
} elseif (!preg_match('/^[A-Za-zÀ-ÿ\s]+$/', $nome)) {
    $_SESSION["caracteres_perfil"] = "nome_inadequado";
    redireciona("perfil.php");
    die();
} elseif (strlen($nome) < 4) {
    $_SESSION["caracteres_perfil"] = "nome_pequeno";
    $_SESSION["caracteres"] = strlen($nome);
    redireciona("perfil.php");
    die();
} elseif (strlen($nome) > 150) {
    $_SESSION["caracteres_perfil"] = "nome_grande";
    $_SESSION["caracteres"] = strlen($nome);
    redireciona("perfil.php");
    die();
}

/// DDD 
if (empty($ddd)) {
    $_SESSION["error_perfil"] = "ddd";
    redireciona("perfil.php");
    die();
} elseif (!preg_match('/^\([0-9]{2}\)$/', $ddd)) {
    $_SESSION["caracteres_perfil"] = "ddd_inadequado";
    redireciona("perfil.php");
    die();
}

/// TELEFONE
if (empty($telefone)) {
    $_SESSION["error_perfil"] = "telefone";
    redireciona("perfil.php");
    die();
} elseif (!preg_match('/^[0-9]{4,6}-[0-9]{3,4}$/', $telefone)) {
    $_SESSION["caracteres_perfil"] = "telefone_inadequado";
    redireciona("perfil.php");
    die();
}

/*
/// EMAIL
if (empty($email)) {
    $_SESSION["error_perfil"] = "email";
    redireciona("perfil.php");
    die();
} elseif (strlen($email) < 7) {
    $_SESSION["caracteres_perfil"] = "email_pequeno";
    $_SESSION["caracteres"] = strlen($email);
    redireciona("perfil.php");
    die();
} elseif (strlen($email) > 150) {
    $_SESSION["caracteres_perfil"] = "email_grande";
    $_SESSION["caracteres"] = strlen($email);
    redireciona("perfil.php");
    die();
}
*/

require '../database/conexao.php';

/*
$sql = "SELECT id_usuario, email FROM usuario WHERE email = ? AND id_usuario != ?";
$stmt = $conn->prepare($sql);
$result = $stmt->execute([$email, $id_usuario]);
$rowEmail = $stmt->fetch();
$cont = $stmt->rowCount();

if ($result == true && $cont >= 1) {
    $_SESSION["error_cadastro"] = "email_inexistente";
    redireciona("perfil.php");
    die();
}
*/

//$sql = "UPDATE usuario SET nome = ?, ddd = ?, telefone = ?, email = ? WHERE id_usuario = ?";
$sql = "UPDATE usuario SET nome = ?, ddd = ?, telefone = ? WHERE id_usuario = ?";

$stmt = $conn->prepare($sql);
$result = $stmt->execute([$nome, $ddd, $telefone, $id_usuario]);
$cont =  $stmt->rowCount();

if ($result == true && $cont >= 1) {
    $_SESSION["alterar_perfil"] = true;
    redireciona("perfil.php");
    die();
} elseif ($result == true && $cont == 0) {
    $_SESSION["manteve_perfil"] = true;
    redireciona("perfil.php");
    die();

} else {
    $errorArray = $stmt->errorInfo();
?>
    <div class="row d-flex align-items-center ps-4">
        <div class="col-md-6 text-center">
            <h1 class="mt-2 text-danger">Falha ao ao efetuar a alteração dos dodos do usuário</h1>
            <p class="fs-5s"><?= $errorArray[2]; ?></p>
            <h2><a href="historico.php" class="btn btn-outline-info p-2 px-4 rounded-pill fs-3 mt-2">Retornar ao histórico</a></h2>

        </div>
        <div class="mx-auto col-md-6">
            <img src="../image/warning.png" alt="" width="80%" class="d-block mx-auto">
        </div>
    <?php
}
include 'js.php';
?>
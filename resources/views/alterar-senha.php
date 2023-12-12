<?php
include 'header.php';

if (autenticado()) {
    $id_usuario = $_SESSION["id_usuario"];
} elseif (!autenticado()) {
    $_SESSION["realizar_login"] = "alterar-senha";
    redireciona("login.php");
    die();
}

$senha_atual = trim(filter_input(INPUT_POST, "senha_atual", FILTER_SANITIZE_SPECIAL_CHARS));
$senha_nova = trim(filter_input(INPUT_POST, "senha_nova", FILTER_SANITIZE_SPECIAL_CHARS));
$senha_confirmacao = trim(filter_input(INPUT_POST, "senha_confirmacao", FILTER_SANITIZE_SPECIAL_CHARS));

///////////////////////////////////// VALIDAÇÕES /////////////////////////////////////

if (
    empty($senha_atual) &&
    empty($senha_nova) &&
    empty($senha_confirmacao)
) {
    $_SESSION["erro_alterarSenha"] = "acesso_url";
    redireciona("editar-perfil.php");
    die();
}

/// SENHA
if (empty($senha_atual)) {
    $_SESSION["erro_alterarSenha"] = "senha_atual";
    redireciona("editar-perfil.php");
    die();
}
/// NOVA
if (empty($senha_nova)) {
    $_SESSION["erro_alterarSenha"] = "senha_nova";
    redireciona("editar-perfil.php");
    die();
}
/// CONFIRME
if (empty($senha_confirmacao)) {
    $_SESSION["erro_alterarSenha"] = "senha_confirmacao";
    redireciona("editar-perfil.php");  
}
/// CONFIRMAÇÃO DA SENHA - ESTÃO IGUAIS
if ($senha_nova != $senha_confirmacao) {
    $_SESSION["erro_alterarSenha"] = "senhas_diferentes";
    redireciona("editar-perfil.php");
    die();
}

require '../database/conexao.php';

$sql = "SELECT senha FROM usuario WHERE id_usuario = ?";

$stmt = $conn->prepare($sql);
$result = $stmt->execute([$id_usuario]);
$row = $stmt->fetch();
$cont = $stmt->rowCount();

if (password_verify($senha_atual, $row['senha'])) {

    if ($senha_atual == $senha_nova) {
        // MESMA SENHA
        $_SESSION["alterarSenha"] = "mesma";
        redireciona("perfil.php");
        die();
    }

    $senha_hash = password_hash($senha_nova, PASSWORD_BCRYPT);

    $sql = "UPDATE usuario SET senha = ? WHERE id_usuario = ?";

    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$senha_hash, $id_usuario]);
    $cont =  $stmt->rowCount();

    if ($result == true && $cont >= 1) {
        $_SESSION["alterarSenha"] = "sucesso";
        redireciona("perfil.php");
        die();
    } elseif ($result == true && $cont == 0) {
        // MESMA SENHA
        $_SESSION["alterarSenha"] = "mesma";
        redireciona("perfil.php");
        die();
    } else {
        // ERRO NO PROCESSO
        $_SESSION["erro_alterarSenha"] = "erro_nao_identificado";
        redireciona("editar-perfil.php");
        die();
    }
} else {
    // SENHAS DIFERENTES
    $_SESSION["erro_alterarSenha"] = "diferentes";
    redireciona("editar-perfil.php");
    die();
}

include 'js.php';
include 'mensagens.php';

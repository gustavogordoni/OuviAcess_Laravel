<?php
include 'header.php';


$nome = trim(filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS));
$ddd = trim(filter_input(INPUT_POST, "ddd", FILTER_SANITIZE_SPECIAL_CHARS));
$telefone = trim(filter_input(INPUT_POST, "telefone", FILTER_SANITIZE_SPECIAL_CHARS));
$email = trim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL));
$senha = trim(filter_input(INPUT_POST, "senha", FILTER_SANITIZE_SPECIAL_CHARS));
$confirme = trim(filter_input(INPUT_POST, "confirme", FILTER_SANITIZE_SPECIAL_CHARS));

///////////////////////////////////// VALIDAÇÕES /////////////////////////////////////
$_SESSION["nome_cadastro"] = $nome;
$_SESSION["ddd_cadastro"] = $ddd;
$_SESSION["telefone_cadastro"] = $telefone;
$_SESSION["email_cadastro"] = $email;

/// TUDO VAZIO - ACESSO POR URL

if (
    empty($nome) &&
    empty($ddd) &&
    empty($telefone) &&
    empty($email) &&
    empty($senha) &&
    empty($confirme)
) {
    $_SESSION["error_cadastro"] = "acesso_url";
    redireciona("cadastro-usuario.php");
    die();
}

/// NOME
if (empty($nome)) {
    $_SESSION["error_cadastro"] = "nome";
    $_SESSION["nome_cadastro"] = null;
    redireciona("cadastro-usuario.php");
    die();
} elseif (!preg_match('/^[A-Za-zÀ-ÿ\s]+$/', $nome)) {
    $_SESSION["caracteres_cadastro"] = "nome_inadequado";
    $_SESSION["nome_cadastro"] = null;
    $_SESSION["caracteres"] = null;
    redireciona("cadastro-usuario.php");
    die();
} elseif (strlen($nome) < 4) {
    $_SESSION["caracteres_cadastro"] = "nome_pequeno";
    $_SESSION["caracteres"] = strlen($nome);
    redireciona("cadastro-usuario.php");
    die();
} elseif (strlen($nome) > 150) {
    $_SESSION["caracteres_cadastro"] = "nome_grande";
    $_SESSION["caracteres"] = strlen($nome);
    redireciona("cadastro-usuario.php");
    die();
}

/// DDD 
if (empty($ddd)) {
    $_SESSION["error_cadastro"] = "ddd";
    $_SESSION["ddd_cadastro"] = null;
    redireciona("cadastro-usuario.php");
    die();
} elseif (!preg_match('/^\([0-9]{2}\)$/', $ddd)) {
    $_SESSION["caracteres_cadastro"] = "ddd_inadequado";
    $_SESSION["ddd_cadastro"] = null;
    $_SESSION["caracteres"] = null;
    redireciona("cadastro-usuario.php");
    die();
}

/// TELEFONE
if (empty($telefone)) {
    $_SESSION["error_cadastro"] = "telefone";
    $_SESSION["telefone_cadastro"] = null;
    redireciona("cadastro-usuario.php");
    die();
} elseif (!preg_match('/^[0-9]{4,6}-[0-9]{3,4}$/', $telefone)) {
    $_SESSION["caracteres_cadastro"] = "telefone_inadequado";
    $_SESSION["telefone_cadastro"] = null;
    $_SESSION["caracteres"] = null;
    redireciona("cadastro-usuario.php");
    die();
}

/// EMAIL
if (empty($email)) {
    $_SESSION["error_cadastro"] = "email";
    $_SESSION["email_cadastro"] = null;
    redireciona("cadastro-usuario.php");
    die();
} elseif (strlen($email) < 7) {
    $_SESSION["caracteres_cadastro"] = "email_pequeno";
    $_SESSION["caracteres"] = strlen($email);
    redireciona("cadastro-usuario.php");
    die();
} elseif (strlen($email) > 150) {
    $_SESSION["caracteres_cadastro"] = "email_grande";
    $_SESSION["caracteres"] = strlen($email);
    redireciona("cadastro-usuario.php");
    die();
}

/// SENHA
if (empty($senha)) {
    $_SESSION["error_cadastro"] = "senha";
    redireciona("cadastro-usuario.php");
    die();
}elseif (strlen($senha) < 3) {
    $_SESSION["caracteres_cadastro"] = "senha_pequena";
    $_SESSION["caracteres"] = strlen($senha);
    redireciona("cadastro-usuario.php");
    die();
} elseif (strlen($senha) > 150) {
    $_SESSION["caracteres_cadastro"] = "senha_grande";
    $_SESSION["caracteres"] = strlen($senha);
    redireciona("cadastro-usuario.php");
    die();
}

/// CONFIRME
if (empty($confirme)) {
    $_SESSION["error_cadastro"] = "confirme";
    redireciona("cadastro-usuario.php");
    die();
}
/// CONFIRMAÇÃO DA SENHA - ESTÃO IGUAIS
if ($senha != $confirme) {
    $_SESSION["caracteres_cadastro"] = "senhas_diferentes";
    redireciona("cadastro-usuario.php");
    die();
}


require '../database/conexao.php';

$sql = "SELECT id_usuario, email FROM usuario WHERE email = ?";
$stmt = $conn->prepare($sql);
$result = $stmt->execute([$email]);
$rowEmail = $stmt->fetch();
$cont = $stmt->rowCount();

if ($result == true && $cont >= 1) {
    $_SESSION["error_cadastro"] = "email_inexistente";
    $_SESSION["email_cadastro"] = null;
    redireciona("cadastro-usuario.php");
    die();
}

$senha_hash = password_hash($senha, PASSWORD_BCRYPT);

$sql = "INSERT INTO Usuario(nome, ddd, telefone, email, senha) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$result = $stmt->execute([$nome, $ddd, $telefone, $email, $senha_hash]);


if ($result == true) {
    $_SESSION["add_cadastro"] = true;
    $_SESSION["email"] = $email;
    $_SESSION["senha"] = $senha;
    redireciona("verificar-login.php");
    die();
} else {
    $errorArray = $stmt->errorInfo();
?>
    <div class="alert alert-danger" role="alert">
        <h4>FALHA ao efetuar a gravação dos dodos</h4>
        <p><?= $errorArray[2]; ?></p>
    </div>
<?php
}
require 'footer.php';
require 'js.php';
?>
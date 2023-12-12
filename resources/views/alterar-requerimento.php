<?php
include 'header.php';

$id_requerimento = filter_input(INPUT_POST, "alterar", FILTER_SANITIZE_NUMBER_INT);

if (autenticado()) {
    $id_usuario = $_SESSION["id_usuario"];
} elseif (!autenticado()) {
    $_SESSION["realizar_login"] = "alterar-requerimento";
    redireciona("login.php");
    die();
}

if (empty($id_requerimento)) {
    $_SESSION["crud_requerimento"] = "alterar_id";
    include 'mensagens.php';
    die();
}

if (!is_numeric($id_requerimento) || stripos($id_requerimento, "-")) {
    $_SESSION["id_not_numeric"] = "requerimento";   
    redireciona("historico.php");
    die();
}

require '../database/conexao.php';

$sql = "SELECT * FROM requerimento WHERE id_requerimento = ? AND id_usuario = ?";

$stmt = $conn->prepare($sql);
$result = $stmt->execute([$id_requerimento, $id_usuario]);
$rowRequeriemento = $stmt->fetch();
$cont =  $stmt->rowCount();

if ($cont == 0) {
    $_SESSION["id_requerimento_inexistente"] = true;
    include 'mensagens.php';
    die();
}

function validacaoEditar($id_requerimento)
{
    $editar = "editar-requerimento.php?editar=";
    header("Location: " . $editar . $id_requerimento);
}

$titulo = trim(filter_input(INPUT_POST, "titulo", FILTER_SANITIZE_SPECIAL_CHARS));
$tipo = filter_input(INPUT_POST, "tipo", FILTER_SANITIZE_SPECIAL_CHARS);
$cidade = trim(filter_input(INPUT_POST, "cidade", FILTER_SANITIZE_SPECIAL_CHARS));
$cep = trim(filter_input(INPUT_POST, "cep", FILTER_SANITIZE_SPECIAL_CHARS));
$bairro = trim(filter_input(INPUT_POST, "bairro", FILTER_SANITIZE_SPECIAL_CHARS));
$logradouro = trim(filter_input(INPUT_POST, "logradouro", FILTER_SANITIZE_SPECIAL_CHARS));
$descricao = trim(filter_input(INPUT_POST, "descricao", FILTER_SANITIZE_SPECIAL_CHARS));


///////////////////////////////////// VALIDAÇÕES /////////////////////////////////////

/// TUDO VAZIO - ACESSO POR URL
if (
    empty($titulo) &&
    empty($tipo) &&
    empty($cidade) &&
    empty($cep) &&
    empty($bairro) &&
    empty($logradouro) &&
    empty($descricao)
) {
    $_SESSION["error_requerimento"] = "acesso_url";
    validacaoEditar($id_requerimento);
    die();
}

/// TITULO
if (empty($titulo)) {
    $_SESSION["error_requerimento"] = "titulo";
    validacaoEditar($id_requerimento);
    die();
} elseif (!preg_match('/^[A-Za-zÀ-ÿ\s]+$/', $titulo)) {
    $_SESSION["caracteres_requerimento"] = "titulo_inadequado";
    $_SESSION["caracteres"] = strlen($titulo);
    validacaoEditar($id_requerimento);
    die();
} elseif (strlen($titulo) < 10) {
    $_SESSION["caracteres_requerimento"] = "titulo_pequeno";
    $_SESSION["caracteres"] = strlen($titulo);
    validacaoEditar($id_requerimento);
    die();
} elseif (strlen($titulo) > 250) {
    $_SESSION["caracteres_requerimento"] = "titulo_grande";
    $_SESSION["caracteres"] = strlen($titulo);
    validacaoEditar($id_requerimento);
    die();
}

/// TIPO
if (empty($tipo)) {
    $_SESSION["error_requerimento"] = "tipo";
    validacaoEditar($id_requerimento);
    die();
} elseif ($tipo != "Denúncia" && $tipo != "Sugestão") {
    $_SESSION["caracteres_requerimento"] = "tipo_invalido";
    $_SESSION["caracteres"] = $tipo;
    validacaoEditar($id_requerimento);
    die();
}

/// CIDADE
if (empty($cidade)) {
    $_SESSION["error_requerimento"] = "cidade";
    validacaoEditar($id_requerimento);
    die();
} elseif (!preg_match('/^[A-Za-zÀ-ÿ\s]+$/', $cidade)) {
    $_SESSION["caracteres_requerimento"] = "cidade_inadequada";
    $_SESSION["caracteres"] = strlen($cidade);
    validacaoEditar($id_requerimento);
    die();
} elseif (strlen($cidade) < 3) {
    $_SESSION["caracteres_requerimento"] = "cidade_pequeno";
    $_SESSION["caracteres"] = strlen($cidade);
    validacaoEditar($id_requerimento);
    die();
} elseif (strlen($cidade) > 250) {
    $_SESSION["caracteres_requerimento"] = "cidade_grande";
    $_SESSION["caracteres"] = strlen($cidade);
    validacaoEditar($id_requerimento);
    die();
}

/// CEP
if (empty($cep)) {
    $_SESSION["error_requerimento"] = "cep";
    validacaoEditar($id_requerimento);
    die();
} elseif (!preg_match('/^\d{2}\.\d{3}-\d{3}$/', $cep)) {
    $_SESSION["caracteres_requerimento"] = "cep_inadequado";
    $_SESSION["caracteres"] = $cep;
    validacaoEditar($id_requerimento);
    die();
}

/// BAIRRO
if (empty($bairro)) {
    $_SESSION["error_requerimento"] = "bairro";
    validacaoEditar($id_requerimento);
    die();
} elseif (!preg_match('/^[A-Za-zÀ-ÿ0-9\s]+$/', $bairro)) {
    $_SESSION["caracteres_requerimento"] = "bairro_inadequado";
    $_SESSION["caracteres"] = strlen($bairro);
    validacaoEditar($id_requerimento);
    die();
} elseif (strlen($bairro) < 3) {
    $_SESSION["caracteres_requerimento"] = "bairro_pequeno";
    $_SESSION["caracteres"] = strlen($bairro);
    validacaoEditar($id_requerimento);
    die();
} elseif (strlen($bairro) > 250) {
    $_SESSION["caracteres_requerimento"] = "bairro_grande";
    $_SESSION["caracteres"] = strlen($bairro);
    validacaoEditar($id_requerimento);
    die();
}

/// RUA
if (empty($logradouro)) {
    $_SESSION["error_requerimento"] = "logradouro";
    validacaoEditar($id_requerimento);
    die();
} elseif (!preg_match('/^[A-Za-zÀ-ÿ0-9\s]+$/', $logradouro)) {
    $_SESSION["caracteres_requerimento"] = "logradouro_inadequada";
    $_SESSION["caracteres"] = strlen($logradouro);
    validacaoEditar($id_requerimento);
    die();
} elseif (strlen($logradouro) < 2) {
    $_SESSION["caracteres_requerimento"] = "logradouro_pequena";
    $_SESSION["caracteres"] = strlen($logradouro);
    validacaoEditar($id_requerimento);
    die();
} elseif (strlen($logradouro) > 250) {
    $_SESSION["caracteres_requerimento"] = "logradouro_grande";
    $_SESSION["caracteres"] = strlen($logradouro);
    validacaoEditar($id_requerimento);
    die();
}

/// DESCRIÇÃO
if (empty($descricao)) {
    $_SESSION["error_requerimento"] = "descricao";
    validacaoEditar($id_requerimento);
    die();
} elseif (strlen($descricao) < 50) {
    $_SESSION["caracteres_requerimento"] = "descricao_pequena";
    $_SESSION["caracteres"] = strlen($descricao);
    validacaoEditar($id_requerimento);
    die();
} elseif (strlen($descricao) > 2000) {
    $_SESSION["caracteres_requerimento"] = "descricao_grande";
    $_SESSION["caracteres"] = strlen($descricao);
    validacaoEditar($id_requerimento);
    die();
}

$sql = "UPDATE requerimento SET titulo = ?, tipo = ?, cidade = ?, cep = ?, bairro = ?, logradouro = ?, descricao = ?  WHERE id_requerimento = ? AND id_usuario = ?";

$stmt = $conn->prepare($sql);
$result = $stmt->execute([$titulo, $tipo, $cidade, $cep, $bairro, $logradouro, $descricao, $id_requerimento, $id_usuario]);
$cont =  $stmt->rowCount();

if ($result == true && $cont >= 1) {

    $sql = "SELECT dados_arquivo, nome FROM arquivo a INNER JOIN requerimento r
        ON a.id_requerimento = r.id_requerimento
        WHERE a.id_requerimento = ? AND r.id_usuario = ?";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_requerimento, $id_usuario]);
    $cont = $stmt->rowCount();

    if ($cont >= 1 && !empty($_FILES['arquivo']['tmp_name'])) {

        $nome = $_FILES['arquivo']['name'];
        $tamanho = $_FILES['arquivo']['size'];
        $tipo = $_FILES['arquivo']['type'];
        $extensao = pathinfo($nome, PATHINFO_EXTENSION);
        // Read in a binary file
        $data = file_get_contents($_FILES['arquivo']['tmp_name']);
        // Escape the binary data
        $dados_arquivo = bin2hex($data);

        $sql = "UPDATE arquivo a SET nome = '$nome', dados_arquivo = decode('{$dados_arquivo}', 'hex')
        WHERE id_requerimento = $id_requerimento AND EXISTS (
            SELECT 1 FROM requerimento r WHERE r.id_requerimento = a.id_requerimento AND r.id_usuario = $id_usuario
        )";

        $result = pg_query($conn_imagem, $sql);

    } elseif($cont == 0 && !empty($_FILES['arquivo']['tmp_name'])) {

        $nome = $_FILES['arquivo']['name'];
        $tamanho = $_FILES['arquivo']['size'];
        $tipo = $_FILES['arquivo']['type'];
        $extensao = pathinfo($nome, PATHINFO_EXTENSION);
        // Read in a binary file
        $data = file_get_contents($_FILES['arquivo']['tmp_name']);
        // Escape the binary data
        $dados_arquivo = bin2hex($data);

        $sql = "INSERT INTO arquivo(id_requerimento, nome, dados_arquivo)
        VALUES ($id_requerimento,'$nome', decode('{$dados_arquivo}' , 'hex'));";

        $result = pg_query($conn_imagem, $sql);
    }

    /*
    if (!empty($_FILES['arquivo']['tmp_name'])) {

        $nome = $_FILES['arquivo']['name'];
        $tamanho = $_FILES['arquivo']['size'];
        $tipo = $_FILES['arquivo']['type'];
        $extensao = pathinfo($nome, PATHINFO_EXTENSION);
        // Read in a binary file
        $data = file_get_contents($_FILES['arquivo']['tmp_name']);
        // Escape the binary data
        $dados_arquivo = bin2hex($data);

        $sql = "UPDATE arquivo a SET nome = '$nome', dados_arquivo = decode('{$dados_arquivo}', 'hex')
        WHERE id_requerimento = $id_requerimento AND EXISTS (
            SELECT 1 FROM requerimento r WHERE r.id_requerimento = a.id_requerimento AND r.id_usuario = $id_usuario
        )";

        $result = pg_query($conn_imagem, $sql);
    }
    */

    $_SESSION["alterar_requerimento"] = true;
    redireciona("historico.php");
    //include 'mensagens.php';
    die();
} elseif ($result == true && $cont == 0) {
    $_SESSION["manteve_requerimento"] = true;
    redireciona("historico.php");
    die();
} else {
    $errorArray = $stmt->errorInfo();
    ?>
    <div class="row d-flex align-items-center ps-4">
        <div class="col-md-6 text-center">
            <h1 class="mt-2 text-danger">Falha ao ao efetuar a alteração dos dodos do requerimento</h1>
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
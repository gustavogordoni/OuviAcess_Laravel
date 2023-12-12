<?php
include 'header.php';


$titulo = trim(filter_input(INPUT_POST, "titulo", FILTER_SANITIZE_SPECIAL_CHARS));
$tipo = filter_input(INPUT_POST, "tipo", FILTER_SANITIZE_SPECIAL_CHARS);
$cidade = trim(filter_input(INPUT_POST, "cidade", FILTER_SANITIZE_SPECIAL_CHARS));
$cep = trim(filter_input(INPUT_POST, "cep", FILTER_SANITIZE_SPECIAL_CHARS));
$bairro = trim(filter_input(INPUT_POST, "bairro", FILTER_SANITIZE_SPECIAL_CHARS));
$logradouro = trim(filter_input(INPUT_POST, "logradouro", FILTER_SANITIZE_SPECIAL_CHARS));
$descricao = trim(filter_input(INPUT_POST, "descricao", FILTER_SANITIZE_SPECIAL_CHARS));
$anonimo = trim(filter_input(INPUT_POST, "anonimo", FILTER_SANITIZE_SPECIAL_CHARS));

if (autenticado()) {
    $id_usuario = $_SESSION["id_usuario"];
} elseif (!autenticado()) {
    $id_usuario = null;
    $anonimo = true;
    echo $anonimo;
}

if (empty($anonimo)) {
    $anonimo = false;
    echo $anonimo;
}

///////////////////////////////////// VALIDAÇÕES /////////////////////////////////////
$_SESSION["titulo_requerimento"] = $titulo;
$_SESSION["tipo_requerimento"] = $tipo;
$_SESSION["cidade_requerimento"] = $cidade;
$_SESSION["cep_requerimento"] = $cep;
$_SESSION["bairro_requerimento"] = $bairro;
$_SESSION["logradouro_requerimento"] = $logradouro;
$_SESSION["descricao_requerimento"] = $descricao;
$_SESSION["anonimo_requerimento"] = $anonimo;

/// TUDO VAZIO - ACESSO POR URL
if (
    empty($titulo) &&
    empty($tipo) &&
    empty($cidade) &&
    empty($cep) &&
    empty($bairro) &&
    empty($logradouro) &&
    empty($descricao) &&
    empty($anonimo)
) {
    $_SESSION["error_requerimento"] = "acesso_url";
    redireciona("requerimento.php");
    die();
}

/// TITULO
if (empty($titulo)) {
    $_SESSION["error_requerimento"] = "titulo";
    $_SESSION["titulo_requerimento"] = null;
    redireciona("requerimento.php");
    die();
}elseif (!preg_match('/^[A-Za-zÀ-ÿ\s]+$/', $titulo)) {
    $_SESSION["caracteres_requerimento"] = "titulo_inadequado";
    $_SESSION["titulo_requerimento"] = null;
    $_SESSION["caracteres"] = null;
    redireciona("requerimento.php");
    die();
}elseif (strlen($titulo) < 10) {
    $_SESSION["caracteres_requerimento"] = "titulo_pequeno";
    $_SESSION["caracteres"] = strlen($titulo);
    redireciona("requerimento.php");
    die();
} elseif (strlen($titulo) > 150) {
    $_SESSION["caracteres_requerimento"] = "titulo_grande";
    $_SESSION["caracteres"] = strlen($titulo);
    redireciona("requerimento.php");
    die();
}

/// TIPO
if (empty($tipo)) {
    $_SESSION["error_requerimento"] = "tipo";
    $_SESSION["tipo_requerimento"] = null;
    redireciona("requerimento.php");
    die();
} elseif ($tipo != "Denúncia" && $tipo != "Sugestão") {
    $_SESSION["caracteres_requerimento"] = "tipo_invalido";
    $_SESSION["tipo_requerimento"] = null;
    $_SESSION["caracteres"] = $tipo;
    redireciona("requerimento.php");
    die();
}

/// CIDADE
if (empty($cidade)) {
    $_SESSION["error_requerimento"] = "cidade";
    $_SESSION["cidade_requerimento"] = null;
    redireciona("requerimento.php");
    die();
}elseif (!preg_match('/^[A-Za-zÀ-ÿ\s]+$/', $cidade)) {
    $_SESSION["caracteres_requerimento"] = "cidade_inadequada";
    $_SESSION["cidade_requerimento"] = null;
    $_SESSION["caracteres"] = null;
    redireciona("requerimento.php");
    die();
} elseif (strlen($cidade) < 3) {
    $_SESSION["caracteres_requerimento"] = "cidade_pequeno";
    $_SESSION["caracteres"] = strlen($cidade);
    redireciona("requerimento.php");
    die();
} elseif (strlen($cidade) > 150) {
    $_SESSION["caracteres_requerimento"] = "cidade_grande";
    $_SESSION["caracteres"] = strlen($cidade);
    redireciona("requerimento.php");
    die();
}

/// CEP
if (empty($cep)) {
    $_SESSION["error_requerimento"] = "cep";
    $_SESSION["cep_requerimento"] = null;
    redireciona("requerimento.php");
    die();
} elseif (!preg_match('/^\d{2}\.\d{3}-\d{3}$/', $cep)) {
    $_SESSION["caracteres_requerimento"] = "cep_inadequado";
    $_SESSION["caracteres"] = null;
    $_SESSION["cep_requerimento"] = null;
    redireciona("requerimento.php");
    die();
}

/// BAIRRO
if (empty($bairro)) {
    $_SESSION["error_requerimento"] = "bairro";
    $_SESSION["bairro_requerimento"] = null;
    redireciona("requerimento.php");
    die();
}elseif (!preg_match('/^[A-Za-zÀ-ÿ0-9\s]+$/', $bairro)) {
    $_SESSION["caracteres_requerimento"] = "bairro_inadequado";
    $_SESSION["bairro_requerimento"] = null;
    $_SESSION["caracteres"] = null;
    redireciona("requerimento.php");
    die();
} elseif (strlen($bairro) < 3) {
    $_SESSION["caracteres_requerimento"] = "bairro_pequeno";
    $_SESSION["caracteres"] = strlen($bairro);
    redireciona("requerimento.php");
    die();
} elseif (strlen($bairro) > 150) {
    $_SESSION["caracteres_requerimento"] = "bairro_grande";
    $_SESSION["caracteres"] = strlen($bairro);
    redireciona("requerimento.php");
    die();
}

/// RUA
if (empty($logradouro)) {
    $_SESSION["error_requerimento"] = "logradouro";
    $_SESSION["logradouro_requerimento"] = null;
    redireciona("requerimento.php");
    die();
}elseif (!preg_match('/^[A-Za-zÀ-ÿ0-9\s]+$/', $logradouro)) {
    $_SESSION["caracteres_requerimento"] = "logradouro_inadequada";
    $_SESSION["logradouro_requerimento"] = null;
    $_SESSION["caracteres"] = null;
    redireciona("requerimento.php");
    die();
}elseif (strlen($logradouro) < 2) {
    $_SESSION["caracteres_requerimento"] = "logradouro_pequena";
    $_SESSION["caracteres"] = strlen($logradouro);
    redireciona("requerimento.php");
    die();
} elseif (strlen($logradouro) > 150) {
    $_SESSION["caracteres_requerimento"] = "logradouro_grande";
    $_SESSION["caracteres"] = strlen($logradouro);
    redireciona("requerimento.php");
    die();
}

/// DESCRIÇÃO
if (empty($descricao)) {
    $_SESSION["error_requerimento"] = "descricao";
    $_SESSION["descricao_requerimento"] = null;
    redireciona("requerimento.php");
    die();
} elseif (strlen($descricao) < 50) {
    $_SESSION["caracteres_requerimento"] = "descricao_pequena";
    $_SESSION["caracteres"] = strlen($descricao);
    redireciona("requerimento.php");
    die();
}elseif (strlen($descricao) > 2000) {
    $_SESSION["caracteres_requerimento"] = "descricao_grande";
    $_SESSION["caracteres"] = strlen($descricao);
    redireciona("requerimento.php");
    die();
}

/// ANONIMO
if ($anonimo != true && $anonimo != false) {
    $_SESSION["error_requerimento"] = "anonimo";
    $_SESSION["anonimo_requerimento"] = null;
    redireciona("requerimento.php");
    die();
}


$situacao = "Pendente";
date_default_timezone_set('America/Sao_Paulo');
$data = date('d/m/Y');


require '../database/conexao.php';
///// IDENTIFICAR O MAIOR ID REQUERIMENTO
$sql = "SELECT id_requerimento FROM requerimento";

$stmt = $conn->prepare($sql);
$result = $stmt->execute();
$cont = $stmt->rowCount();
$maior = 0;

if ($cont == 0) {
    $maior = 0;
} elseif ($cont >= 1) {
    while ($row =  $stmt->fetch()) {
        if ($maior < $row["id_requerimento"]) {
            $maior = $row["id_requerimento"];
        }
    }
}
$id_requerimento = $maior + 1;

if ($anonimo == false) {
    // ENVIO NÃO ANONIMO
    $sql = "INSERT INTO requerimento(id_requerimento, id_usuario, titulo, tipo, situacao, data, descricao, cep, cidade, bairro, logradouro) VALUES (?,?,?,?,?,?,?,?,?,?,?)";

    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$id_requerimento, $id_usuario, $titulo, $tipo, $situacao, $data, $descricao, $cep, $cidade, $bairro, $logradouro]);
} elseif ($anonimo == true) {
    // ENVIO ANONIMO
    $sql = "INSERT INTO requerimento(id_requerimento, titulo, tipo, situacao, data, descricao, cep, cidade, bairro, logradouro) VALUES (?,?,?,?,?,?,?,?,?,?)";

    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$id_requerimento, $titulo, $tipo, $situacao, $data, $descricao, $cep, $cidade, $bairro, $logradouro]);
}

if ($result == true) {
    // SUCESSO NA GRAVAÇÃO DO REQUERIMENTO
    if (!empty($_FILES['arquivo']['name'])) {
        // HÁ IMAGEM PARA ENVIAR

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

        if ($result == true) {
            $_SESSION["add_requerimento"] = true;
            redireciona("historico.php");
            die();
        }
    } elseif (empty($_FILES['arquivo']['name'])) {
        // NÃO HÁ IMAGEM PARA ENVIAR
        $_SESSION["add_requerimento"] = true;
        redireciona("historico.php");
        die();
    }
} else {
    $errorArray = $stmt->errorInfo();
?>
    <div class="alert alert-danger alert-dismissible fade show position-absolute bottom-0 end-0" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </svg>
        <strong>FALHA</strong> ao efetuar a gravação dos dodos requerimento<br>
        <p><?= $errorArray[2]; ?></p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}

include 'js.php'; ?>
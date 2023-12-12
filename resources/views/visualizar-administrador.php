<?php
include 'header.php';

$id_administrador = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
//$id_administrador = $_GET["id"];

if (autenticado()) {
    $id_usuario = $_SESSION["id_usuario"];
}
elseif (!autenticado()) {
    $_SESSION["realizar_login"] = "visualizar-administrador";
    redireciona("login.php");
    die();
}

if (empty($id_administrador)) {
    $_SESSION["crud_requerimento"] = "visualizar_administrador";
    include 'mensagens.php';
    die();
}

if (!is_numeric($id_administrador) || stripos($id_administrador, "-")) {
    $_SESSION["id_not_numeric"] = "administrador";
    //include 'mensagens.php';
    redireciona("historico.php");
    die();
}

require '../database/conexao.php';

$sql = "SELECT * FROM administrador WHERE id_administrador = ?";

$stmt = $conn->prepare($sql);
$result = $stmt->execute([$id_administrador]);
$rowAdministrador = $stmt->fetch();
$cont =  $stmt->rowCount();

if ($cont == 0) {
    $_SESSION["id_administrador_inexistente"] = $id_administrador;
    include 'mensagens.php';
    die();
}

$nome = explode(' ', $rowAdministrador['nome']);
$firstName = $nome[0];

require 'navbar.php';
?>

<div class="container h-75">
    <main>
        <div class="py-3 text-center mt-4">
            <strong>
                <h2>Informações do Administrador  <br>
                    <strong><?= $firstName ?></strong> <span class="fs-2"></span>
                </h2>
            </strong>
        </div>

        <div class="row">
            <div class="col-11 mx-auto mb-4">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="titulo" class="form-label"><strong>Nome completo: </strong></label>
                        <input readonly type="text" class="form-control" id="titulo" value="<?= $rowAdministrador['nome'] ?>" name="titulo">
                    </div>

                    <div class="col-md-3">
                        <label for="tipo" class="form-label"><strong>DDD:</strong></label>
                        <input readonly type="text" class="form-control" id="tipo" value="<?= $rowAdministrador['ddd'] ?>" name="tipo">
                    </div>

                    <div class="col-md-9">
                        <label for="bairro" class="form-label"><strong>Telefone: </strong></label>
                        <input readonly type="text" class="form-control" id="bairro" name="bairro" value="<?= $rowAdministrador['telefone'] ?>">
                    </div>

                    <div class="col-12">
                        <label for="email" class="form-label"><strong>E-mail: </strong></label>
                        <div class="input-group has-validation">
                            <span class="input-group-text">@</span>
                            <input readonly type="email" class="form-control" id="email" name="email" value="<?= $rowAdministrador['email'] ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="mt-4 col-12 row">
                        <a class="w-100 btn btn-secondary rounded-pill px-3 btn-lg" href="historico.php">Voltar ao histórico</a>
                    </div>

                </div>
            </div>
        </div>

    </main>
</div>

<?php
require 'footer.php';
include 'mensagens.php';
require 'js.php';
?>
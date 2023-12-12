<?php
include 'header.php';

$id_requerimento = filter_input(INPUT_GET, "visualizar", FILTER_SANITIZE_NUMBER_INT);

if (autenticado()) {
    $id_usuario = $_SESSION["id_usuario"];
} elseif (!autenticado()) {
    $_SESSION["realizar_login"] = "visualizar-requerimento";
    redireciona("login.php");
    die();
}

if (empty($id_requerimento)) {
    $_SESSION["crud_requerimento"] = "visualizar_id";
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
$rowAdministrador = $stmt->fetch();

if (isset($rowAdministrador["id_administrador"]) && !empty($rowAdministrador["id_administrador"])) {
    $sql = 'SELECT r.*, a.nome AS "administrador" FROM requerimento r
        INNER JOIN administrador a ON r.id_administrador = a.id_administrador
        WHERE r.id_requerimento = ? AND r.id_usuario = ?';
} else {
    $sql = "SELECT * FROM requerimento WHERE id_requerimento = ? AND id_usuario = ?";
}

$stmt = $conn->prepare($sql);
$result = $stmt->execute([$id_requerimento, $id_usuario]);
$rowRequeriemento = $stmt->fetch();
$cont =  $stmt->rowCount();

if ($cont == 0) {
    $_SESSION["id_requerimento_inexistente"] = true;
    include 'mensagens.php';
    die();
}

$sql = "SELECT dados_arquivo, nome FROM arquivo a INNER JOIN requerimento r
ON a.id_requerimento = r.id_requerimento
WHERE a.id_requerimento = ? AND r.id_usuario = ?";

$stmt = $conn->prepare($sql);
$stmt->execute([$id_requerimento, $id_usuario]);
$dados = $stmt->fetch();
$cont = $stmt->rowCount();

if ($cont >= 1) {
    $_SESSION["id_requerimento"] = $id_requerimento;
}

require 'navbar.php';
?>

<div class="container">
    <main>
        <div class="py-3 text-center mt-4">
            <strong>
                <h2>Detalhes do Requerimento <br> ID: <?= $id_requerimento ?></h2>
            </strong>
        </div>

        <div class="row">
            <div class="col-11 mx-auto mb-4">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label for="titulo" class="form-label"><strong>Título do requerimento: </strong></label>
                        <input readonly type="text" class="form-control" id="titulo" value="<?= $rowRequeriemento['titulo'] ?>" name="titulo">
                    </div>

                    <div class="col-md-4">
                        <label for="tipo" class="form-label"><strong>Tipo:</strong></label>
                        <input readonly type="text" class="form-control" id="tipo" value="<?= $rowRequeriemento['tipo'] ?>" name="tipo">
                    </div>

                    <div class="col-md-8">
                        <label for="bairro" class="form-label"><strong>Situação: </strong></label>
                        <input readonly type="text" class="form-control" id="bairro" name="bairro" value="<?= $rowRequeriemento['situacao'] ?>">
                    </div>

                    <div class="col-md-4">
                        <label for="logradouro" class="form-label"><strong>Data: </strong></label>
                        <input readonly type="text" class="form-control" id="logradouro" name="logradouro" value="<?= $rowRequeriemento['data'] ?>">
                    </div>

                    <div class="col-md-8">
                        <label for="cidade" class="form-label"><strong>Cidade: </strong></label>
                        <input readonly type="text" class="form-control" id="cidade" name="cidade" value="<?= $rowRequeriemento['cidade'] ?>">
                    </div>

                    <div class="col-md-4">
                        <label for="cep" class="form-label"><strong>CEP: </strong></label>
                        <input readonly type="text" class="form-control" id="cep" name="cep" value="<?= $rowRequeriemento['cep'] ?>">
                    </div>

                    <div class="col-md-6">
                        <label for="bairro" class="form-label"><strong>Bairro: </strong></label>
                        <input readonly type="text" class="form-control" id="bairro" name="bairro" value="<?= $rowRequeriemento['bairro'] ?>">
                    </div>

                    <div class="col-md-6">
                        <label for="logradouro" class="form-label"><strong>Logradouro: </strong></label>
                        <input readonly type="text" class="form-control" id="logradouro" name="logradouro" value="<?= $rowRequeriemento['logradouro'] ?>">
                    </div>

                    <?php
                    if ($cont >= 1) {
                    ?>
                        <div class="col-md-12 mt-4">
                            <button type="button" class="d-block mx-auto w-25 btn btn-primary rounded-pill px-3 btn-lg" data-bs-toggle="modal" data-bs-target="#exampleModalFullscreen">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-image-fill" viewBox="0 0 16 16">
                                    <path d="M.002 3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-12a2 2 0 0 1-2-2V3zm1 9v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V9.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12zm5-6.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0z" />
                                </svg>
                                <br>
                                Imagem anexada
                            </button>
                        </div>

                        <div class="modal fade m-0 ps-0" id="exampleModalFullscreen" tabindex="-1" aria-labelledby="exampleModalFullscreenLabel" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-fullscreen">
                                <div class="modal-content">
                                    <div class="modal-header py-1">
                                        <h3 class="d-block mx-auto cor_tema"><?= $dados["nome"] ?></h3>
                                        <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body d-flex justify-content-center align-items-center">
                                        <img src="mostrar-imagem.php" alt="Imagem: <?= $dados["nome"] ?>" class="h-100">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>

                    <div class="col-12">
                        <label for="descricao" class="form-label"><strong>Descrição: </strong></label>
                        <textarea readonly class="form-control" id="descricao" style="height: 150px" name="descricao"><?= $rowRequeriemento['descricao'] ?></textarea>
                    </div>

                    <?php
                    if (isset($rowRequeriemento['resposta'])) {
                    ?>

                        <div class="col-12 border p-4 rounded-5 mt-5">
                            <?php
                            if (isset($rowRequeriemento['id_administrador'])) {
                            ?>
                                <h3 class="mb-3">Administrador: <a class="cor_tema link-underline link-underline-opacity-0" href="visualizar-administrador.php?id=<?= $rowRequeriemento['id_administrador'] ?>"><?= $rowRequeriemento['administrador'] ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                                        </svg>
                                    </a>
                                </h3>
                            <?php
                            }
                            ?>

                            <label for="situacao_label" class="form-label"><strong>Situação definida como: </strong>
                                <?php
                                if ($rowRequeriemento['situacao'] == "Pendente") {
                                ?> <strong class="text-secondary"><?= strtoupper($rowRequeriemento['situacao']) ?></strong>
                                <?php
                                } elseif ($rowRequeriemento['situacao'] == "Em andamento") {
                                ?> <strong class="text-primary"><?= strtoupper($rowRequeriemento['situacao']) ?></strong>
                                <?php
                                } elseif ($rowRequeriemento['situacao'] == "Informações incompletas") {
                                ?> <strong class="text-warning"><?= strtoupper($rowRequeriemento['situacao']) ?></strong>
                                <?php
                                } elseif ($rowRequeriemento['situacao'] == "Concluído") {
                                ?> <strong class="text-success"><?= strtoupper($rowRequeriemento['situacao']) ?></strong>
                                <?php
                                } elseif ($rowRequeriemento['situacao'] == "Recusado") {
                                ?> <strong class="text-danger"><?= strtoupper($rowRequeriemento['situacao']) ?></strong>
                                <?php
                                }
                                ?>
                            </label>
                            <br>
                            <label for="resposta" class="form-label"><strong>Resposta: </strong></label>
                            <textarea readonly class="form-control" id="resposta" style="height: 150px" name="resposta"><?= $rowRequeriemento['resposta'] ?></textarea>
                        </div>
                    <?php
                    }
                    ?>

                    <div class="mt-4 col-12 row">
                        <div class="col-md-6 mb-3">
                            <a class="w-100 btn btn-secondary rounded-pill px-3 btn-lg" href="historico.php">Voltar ao histórico</a>
                        </div>
                        <div class="col-md-6">
                            <form action="editar-requerimento.php" method="GET" class="form my-auto">
                                <button class="w-100 btn btn-warning rounded-pill px-3 btn-lg" type="submit" value="<?= $id_requerimento ?>" name="editar">
                                    Alterar informações
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </main>
</div>

<?php
require 'footer.php';
require 'js.php';
?>
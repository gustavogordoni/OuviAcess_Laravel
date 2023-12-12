<?php
include 'header.php';

$id_requerimento = filter_input(INPUT_GET, "editar", FILTER_SANITIZE_NUMBER_INT);

if (autenticado()) {
    $id_usuario = $_SESSION["id_usuario"];
} elseif (!autenticado()) {
    $_SESSION["realizar_login"] = "editar-requerimento";
    redireciona("login.php");
    die();
}

if (empty($id_requerimento)) {
    $_SESSION["crud_requerimento"] = "editar_id";
    include 'mensagens.php';
    die();
}

if (!is_numeric($id_requerimento) || stripos($id_requerimento, "-")) {
    $_SESSION["id_not_numeric"] = "requerimento";   
    redireciona("historico.php");
    die();
}

require '../database/conexao.php';

$sql = "SELECT titulo, tipo, situacao, data, descricao, cep, cidade, bairro, logradouro FROM requerimento WHERE id_requerimento = ? AND id_usuario = ?";

$stmt = $conn->prepare($sql);
$result = $stmt->execute([$id_requerimento, $id_usuario]);
$rowRequeriemento = $stmt->fetch();
$cont =  $stmt->rowCount();

if ($cont == 0) {
    $_SESSION["id_requerimento_inexistente"] = true;
    include 'mensagens.php';
    die();
}

if (isset($_SESSION["error_requerimento"]) || isset($_SESSION["caracteres_requerimento"])) {
    include 'mensagens.php';
}

include 'navbar.php';
?>

<div class="container mx-auto">
    <main>
        <div class="py-3 text-center mt-4">
            <strong>
                <h2>Altere as informações desejadas</h2>
            </strong>
        </div>

        <div class="row">
            <div class="col-11 mx-auto mb-4">
                <form class="needs-validation" action="alterar-requerimento.php" method="POST" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <input type="hidden" name="alterar" required id="alterar" value="<?= $id_requerimento ?>">

                            <label for="titulo" class="form-label" required id="label_titulo"><strong>Título do requerimento: </strong></label>
                            <input type="text" class="form-control" required id="titulo" placeholder="Ex: Falta de rampas de acesso" name="titulo" value="<?= $rowRequeriemento['titulo'] ?>" pattern="[A-Za-zÀ-ÿ\s]+" title="Insira um título que contenha apenas letras. Nenhum outro tipo de caracter será válido" maxLength="150">
                            <div class="invalid-feedback">
                                Informe um título formado apenas por letras, tendo como mínimo de 10 caracteres.
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="tipo" class="form-label"><strong>Tipo:</strong></label>
                            <select class="form-select" required id="tipo" name="tipo">
                                <?php
                                if ($rowRequeriemento['tipo'] == "Denúncia") { ?>
                                    <option value="Denúncia">Denúncia</option>
                                    <option value="Sugestão">Sugestão</option>
                                <?php
                                } elseif ($rowRequeriemento['tipo'] == "Sugestão") { ?>
                                    <option value="Sugestão">Sugestão</option>
                                    <option value="Denúncia">Denúncia</option>
                                <?php
                                } else { ?>
                                    <option value="">Escolha uma opção</option>
                                    <option value="Denúncia">Denúncia</option>
                                    <option value="Sugestão">Sugestão</option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-8">
                            <label for="cidade" class="form-label"><strong>Cidade: </strong></label>
                            <input type="text" class="form-control" required id="cidade" placeholder="Ex: Votuporanga" name="cidade" value="<?= $rowRequeriemento['cidade'] ?>" pattern="[A-Za-zÀ-ÿ\s]+" maxLength="150">
                            <div class="invalid-feedback">
                                Será aceito apenas letras, tendo como mínimo 3 caracteres.
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="cep" class="form-label"><strong>CEP: </strong></label>
                            <input type="text" class="form-control" required id="cep" name="cep" value="<?= $rowRequeriemento['cep'] ?>" title="Digite o CEP no formato XX.XXX-XXX" placeholder="XX.XXX-XXX" pattern="\d{2}\.\d{3}-\d{3}" maxLength="10">
                            <div class="invalid-feedback">
                                Informe o CEP no formato XX.XXX-XXX
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="bairro" class="form-label"><strong>Bairro: </strong></label>
                            <input type="text" class="form-control" required id="bairro" placeholder="Ex: Centro" name="bairro" value="<?= $rowRequeriemento['bairro'] ?>" pattern="[A-Za-zÀ-ÿ0-9\s]+" maxLength="150">
                            <div class="invalid-feedback">
                                Informe um bairro válido
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="logradouro" class="form-label"><strong>Logradouro: </strong></label>
                            <input type="text" class="form-control" required id="logradouro" placeholder="Ex: Rua Amazonas" name="logradouro" value="<?= $rowRequeriemento['logradouro'] ?>" pattern="[A-Za-zÀ-ÿ0-9\s]+" maxLength="150">
                            <div class="invalid-feedback">
                                Informe uma logradouro válida
                            </div>
                        </div>

                        <?php
                        $sql = "SELECT dados_arquivo, nome FROM arquivo a INNER JOIN requerimento r
                        ON a.id_requerimento = r.id_requerimento
                        WHERE a.id_requerimento = ? AND r.id_usuario = ?";

                        $stmt = $conn->prepare($sql);
                        $stmt->execute([$id_requerimento, $id_usuario]);
                        $cont = $stmt->rowCount();

                        if ($cont >= 1) {
                        ?>
                            <div class="col-12 input-group mt-4">
                                <label class="input-group-text px-5" for="arquivo"><strong>Foto do local:</strong></label>
                                <input type="file" class="form-control" id="arquivo" accept="image/*" name="arquivo">
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="col-12 input-group mt-4">
                                <label class="input-group-text px-5" for="arquivo"><strong>Adicionar foto do local:</strong></label>
                                <input type="file" class="form-control" id="arquivo" accept="image/*" name="arquivo">
                            </div>
                        <?php
                        }
                        ?>

                        <div class="col-12">
                            <label for="descricao" class="form-label"><strong>Descrição: </strong></label>
                            <textarea class="form-control" placeholder="Insira uma descrição detalhada sobre o ambiente em discussão" required id="descricao" style="height: 130px" name="descricao" maxLength="2000"><?= $rowRequeriemento['descricao'] ?></textarea>
                            <div class="invalid-feedback">
                                Insira uma descrição, com no mínimo 50 caracteres, sobre o ambiente em discussão
                            </div>
                        </div>


                        <div class="mt-5 col-12 row">
                            <div class="col-md-6 mb-3">
                                <a class="w-100 btn btn-secondary rounded-pill px-3 btn-lg" href="historico.php">Voltar ao histórico</a>
                            </div>
                            <div class="col-md-6">
                                <button class="w-100 btn btn-primary btn-lg rounded-pill px-3" type="submit">Enviar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>


<script>
    const tituloInput = document.getElementById("titulo");
    const labelTitulo = document.querySelector("label[for='titulo']");

    tituloInput.addEventListener("keydown", function(event) {
        if (event.key >= '0' && event.key <= '9') {
            event.preventDefault();
        }
    });

    tituloInput.addEventListener("input", function() {
        const inputValue = tituloInput.value.replace(/\s+/g, "");
        const minLength = 10;
        const Regex = /^[A-Za-zÀ-ÿ\s]+$/;

        if (inputValue.length >= minLength && Regex.test(inputValue)) {
            tituloInput.setCustomValidity("");
            tituloInput.classList.remove("is-invalid");
            labelTitulo.classList.remove("text-danger");
        } else {
            tituloInput.classList.add("is-invalid");
            labelTitulo.classList.add("text-danger");

            if (inputValue.length < minLength) {
                tituloInput.setCustomValidity(`Informe um título com pelo menos ${minLength} caracteres, sem contar os espaços.`);
            } else if (!Regex.test(inputValue)) {
                tituloInput.setCustomValidity("O título deve conter apenas letras e espaços.");
            }
        }
    });

    const tipo = document.getElementById("tipo");
    const labelTipo = document.querySelector("label[for='tipo']");

    tipo.addEventListener("blur", function() {
        if (tipo.value !== "") {
            tipo.classList.remove("is-invalid");
            labelTipo.classList.remove("text-danger");
        } else {
            tipo.classList.add("is-invalid");
            labelTipo.classList.add("text-danger");
        }
    });

    const cidadeInput = document.getElementById("cidade");
    const labelCidade = document.querySelector("label[for='cidade']");

    cidadeInput.addEventListener("keydown", function(event) {
        if (event.key >= '0' && event.key <= '9') {
            event.preventDefault();
        }
    });

    cidadeInput.addEventListener("input", function() {
        const inputValue = cidadeInput.value.replace(/\s+/g, "");
        const minLength = 3;
        const Regex = /^[A-Za-zÀ-ÿ\s]+$/;

        if (inputValue.length >= minLength && Regex.test(inputValue)) {
            cidadeInput.setCustomValidity("");
            cidadeInput.classList.remove("is-invalid");
            labelCidade.classList.remove("text-danger");
        } else {
            cidadeInput.classList.add("is-invalid");
            labelCidade.classList.add("text-danger");

            if (inputValue.length < minLength) {
                cidadeInput.setCustomValidity(`Informe uma cidade com pelo menos ${minLength} letras.`);
            } else if (!Regex.test(inputValue)) {
                cidadeInput.setCustomValidity("Apenas serão aceitas letras.");
            }
        }
    });

    const cepInput = document.getElementById("cep");
    const labelCep = document.querySelector("label[for='cep']");

    cepInput.addEventListener("input", function() {
        const inputValue = cepInput.value.replace(/\D/g, ""); // Remove todos os caracteres não numéricos
        const maxLength = 8;
        const truncatedValue = inputValue.slice(0, );
        const formattedValue = formatCEP(truncatedValue);
        cepInput.value = formattedValue;

        validateCep(inputValue);
    });

    cepInput.addEventListener("blur", function() {
        const inputValue = cepInput.value.replace(/\D/g, ""); // Remove todos os caracteres não numéricos
        validateCep(inputValue);
    });

    function validateCep(value) {
        const cepRegex = /^\d{8}$/;
        const isValid = cepRegex.test(value);

        if (isValid) {
            cepInput.classList.remove("is-invalid");
            labelCep.classList.remove("text-danger");
        } else {
            cepInput.classList.add("is-invalid");
            labelCep.classList.add("text-danger");
        }
    }

    function formatCEP(value) {
        const regex = /^(\d{2})(\d{3})(\d{3})$/;
        const formattedValue = value.replace(regex, "$1.$2-$3");
        return formattedValue;
    }

    const bairroInput = document.getElementById("bairro");
    const labelBairro = document.querySelector("label[for='bairro']");

    bairroInput.addEventListener("input", function() {
        const inputValue = bairroInput.value.replace(/\s+/g, "");
        const minLength = 3;
        const Regex = /^[A-Za-zÀ-ÿ0-9\s]+$/;

        if (inputValue.length >= minLength && Regex.test(inputValue)) {
            bairroInput.setCustomValidity("");
            bairroInput.classList.remove("is-invalid");
            labelBairro.classList.remove("text-danger");
        } else {
            bairroInput.classList.add("is-invalid");
            labelBairro.classList.add("text-danger");

            if (inputValue.length < minLength) {
                bairroInput.setCustomValidity(`Informe um bairro com pelo menos ${minLength} caracteres.`);
            } else if (!Regex.test(inputValue)) {
                bairroInput.setCustomValidity("Apenas serão aceitas letras e números.");
            }
        }
    });

    const logradouroInput = document.getElementById("logradouro");
    const labelLogradouro = document.querySelector("label[for='logradouro']");

    logradouroInput.addEventListener("input", function() {
        const inputValue = logradouroInput.value.replace(/\s+/g, "");
        const minLength = 2;
        const Regex = /^[A-Za-zÀ-ÿ0-9\s]+$/;

        if (inputValue.length >= minLength && Regex.test(inputValue)) {
            logradouroInput.setCustomValidity("");
            logradouroInput.classList.remove("is-invalid");
            labelLogradouro.classList.remove("text-danger");
        } else {
            logradouroInput.classList.add("is-invalid");
            labelLogradouro.classList.add("text-danger");

            if (inputValue.length < minLength) {
                logradouroInput.setCustomValidity(`Informe uma logradouro com pelo menos ${minLength} caracteres.`);
            } else if (!Regex.test(inputValue)) {
                logradouroInput.setCustomValidity("Apenas serão aceitas letras e números.");
            }
        }
    });

    const descricaoInput = document.getElementById("descricao");
    const labelDescricao = document.querySelector("label[for='descricao']");
    const descricaoErrorMessage = descricaoInput.nextElementSibling;

    const minDescricaoLength = 50;

    descricaoInput.addEventListener("input", function() {
        const inputValue = descricaoInput.value.trim();
        if (inputValue.length < minDescricaoLength) {
            descricaoInput.classList.add("is-invalid");
            labelDescricao.classList.add("text-danger"); // Adicione a classe text-danger
            descricaoErrorMessage.style.display = "block";
        } else {
            descricaoInput.classList.remove("is-invalid");
            labelDescricao.classList.remove("text-danger"); // Remova a classe text-danger
            descricaoErrorMessage.style.display = "none";
        }
    });
</script>

<?php
include 'mensagens.php';
include 'footer.php';
include 'js.php';
?>
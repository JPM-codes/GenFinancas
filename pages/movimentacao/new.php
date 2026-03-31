<?php
$titulo_pagina = "Inserindo Tipo de Despesa";

require_once __DIR__ . '/../../config/database.php';

include '../../templates/header.php';

include '../../templates/navbar.php';


// Inserindo um novo tipo de despesa
if (isset($_POST['add'])) {
    $stmt = $pdo->prepare("INSERT INTO tipo_despesa (descricao) VALUES (?)");
    $stmt->execute([$_POST['descricao']]);
    header("Location: index.php");
}
?>
<div class="container py-4">
    <h3 class="mb-4">Inserindo uma nova movimentação</h3>
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <form>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Tipo de Movimentação</label>
                            <select class="form-select" name="tipo_movimentacao" id="tipo_movimentacao">
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Tipo de Despesa</label>
                            <select class="form-select" name="tipo_despesa" id="tipo_despesa">
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Forma de Pagamento</label>
                            <select class="form-select" name="forma_pagamento" id="forma_pagamento">
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-2">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Data</label>
                            <input type="date" class="form-control" name="data_movimentacao" id="data_movimentacao">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Valor</label>
                            <input type="text" class="form-control" name="valor_movimentacao" id="valor_movimentacao" placeholder="0,00">
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold">Observação de lançamento</label>
                            <select class="form-select" name="observacao_movimentacao" id="observacao_movimentacao">
                            </select>
                        </div>
                    </div>
                </div>


                <button type="submit" class="btn btn-success px-5">
                    Salvar
                </button>
            </form>
        </div>
    </div>
</div>

<?php
include '../../templates/footer.php';
?>
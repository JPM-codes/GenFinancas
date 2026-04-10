<?php
$titulo_pagina = "Inserindo Tipo de Despesa";

require_once __DIR__ . '/../../config/database.php';

include '../../templates/header.php';

include '../../templates/navbar.php';

$tipo_despesa = $pdo->query
('SELECT id_tipo_despesa, descricao FROM tipo_despesa
     WHERE ind_excluido = 0 
     ORDER BY descricao')
    ->fetchAll();

$tipo_pagamento = $pdo->query
('SELECT id_forma_pagamento, descricao FROM forma_pagamento
     WHERE ind_excluido = 0 
     ORDER BY descricao')
    ->fetchAll();

// Inserindo um novo tipo de despesa
if (isset($_POST['add'])) {
    $stmt = $pdo->prepare("INSERT INTO movimentacao (id_tipo_despesa, id_forma_pagamento, tipo_movimentacao, data,valor,observacao) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute(
        [
            $_POST['tipo_despesa'],
            $_POST['forma_pagamento'],
            $_POST['tipo_movimentacao'],
            $_POST['data'],
            $_POST['valor'],
            $_POST['observacao']
        ]
    );
    header("Location: index.php");
}
?>
<div class="container py-4">
    <h3 class="mb-4">Inserindo uma nova movimentação</h3>
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <form method="POST">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Tipo de Movimentação</label>
                            <select class="form-select" name="tipo_movimentacao" id="tipo_movimentacao">
                                <option value="entrada">Entrada</option>
                                <option value="saida">Saída</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Tipo de Despesa</label>
                            <select class="form-select" name="tipo_despesa" id="tipo_despesa">
                                <option value="">Selecione...</option>
                                <?php foreach ($tipo_despesa as $t): ?>
                                    <option value="<?= $t['id_tipo_despesa'] ?>"><?= $t['descricao'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Forma de Pagamento</label>
                            <select class="form-select" name="forma_pagamento" id="forma_pagamento">
                                <option value="">Selecione...</option>
                                <?php foreach ($tipo_pagamento as $t): ?>
                                    <option value="<?= $t['id_forma_pagamento'] ?>"><?= $t['descricao'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-2">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Data</label>
                            <input type="date" class="form-control" name="data" id="data_movimentacao">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Valor</label>
                            <input type="text" class="form-control" name="valor" id="valor_movimentacao"
                                placeholder="0,00">
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold">Observação de lançamento</label>
                            <input type="text" class="form-control" name="observacao" id="observacao_movimentacao">
                        </div>
                    </div>
                </div>


                <button type="submit" name='add' class="btn btn-success px-5">
                    Salvar
                </button>
            </form>
        </div>
    </div>
</div>

<?php
include '../../templates/footer.php';
?>
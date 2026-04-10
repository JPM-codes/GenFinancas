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

$id = $_GET['id_movimentacao'];
$stmt = $pdo->prepare('
        SELECT id_movimentacao, id_tipo_despesa, id_forma_pagamento, tipo_movimentacao, data, valor, observacao
        FROM movimentacao
        WHERE id_movimentacao = ?
    ');
$stmt->execute([$id]);
$movimentacao = $stmt->fetch();

if (!$movimentacao) {
    echo "Movimentação não encontrada.";
    exit;
}

// Inserindo um novo tipo de despesa
if (isset($_POST['add'])) {

    

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
                                <option value="e" <?php if ($movimentacao['tipo_movimentacao'] === 'e')
                                    echo 'selected'; ?>>Entrada</option>
                                <option value="s" <?php if ($movimentacao['tipo_movimentacao'] === 's')
                                    echo 'selected'; ?>>Saída</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Tipo de Despesa</label>
                            <select class="form-select" name="tipo_despesa" id="tipo_despesa">
                                <option value="">Selecione...</option>
                                <?php foreach ($tipo_despesa as $t): ?>
                                    <option value="<?= $t['id_tipo_despesa'] ?>" 
                                    <?php if ($movimentacao['id_tipo_despesa'] == $t['id_tipo_despesa']) echo 'selected'; ?>>
                                    <?= $t['descricao'] ?></option>
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
                                    <option value="<?= $t['id_forma_pagamento'] ?>"
                                    <?php if ($movimentacao['id_forma_pagamento'] == $t['id_forma_pagamento']) echo 'selected'; ?>>
                                    <?= $t['descricao'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-2">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Data</label>
                            <input type="date" class="form-control" name="data" id="data_movimentacao" value="<?= $movimentacao['data'] ?>">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Valor</label>
                            <input type="text" class="form-control" name="valor" id="valor_movimentacao"
                                placeholder="0,00" value="<?= $movimentacao['valor'] ?>">
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold">Observação de lançamento</label>
                            <input type="text" class="form-control" name="observacao" id="observacao_movimentacao" value="<?= $movimentacao['observacao'] ?>">
                        </div>
                    </div>
                </div>


                <button type="submit" name='edit' class="btn btn-success px-5">
                    Editar
                </button>
            </form>
        </div>
    </div>
</div>

<?php
include '../../templates/footer.php';
?>
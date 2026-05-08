<?php
$titulo_pagina = "Nova Movimentação";

require_once __DIR__ . '/../../config/database.php';

include '../../templates/header.php';
include '../../templates/navbar.php';

$tipo_despesa = $pdo->query('
    SELECT id_tipo_despesa, descricao 
    FROM tipo_despesa
    WHERE ind_excluido = 0 
    ORDER BY descricao
')->fetchAll();

$tipo_pagamento = $pdo->query('
    SELECT id_forma_pagamento, descricao 
    FROM forma_pagamento
    WHERE ind_excluido = 0 
    ORDER BY descricao
')->fetchAll();

// Inserindo uma nova movimentação
if (isset($_POST['add'])) {
    $stmt = $pdo->prepare("INSERT INTO movimentacao (id_tipo_despesa, id_forma_pagamento, tipo_movimentacao, data, valor, observacao) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['tipo_despesa'],
        $_POST['forma_pagamento'],
        $_POST['tipo_movimentacao'],
        $_POST['data'],
        str_replace(',', '.', $_POST['valor']), // Garante que o valor vá pro banco com ponto decimal
        $_POST['observacao']
    ]);
    header("Location: index.php");
    exit; // Boas práticas: interromper o script após o redirecionamento
}
?>

<!-- Inclusão de ícones do Bootstrap -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<div class="container mt-4 mt-md-5 mb-5">

    <!-- TÍTULO E BOTÃO VOLTAR -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <h2 class="fw-bold text-dark mb-0 fs-4 fs-md-3">
            <i class="bi bi-plus-circle me-2 text-primary"></i> Lançar Movimentação
        </h2>
        <div class="d-grid d-md-block">
            <a href="index.php" class="btn btn-outline-secondary shadow-sm rounded-pill py-2 px-md-4">
                <i class="bi bi-arrow-left me-1"></i> Voltar
            </a>
        </div>
    </div>

    <!-- CARD DO FORMULÁRIO -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-4 p-md-5">
            
            <form method="POST">
                
                <!-- PRIMEIRA LINHA -->
                <div class="row g-3 g-md-4 mb-3 mb-md-4">
                    
                    <div class="col-12 col-md-4">
                        <label for="tipo_movimentacao" class="form-label fw-medium text-dark">Tipo de Movimentação</label>
                        <select class="form-select form-select-lg bg-light" name="tipo_movimentacao" id="tipo_movimentacao" required>
                            <option value="">Selecione...</option>
                            <!-- Valores alterados para 'e' e 's' para bater com a lógica do Dashboard -->
                            <option value="e">Entrada (Receita)</option>
                            <option value="s">Saída (Despesa)</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="tipo_despesa" class="form-label fw-medium text-dark">Categoria</label>
                        <select class="form-select form-select-lg bg-light" name="tipo_despesa" id="tipo_despesa" required>
                            <option value="">Selecione...</option>
                            <?php foreach ($tipo_despesa as $t): ?>
                                <option value="<?= $t['id_tipo_despesa'] ?>"><?= htmlspecialchars($t['descricao']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="forma_pagamento" class="form-label fw-medium text-dark">Forma de Pagamento</label>
                        <select class="form-select form-select-lg bg-light" name="forma_pagamento" id="forma_pagamento" required>
                            <option value="">Selecione...</option>
                            <?php foreach ($tipo_pagamento as $t): ?>
                                <option value="<?= $t['id_forma_pagamento'] ?>"><?= htmlspecialchars($t['descricao']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>

                <!-- SEGUNDA LINHA -->
                <div class="row g-3 g-md-4 mb-4">
                    
                    <div class="col-12 col-sm-6 col-md-3">
                        <label for="data_movimentacao" class="form-label fw-medium text-dark">Data</label>
                        <input type="date" class="form-control form-control-lg bg-light" name="data" id="data_movimentacao" value="<?= date('Y-m-d') ?>" required>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <label for="valor_movimentacao" class="form-label fw-medium text-dark">Valor (R$)</label>
                        <input type="number" step="0.01" min="0" class="form-control form-control-lg bg-light" name="valor" id="valor_movimentacao" placeholder="0.00" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="observacao_movimentacao" class="form-label fw-medium text-dark">Observação (Opcional)</label>
                        <input type="text" class="form-control form-control-lg bg-light" name="observacao" id="observacao_movimentacao" placeholder="Ex: Compra no mercado...">
                    </div>

                </div>

                <hr class="text-muted my-4">

                <!-- BOTÕES DE AÇÃO -->
                <div class="d-grid d-md-flex justify-content-md-end gap-2">
                    <a href="index.php" class="btn btn-light px-4 py-2 text-secondary fw-medium">
                        Cancelar
                    </a>
                    <button type="submit" name="add" class="btn btn-success px-5 py-2 shadow-sm fw-medium">
                        <i class="bi bi-check-lg me-1"></i> Salvar Lançamento
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<?php
include '../../templates/footer.php';
?>
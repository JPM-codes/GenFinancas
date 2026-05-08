<?php
require_once __DIR__ . '/../../config/database.php';

include '../../templates/header.php';
include '../../templates/navbar.php';

$movimentacao = $pdo->query('
    SELECT 
        m.id_movimentacao, 
        m.id_forma_pagamento,
        f.descricao as desc_forma_pagamento,
        m.id_tipo_despesa, 
        t.descricao as desc_tipo_despesa,
        m.tipo_movimentacao, 
        m.data, 
        m.valor, 
        m.observacao
    FROM movimentacao m

    INNER JOIN forma_pagamento f on m.id_forma_pagamento = f.id_forma_pagamento
    INNER JOIN tipo_despesa t on m.id_tipo_despesa = t.id_tipo_despesa

    ORDER BY m.data DESC
')->fetchAll();

if (isset($_POST['excluir'])) {
    $stmt = $pdo->prepare('DELETE FROM movimentacao WHERE id_movimentacao = :id');
    $stmt->execute([
        ':id' => $_POST['excluir']
    ]);

    header('Location: index.php');
    exit;
}

?>

<!-- Inclusão de ícones do Bootstrap (Opcional, caso não esteja no seu header) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<div class="container mt-4 mt-md-5 mb-5">

    <!-- TÍTULO E BOTÃO NOVA MOVIMENTAÇÃO (Mobile-First: Empilhados no celular) -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <h2 class="fw-bold text-dark mb-0 fs-4 fs-md-3">
            <i class="bi bi-list-columns-reverse me-2 text-primary"></i> Todas as Movimentações
        </h2>
        <div class="d-grid d-md-block">
            <!-- Assumindo que o arquivo de criação está na mesma pasta -->
            <a href="create.php" class="btn btn-success shadow-sm rounded-pill py-2 px-md-4">
                <i class="bi bi-plus-circle me-1"></i> Nova Movimentação
            </a>
        </div>
    </div>

    <!-- CARD DA TABELA -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="min-width: 400px;">
                    <thead class="table-light text-muted">
                        <tr>
                            <th scope="col" class="ps-3 ps-md-4">Data</th>
                            <th scope="col">Categoria</th>
                            <th scope="col" class="d-none d-sm-table-cell">Pagamento</th>
                            <th scope="col" class="d-none d-lg-table-cell">Observação</th>
                            <th scope="col" class="text-end">Valor</th>
                            <th scope="col" class="text-end pe-3 pe-md-4" style="width: 120px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($movimentacao)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    Nenhuma movimentação encontrada.
                                </td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach ($movimentacao as $m): ?>
                            <tr>
                                <!-- DATA -->
                                <td class="ps-3 ps-md-4 text-muted" style="white-space: nowrap;">
                                    <?= DateTime::createFromFormat('Y-m-d', $m['data'])->format('d/m/Y') ?>
                                </td>

                                <!-- CATEGORIA -->
                                <td class="fw-medium text-dark text-truncate" style="max-width: 120px;">
                                    <?= htmlspecialchars($m['desc_tipo_despesa']) ?>
                                </td>

                                <!-- PAGAMENTO (Oculto no celular, mostra no tablet pra cima) -->
                                <td class="d-none d-sm-table-cell">
                                    <span class="badge bg-light text-dark border fw-normal">
                                        <?= htmlspecialchars($m['desc_forma_pagamento']) ?>
                                    </span>
                                </td>

                                <!-- OBSERVAÇÃO (Oculto até monitores grandes) -->
                                <td class="text-muted d-none d-lg-table-cell text-truncate" style="max-width: 200px;" title="<?= htmlspecialchars($m['observacao']) ?>">
                                    <?= htmlspecialchars($m['observacao'] ?: '-') ?>
                                </td>

                                <!-- VALOR FORMATADO COM BADGE -->
                                <td class="text-end">
                                    <?php if ($m['tipo_movimentacao'] == 'e'): ?>
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2 py-1 px-md-3 py-md-2" style="white-space: nowrap;">
                                            <i class="bi bi-arrow-up-circle me-1 d-none d-sm-inline"></i>
                                            + R$ <?= number_format((float) $m['valor'], 2, ',', '.') ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-2 py-1 px-md-3 py-md-2" style="white-space: nowrap;">
                                            <i class="bi bi-arrow-down-circle me-1 d-none d-sm-inline"></i>
                                            - R$ <?= number_format((float) $m['valor'], 2, ',', '.') ?>
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <!-- AÇÕES -->
                                <td class="text-end pe-3 pe-md-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <!-- Editar -->
                                        <a href="edit.php?id_movimentacao=<?= $m['id_movimentacao'] ?>" class="btn btn-outline-primary btn-sm px-2 py-1" title="Editar">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <!-- Excluir -->
                                        <form method="post" class="d-inline m-0" onsubmit="return confirm('ATENÇÃO: Tem certeza que deseja excluir esta movimentação de R$ <?= number_format((float) $m['valor'], 2, ',', '.') ?> permanentemente?');">
                                            <input type="hidden" name="excluir" value="<?= $m['id_movimentacao'] ?>">
                                            <button type="submit" class="btn btn-outline-danger btn-sm px-2 py-1" title="Excluir">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php
include '../../templates/footer.php';
?>
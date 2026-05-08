<?php

require_once __DIR__ . '/../../config/database.php';

include '../../templates/header.php';
include '../../templates/navbar.php';

/*
|--------------------------------------------------------------------------
| CARDS PRINCIPAIS
|--------------------------------------------------------------------------
*/

$sqlResumo = "
SELECT 
    SUM(
        CASE 
            WHEN tipo_movimentacao = 'e'
            THEN valor
            ELSE 0
        END
    ) AS entradas,

    SUM(
        CASE 
            WHEN tipo_movimentacao = 's'
            THEN valor
            ELSE 0
        END
    ) AS saidas,

    COUNT(*) AS total_movimentacoes,

    MAX(
        CASE
            WHEN tipo_movimentacao = 's'
            THEN valor
            ELSE 0
        END
    ) AS maior_despesa

FROM movimentacao
";

$stmtResumo = $pdo->query($sqlResumo);
$resumo = $stmtResumo->fetch(PDO::FETCH_ASSOC);

$entradas = $resumo['entradas'] ?? 0;
$saidas = $resumo['saidas'] ?? 0;
$saldo = $entradas - $saidas;

$totalMovimentacoes = $resumo['total_movimentacoes'] ?? 0;
$maiorDespesa = $resumo['maior_despesa'] ?? 0;

/*
|--------------------------------------------------------------------------
| ÚLTIMAS MOVIMENTAÇÕES
|--------------------------------------------------------------------------
*/

$sqlMovimentacoes = "
SELECT
    m.id_movimentacao,
    m.data,
    m.valor,
    m.tipo_movimentacao,
    m.observacao,

    td.DESCRICAO AS categoria,
    fp.descricao AS forma_pagamento

FROM movimentacao m

INNER JOIN tipo_despesa td
ON td.ID_TIPO_DESPESA = m.id_tipo_despesa

INNER JOIN forma_pagamento fp
ON fp.id_forma_pagamento = m.id_forma_pagamento

ORDER BY m.data DESC

LIMIT 5
";

$stmtMov = $pdo->query($sqlMovimentacoes);
$movimentacoes = $stmtMov->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| GASTOS POR CATEGORIA
|--------------------------------------------------------------------------
*/

$sqlCategorias = "
SELECT
    td.DESCRICAO,
    SUM(m.valor) AS total

FROM movimentacao m

INNER JOIN tipo_despesa td
ON td.ID_TIPO_DESPESA = m.id_tipo_despesa

WHERE m.tipo_movimentacao = 's'

GROUP BY td.DESCRICAO

ORDER BY total DESC
";

$stmtCat = $pdo->query($sqlCategorias);
$categorias = $stmtCat->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- Inclusão de ícones do Bootstrap (Opcional) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<div class="container mt-4 mt-md-5">

    <!-- TÍTULO E BOTÃO (Mobile-First: Empilhados no celular, lado a lado no desktop) -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <h2 class="fw-bold text-dark mb-0 fs-4 fs-md-3">
            <i class="bi bi-pie-chart-fill me-2 text-primary"></i> Dashboard Financeiro
        </h2>
        <div class="d-grid d-md-block">
            <a href="../movimentacao/create.php" class="btn btn-success shadow-sm rounded-pill py-2 px-md-4">
                <i class="bi bi-plus-circle me-1"></i> Nova Movimentação
            </a>
        </div>
    </div>

    <!-- CARDS PRINCIPAIS (Mobile-First: 1 por linha no cel, 2 no tablet, 4 no monitor) -->
    <div class="row g-3 mb-4">

        <!-- ENTRADAS -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card shadow-sm border-0 border-start border-success border-4 h-100">
                <div class="card-body">
                    <h6 class="text-success fw-bold text-uppercase mb-1" style="font-size: 0.85rem;">
                        Entradas
                    </h6>
                    <h3 class="mb-0 fw-bold text-dark fs-4 fs-md-3">
                        R$ <?= number_format($entradas, 2, ',', '.') ?>
                    </h3>
                </div>
            </div>
        </div>

        <!-- SAÍDAS -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card shadow-sm border-0 border-start border-danger border-4 h-100">
                <div class="card-body">
                    <h6 class="text-danger fw-bold text-uppercase mb-1" style="font-size: 0.85rem;">
                        Saídas
                    </h6>
                    <h3 class="mb-0 fw-bold text-dark fs-4 fs-md-3">
                        R$ <?= number_format($saidas, 2, ',', '.') ?>
                    </h3>
                </div>
            </div>
        </div>

        <!-- SALDO -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card shadow-sm border-0 border-start border-<?= $saldo >= 0 ? 'primary' : 'warning' ?> border-4 h-100">
                <div class="card-body">
                    <h6 class="text-<?= $saldo >= 0 ? 'primary' : 'warning' ?> fw-bold text-uppercase mb-1" style="font-size: 0.85rem;">
                        Saldo Atual
                    </h6>
                    <h3 class="mb-0 fw-bold <?= $saldo >= 0 ? 'text-success' : 'text-danger' ?> fs-4 fs-md-3">
                        R$ <?= number_format($saldo, 2, ',', '.') ?>
                    </h3>
                </div>
            </div>
        </div>

        <!-- TOTAL MOVIMENTAÇÕES -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card shadow-sm border-0 border-start border-secondary border-4 h-100">
                <div class="card-body">
                    <h6 class="text-secondary fw-bold text-uppercase mb-1" style="font-size: 0.85rem;">
                        Movimentações
                    </h6>
                    <h3 class="mb-0 fw-bold text-dark fs-4 fs-md-3">
                        <?= $totalMovimentacoes ?>
                    </h3>
                </div>
            </div>
        </div>

    </div>

    <!-- LINHA 2: MAIOR DESPESA E STATUS -->
    <div class="row g-3 mb-4">
        <!-- MAIOR DESPESA -->
        <div class="col-12 col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex flex-column justify-content-center">
                    <h6 class="text-muted fw-bold text-uppercase mb-2" style="font-size: 0.85rem;">
                        <i class="bi bi-arrow-down-right-circle text-danger me-1"></i> Maior Despesa
                    </h6>
                    <h4 class="mb-0 fw-bold text-dark fs-5 fs-md-4">
                        R$ <?= number_format($maiorDespesa, 2, ',', '.') ?>
                    </h4>
                </div>
            </div>
        </div>

        <!-- ALERTA -->
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex flex-column justify-content-center">
                    <h6 class="text-muted fw-bold text-uppercase mb-2" style="font-size: 0.85rem;">
                        Status Financeiro
                    </h6>
                    <?php if($saldo > 0): ?>
                        <div class="alert alert-success mb-0 py-2 d-flex align-items-center fs-6">
                            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                            <div><strong>Parabéns!</strong> Seu saldo está positivo no momento.</div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-danger mb-0 py-2 d-flex align-items-center fs-6">
                            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                            <div><strong>Atenção!</strong> Seu saldo está negativo. Tente rever seus gastos.</div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        
        <!-- ÚLTIMAS MOVIMENTAÇÕES -->
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h5 class="fw-bold text-dark mb-0 fs-5">Últimas Movimentações</h5>
                </div>
                <div class="card-body p-0 mt-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="min-width: 400px;">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th class="ps-3 ps-md-4">Data</th>
                                    <th>Categoria</th>
                                    <!-- Oculta no mobile pequeno, mostra no tablet (sm) pra cima -->
                                    <th class="d-none d-sm-table-cell">Pagamento</th>
                                    <!-- Oculta no mobile e tablet, mostra só no desktop (lg) pra cima -->
                                    <th class="d-none d-lg-table-cell">Observação</th>
                                    <th class="text-end pe-3 pe-md-4">Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($movimentacoes as $m): ?>
                                    <tr>
                                        <td class="ps-3 ps-md-4 text-muted" style="font-size: 0.9rem;">
                                            <?= date('d/m', strtotime($m['data'])) ?> <!-- Ano abreviado para ganhar espaço -->
                                        </td>
                                        <td class="fw-medium text-truncate" style="max-width: 120px;">
                                            <?= $m['categoria'] ?>
                                        </td>
                                        <td class="d-none d-sm-table-cell">
                                            <span class="badge bg-light text-dark border">
                                                <?= $m['forma_pagamento'] ?>
                                            </span>
                                        </td>
                                        <td class="text-muted d-none d-lg-table-cell text-truncate" style="max-width: 150px;">
                                            <?= $m['observacao'] ?>
                                        </td>
                                        <td class="text-end pe-3 pe-md-4">
                                            <?php if($m['tipo_movimentacao'] == 'e'): ?>
                                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2 py-1 px-md-3 py-md-2">
                                                    + R$ <?= number_format($m['valor'], 2, ',', '.') ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-2 py-1 px-md-3 py-md-2">
                                                    - R$ <?= number_format($m['valor'], 2, ',', '.') ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- GASTOS POR CATEGORIA -->
        <div class="col-12 col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h5 class="fw-bold text-dark mb-0 fs-5">Gastos por Categoria</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush mt-2">
                        <?php foreach($categorias as $c): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 border-light">
                                <span class="fw-medium text-secondary text-truncate" style="max-width: 60%;">
                                    <i class="bi bi-tag me-2 text-muted"></i><?= $c['DESCRICAO'] ?>
                                </span>
                                <span class="fw-bold text-danger">
                                    R$ <?= number_format($c['total'], 2, ',', '.') ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                        <?php if(empty($categorias)): ?>
                            <li class="list-group-item px-0 text-center text-muted">
                                Nenhuma despesa registrada.
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>

    </div>

</div>

<?php
include '../../templates/footer.php';
?>
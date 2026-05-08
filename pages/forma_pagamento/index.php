<?php
require_once __DIR__ . '/../../config/database.php';

include '../../templates/header.php';
include '../../templates/navbar.php';

$forma_pagamento = $pdo->query('
    SELECT id_forma_pagamento, descricao 
    FROM forma_pagamento 
    WHERE ind_excluido = 0
    ORDER BY descricao
')->fetchAll();

if(isset($_POST['excluir'])) {
    $stmt = $pdo->prepare('
        UPDATE forma_pagamento 
        SET IND_EXCLUIDO = 1
        WHERE id_forma_pagamento = :id
    ');
    
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

    <!-- TÍTULO E BOTÃO (Mobile-First: Empilhados no celular, lado a lado no desktop) -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <h2 class="fw-bold text-dark mb-0 fs-4 fs-md-3">
            <i class="bi bi-credit-card-2-front-fill me-2 text-primary"></i> Formas de Pagamento
        </h2>
        <div class="d-grid d-md-block">
            <!-- Assumindo que você tenha ou criará um arquivo create.php -->
            <a href="create.php" class="btn btn-success shadow-sm rounded-pill py-2 px-md-4">
                <i class="bi bi-plus-circle me-1"></i> Nova Forma
            </a>
        </div>
    </div>

    <!-- CARD DA TABELA -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="min-width: 300px;">
                    <thead class="table-light text-muted">
                        <tr>
                            <!-- Oculta o ID no celular, mostra de tablet (sm) pra cima -->
                            <th scope="col" class="ps-3 ps-md-4 d-none d-sm-table-cell" style="width: 80px;">ID</th>
                            <th scope="col" class="ps-3 ps-sm-0">Descrição</th>
                            <th scope="col" class="text-end pe-3 pe-md-4" style="width: 150px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($forma_pagamento)): ?>
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">
                                    Nenhuma forma de pagamento encontrada.
                                </td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach($forma_pagamento as $t): ?>
                            <tr>
                                <td class="ps-3 ps-md-4 text-muted d-none d-sm-table-cell">
                                    <?= $t['id_forma_pagamento']?>
                                </td>
                                
                                <td class="fw-medium ps-3 ps-sm-0 text-dark">
                                    <?= htmlspecialchars($t['descricao']) ?>
                                </td>
                                
                                <td class="text-end pe-3 pe-md-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <!-- Botão Editar -->
                                        <a href="edit.php?id_forma_pagamento=<?= $t['id_forma_pagamento'] ?>" class="btn btn-outline-primary btn-sm px-2 py-1" title="Editar">
                                            <i class="bi bi-pencil-square"></i>
                                            <span class="d-none d-md-inline ms-1">Editar</span>
                                        </a>
                                        
                                        <!-- Botão Excluir com confirmação em JS -->
                                        <form method="post" class="d-inline m-0" onsubmit="return confirm('Tem certeza que deseja excluir a forma de pagamento \'<?= htmlspecialchars($t['descricao']) ?>\'?');">
                                            <input type="hidden" name="excluir" value="<?= $t['id_forma_pagamento'] ?>">
                                            <button type="submit" class="btn btn-outline-danger btn-sm px-2 py-1" title="Excluir">
                                                <i class="bi bi-trash"></i>
                                                <span class="d-none d-md-inline ms-1">Excluir</span>
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
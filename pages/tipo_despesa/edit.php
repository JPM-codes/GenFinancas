<?php
    $titulo_pagina = "Alterando o Tipo de Despesa";

    require_once __DIR__ . '/../../config/database.php';

    include '../../templates/header.php';
    include '../../templates/navbar.php';

    // Alterando o tipo de despesa
    $id = $_GET['id_tipo_despesa'];
    $stmt = $pdo->prepare('SELECT id_tipo_despesa, descricao FROM tipo_despesa WHERE id_tipo_despesa=?');

    $stmt->execute([$id]);
    $tipo_despesa = $stmt->fetch();

    if(!$tipo_despesa) {
        die('Tipo de despesa não encontrada!');
    }

    if (isset($_POST['edit'])) {
        $stmt = $pdo->prepare('UPDATE tipo_despesa SET descricao=? WHERE id_tipo_despesa=?');
        $stmt->execute([$_POST['descricao'], $id]);
        header('Location: index.php');
        exit; // É sempre bom adicionar exit logo após um header redirect
    }
?>

<!-- Inclusão de ícones do Bootstrap (Opcional) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<div class="container mt-4 mt-md-5 mb-5">

    <!-- TÍTULO E BOTÃO VOLTAR -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <h2 class="fw-bold text-dark mb-0 fs-4 fs-md-3">
            <i class="bi bi-pencil-square me-2 text-primary"></i> Editar Categoria
        </h2>
        <div class="d-grid d-md-block">
            <a href="index.php" class="btn btn-outline-secondary shadow-sm rounded-pill py-2 px-md-4">
                <i class="bi bi-arrow-left me-1"></i> Voltar
            </a>
        </div>
    </div>

    <!-- FORMULÁRIO CENTRALIZADO E LIMITADO -->
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-6">
            
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">
                    
                    <form method="POST">
                        
                        <div class="mb-4">
                            <label for="descricao" class="form-label fw-medium text-dark">
                                Descrição do Tipo de Despesa
                            </label>
                            <!-- form-control-lg para melhor área de toque no celular -->
                            <input 
                                type="text" 
                                id="descricao"
                                name="descricao" 
                                value="<?= htmlspecialchars($tipo_despesa['descricao']) ?>" 
                                placeholder="Ex: Alimentação, Transporte, Lazer..." 
                                class="form-control form-control-lg bg-light" 
                                required
                            >
                        </div>

                        <!-- BOTÕES DE AÇÃO -->
                        <div class="d-grid d-md-flex justify-content-md-end gap-2 mt-5">
                            <a href="index.php" class="btn btn-light px-4 py-2 text-secondary fw-medium">
                                Cancelar
                            </a>
                            <button type="submit" name="edit" class="btn btn-success px-4 py-2 shadow-sm fw-medium">
                                <i class="bi bi-check-lg me-1"></i> Salvar Alterações
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

<?php
    include '../../templates/footer.php';
?>
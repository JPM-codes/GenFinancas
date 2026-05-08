<?php
    $titulo_pagina = "Inserindo Tipo de Despesa";

    require_once __DIR__ . '/../../config/database.php';

    include '../../templates/header.php';
    include '../../templates/navbar.php';

    // Inserindo um novo tipo de despesa
    if(isset($_POST['add'])) {
        $stmt = $pdo->prepare("INSERT INTO tipo_despesa (descricao) VALUES (?)");
        $stmt->execute([$_POST['descricao']]);
        header("Location: index.php");
        exit; // Boas práticas: interromper o script após o redirecionamento
    }    
?>

<!-- Inclusão de ícones do Bootstrap (Opcional, caso não esteja no seu header) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<div class="container mt-4 mt-md-5 mb-5">

    <!-- TÍTULO E BOTÃO VOLTAR -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <h2 class="fw-bold text-dark mb-0 fs-4 fs-md-3">
            <i class="bi bi-tags-fill me-2 text-primary"></i> Nova Categoria de Despesa
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
                                Descrição da Categoria
                            </label>
                            <!-- form-control-lg para melhor área de toque no celular -->
                            <input 
                                type="text" 
                                id="descricao"
                                name="descricao" 
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
                            <button type="submit" name="add" class="btn btn-success px-4 py-2 shadow-sm fw-medium">
                                <i class="bi bi-check-lg me-1"></i> Salvar
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
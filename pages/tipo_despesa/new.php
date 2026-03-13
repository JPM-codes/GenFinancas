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
    }    
?>
    <div class="container-fluid">
      <h3>Inserindo um novo tipo de despesa</h3>
      <div class="card mb-4">
            <div class="card-body">
                <form method="POST" class="row g-3">
                    <div class="col-md-10">
                        <input type="text" name="descricao" placeholder="Descrição do tipo de despesa" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" name="add" class="btn btn-success">Salvar</button>
                    </div>
                </form>
            </div>
      </div>
    </div>

<?php
    include '../../templates/footer.php';
?>
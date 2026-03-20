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
    }
?>
    <div class="container-fluid">
      <h3>Inserindo um novo tipo de despesa</h3>
      <div class="card mb-4">
            <div class="card-body">
                <form method="POST" class="row g-3">
                    <div class="col-md-10">
                        <input type="text" name="descricao" value="<?= $tipo_despesa['descricao'] ?>" placeholder="Descrição do tipo de despesa" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" name="edit" class="btn btn-success">Salvar</button>
                    </div>
                </form>
            </div>
      </div>
    </div>

<?php
    include '../../templates/footer.php';
?>
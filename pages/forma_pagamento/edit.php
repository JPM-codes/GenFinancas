<?php
    $titulo_pagina = "Alterando a Forma de Pagamento";

    require_once __DIR__ . '/../../config/database.php';

    include '../../templates/header.php';

    include '../../templates/navbar.php';


    // Alterando o tipo de despesa
    $id = $_GET['id_forma_pagamento'];
    $stmt = $pdo->prepare('SELECT id_forma_pagamento, descricao FROM forma_pagamento WHERE id_forma_pagamento=?');

    $stmt->execute([$id]);
    $forma_pagamento = $stmt->fetch();

    if(!$forma_pagamento) {
        die('Tipo de despesa não encontrada!');
    }

    if (isset($_POST['edit'])) {
        $stmt = $pdo->prepare('UPDATE forma_pagamento SET descricao=? WHERE id_forma_pagamento=?');
        $stmt->execute([$_POST['descricao'], $id]);
        header('Location: index.php');
    }
?>
    <div class="container-fluid">
      <h3>Editando uma forma de pagamento</h3>
      <div class="card mb-4">
            <div class="card-body">
                <form method="POST" class="row g-3">
                    <div class="col-md-10">
                        <input type="text" name="descricao" value="<?= $forma_pagamento['descricao'] ?>" placeholder="Descrição do tipo de despesa" class="form-control" required>
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
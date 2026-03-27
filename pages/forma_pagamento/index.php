<?php
require_once __DIR__ . '/../../config/database.php';

include '../../templates/header.php';
include '../../templates/navbar.php';

$forma_pagamento = $pdo->query('SELECT id_forma_pagamento, descricao 
    FROM forma_pagamento 
    where ind_excluido = 0
    ORDER BY descricao')
    ->fetchAll();

    if(isset($_POST['excluir'])) {
        $stmt = $pdo->prepare(
            'UPDATE forma_pagamento 
            SET IND_EXCLUIDO = 1
            WHERE id_forma_pagamento = :id'
        );
        
        $stmt->execute([
            ':id' => $_POST['excluir']
        ]);

        header('Location: index.php');
        exit;
    }

?>

<br />
<div class="container">
    <h1 class="mb-3">Consultando forma de pagamento</h1>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Descricao</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($forma_pagamento as $t): ?>
            <tr>
                <th scope="row"><?= $t['id_forma_pagamento']?></th>
                <td><?= $t['descricao'] ?></td>
                <td>
                    <a href="edit.php?id_forma_pagamento=<?= $t['id_forma_pagamento'] ?>">
                        <button type="button" class="btn btn-primary">Editar</button>
                    </a>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="excluir" value="<?= $t['id_forma_pagamento'] ?>">
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
include '../../templates/footer.php';
?>
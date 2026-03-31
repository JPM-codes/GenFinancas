<?php
require_once __DIR__ . '/../../config/database.php';

include '../../templates/header.php';
include '../../templates/navbar.php';

$tipo_despesa = $pdo->query('SELECT id_tipo_despesa, descricao 
    FROM tipo_despesa 
    where ind_excluido = 0
    ORDER BY descricao')
    ->fetchAll();

    if(isset($_POST['excluir'])) {
        $stmt = $pdo->prepare(
            'UPDATE tipo_despesa 
            SET IND_EXCLUIDO = 1
            WHERE ID_TIPO_DESPESA = :id'
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
    <h1 class="mb-3">Consultando tipo de despesa</h1>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Descricao</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tipo_despesa as $t): ?>
            <tr>
                <th scope="row"><?= $t['id_tipo_despesa']?></th>
                <td><?= $t['descricao'] ?></td>
                <td>
                    <a href="edit.php?id_tipo_despesa=<?= $t['id_tipo_despesa'] ?>">
                        <button type="button" class="btn btn-primary">Editar</button>
                    </a>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="excluir" value="<?= $t['id_tipo_despesa'] ?>">
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
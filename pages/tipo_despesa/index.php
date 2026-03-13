<?php
require_once __DIR__ . '/../../config/database.php';

include '../../templates/header.php';
include '../../templates/navbar.php';

$tipo_despesa = $pdo->query('SELECT id_tipo_despesa, descricao 
    FROM tipo_despesa 
    where ind_excluido = 0
    ORDER BY descricao')
    ->fetchAll();

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
            <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>
                    <button type="button" class="btn btn-primary">Editar</button>
                    <button type="button" class="btn btn-danger">Excluir</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<?php
include '../../templates/footer.php';
?>
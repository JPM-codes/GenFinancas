<?php
require_once __DIR__ . '/../../config/database.php';

include '../../templates/header.php';
include '../../templates/navbar.php';

$movimentacao = $pdo->query('
    SELECT 

    m.id_movimentacao, m.id_forma_pagamento,
    f.descricao as desc_forma_pagamento,
    m.id_tipo_despesa, t.descricao as desc_tipo_despesa,
    m.tipo_movimentacao, 
    m.data, 
    m.valor, 
    m.observacao
    FROM movimentacao m

    INNER JOIN forma_pagamento f on m.id_forma_pagamento = f.id_forma_pagamento
    INNER JOIN tipo_despesa t on m.id_tipo_despesa = t.id_tipo_despesa

    ORDER BY m.data DESC
')
    ->fetchAll();

if (isset($_POST['excluir'])) {
    $stmt = $pdo->prepare(
        'DELETE FROM movimentacao WHERE id_movimentacao = :id'  
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
    <h1 class="mb-3">Consultando movimentações</h1>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Data</th>
                <th scope="col">Valor</th>
                <th scope="col">Tipo</th>
                <th scope="col">Pagamento</th>
                <th scope="col">Observação</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($movimentacao as $m): ?>
                <tr>
                    <?php if ($m['tipo_movimentacao'] == 'e'): ?>
                        <td class="text-success fw-bold"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                <path
                                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                            </svg></td>
                    <?php else: ?>
                        <td class="text-danger fw-bold"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16">
                                <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8" />
                            </svg></td>
                    <?php endif; ?>
                    <td><?= DateTime::createFromFormat('Y-m-d', $m['data'])->format('d/m/Y') ?></td>
                    <td><?= 'R$ ' . number_format((float) $m['valor'], 2, ',', '.') ?></td>
                    <td><?= $m['desc_tipo_despesa'] ?></td>
                    <td><?= $m['desc_forma_pagamento'] ?></td>
                    <td><?= $m['observacao'] ?></td>
                    <td>
                        <a href="edit.php?id_movimentacao=<?= $m['id_movimentacao'] ?>">
                            <button class="btn btn-sm btn-primary">Editar</button>
                        </a>

                        <form style="display: inline;" method="post">
                            <input type="hidden" name="excluir" value="<?= $m['id_movimentacao'] ?>">
                            <button class="btn btn-sm btn-danger" type="submit">Excluir</button>
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
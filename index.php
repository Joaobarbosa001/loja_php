<?php
require_once 'init.php';
// abre a conexão
$PDO = db_connect();
// SQL para contar o total de registros
// A biblioteca PDO possui o método rowCount(), 
// mas ele pode ser impreciso.
// É recomendável usar a função COUNT da SQL
$sql_count = "SELECT COUNT(*) AS total FROM produtos ORDER BY name ASC";
// SQL para selecionar os registros
$sql = "SELECT name, color, price, quantity, startDate, id "
        . "FROM produtos ORDER BY name ASC";
// conta o toal de registros
$stmt_count = $PDO->prepare($sql_count);
$stmt_count->execute();
$total = $stmt_count->fetchColumn();
// seleciona os registros
$stmt = $PDO->prepare($sql);
$stmt->execute();
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Sistema de Cadastro</title>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/bootstrap-theme.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="content">
            <div class="container clearfix">
                <h1>Cadastro de Produtos</h1>
                <p><a href="form-add.php">Adicionar Produto</a></p>
                <h2>Lista de Produtos</h2>
                <p>Total de Produtos: <?php echo $total ?></p>
                <?php if ($total > 0): ?>
                    <table width="50%" border="1">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Cor</th>
                                <th>Preço</th>
                                <th>Quantidade</th>
                                <th>Data da Compra</th>
                                <th>Id</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($produtos = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                <tr>
                                    <td><?php echo $produtos['name'] ?></td>
                                    <td><?php echo $produtos['color'] ?></td>
                                    <td><?php echo $produtos['price'] ?></td>
                                    <td><?php echo $produtos['quantity'] ?></td>
                                    <td><?php echo dateConvert($produtos['startDate']) ?></td>
                                    <td><?php echo $produtos['id'] ?></td>
                                    <td>
                                        <a href="form-edit.php?id=<?php echo $produtos['id'] ?>">Editar</a>
                                        <a href="delete.php?id=<?php echo $produtos['id'] ?>" 
                                           onclick="return confirm('Tem certeza de que deseja remover?');">
                                            Remover
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Nenhum Produto registrado</p>
                <?php endif; ?>
            </div>
        </div>
        <script src="js/npm.js" type="text/javascript"></script>
        <script src="js/bootstrap.js" type="text/javascript"></script>

    </body>
</html>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>Página Inicial</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <h2>Crud Samrt NX</h2>
        </div>
        </br>
        <div class="row">
            <p>
                <a href="create.php" class="btn btn-success">Adicionar</a>
            </p>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Modelo</th>
                        <th scope="col">Ano</th>
                        <th scope="col">Placa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'connection.php';
                    $pdo = Connection::connect();
                    $sql = 'SELECT * FROM carro ORDER BY id DESC';

                    foreach ($pdo->query($sql) as $row) {
                        echo '<tr>';
                        echo '<th scope="row">' . $row['id'] . '</th>';
                        echo '<td>' . $row['marca'] . '</td>';
                        echo '<td>' . $row['modelo'] . '</td>';
                        echo '<td>' . $row['ano'] . '</td>';
                        echo '<td>' . $row['placa'] . '</td>';
                        echo '<td width=250>';
                        echo '<a class="btn btn-primary" href="read.php?id=' . $row['id'] . '">Info</a>';
                        echo ' ';
                        echo '<a class="btn btn-warning" href="update.php?id=' . $row['id'] . '">Atualizar</a>';
                        echo ' ';
                        echo '<a class="btn btn-danger" href="delete.php?id=' . $row['id'] . '">Excluir</a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    Connection::disconnect();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>
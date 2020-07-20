<?php

require 'connection.php';

$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if (null == $id) {
    header("Location: index.php");
}

if (!empty($_POST)) {

    $marcaError = null;
    $modeloError = null;
    $anoError = null;
    $placaError = null;

    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $ano = $_POST['ano'];
    $placa = $_POST['placa'];

    $validacao = true;
    if (empty($marca)) {
        $marcaError = 'Por favor digite a marca do veículo !';
        $validacao = false;
    }

    if (empty($modelo)) {
        $modeloErro = 'Por favor digite o modelo!';
        $validacao = false;
    }

    if (empty($ano)) {
        $anoError = 'Por favor digite o ano do veículo!';
        $validacao = false;
    }

    if (empty($placa)) {
        $placaError = 'Por favor digite a placa do veículo';
        $validacao = false;
    } else {
        $regex = '/[A-Z]{3}[0-9][0-9A-Z][0-9]{2}/';
        if (preg_match($regex, $placa) !== 1) {
            $placaError = 'Por favor digite uma placa válida!';
            $validacao = False;
        }
    }

    if ($validacao) {
        $pdo = Connection::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE carro  set marca = ?, modelo = ?, ano = ?, placa = ? WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($marca, $modelo, $ano, $placa, $id));
        Connection::disconnect();
        header("Location: index.php");
    }
} else {
    $pdo = Connection::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM carro where id = ?";
    $select = $pdo->prepare($sql);
    $select->execute(array($id));
    $data = $select->fetch(PDO::FETCH_ASSOC);
    $marca = $data['marca'];
    $modelo = $data['modelo'];
    $ano = $data['ano'];
    $placa = $data['placa'];
    Connection::disconnect();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Atualizar Veículo</title>
</head>

<body>
    <div class="container">

        <div class="span10 offset1">
            <div class="card">
                <div class="card-header">
                    <h3 class="well"> Atualizar Veículo </h3>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="update.php?id=<?php echo $id ?>" method="post">

                        <div class="control-group <?php echo !empty($marcaError) ? 'error' : ''; ?>">
                            <label class="control-label">Marca</label>
                            <div class="controls">
                                <input name="marca" class="form-control" size="50" type="text" placeholder="Marca" value="<?php echo !empty($marca) ? $marca : ''; ?>">
                                <?php if (!empty($marcaError)) : ?>
                                    <span class="text-danger"><?php echo $marcaError; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="control-group <?php echo !empty($modeloError) ? 'error' : ''; ?>">
                            <label class="control-label">Modelo</label>
                            <div class="controls">
                                <input name="modelo" class="form-control" size="80" type="text" placeholder="Modelo" value="<?php echo !empty($modelo) ? $modelo : ''; ?>">
                                <?php if (!empty($modeloError)) : ?>
                                    <span class="text-danger"><?php echo $modeloError; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="control-group <?php echo !empty($anoError) ? 'error' : ''; ?>">
                            <label class="control-label">Ano</label>
                            <div class="controls">
                                <input name="ano" class="form-control" size="30" type="text" placeholder="Ano" value="<?php echo !empty($ano) ? $ano : ''; ?>">
                                <?php if (!empty($anoError)) : ?>
                                    <span class="text-danger"><?php echo $anoError; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="control-group <?php echo !empty($placaError) ? 'error' : ''; ?>">
                            <label class="control-label">Placa</label>
                            <div class="controls">
                                <input name="placa" class="form-control" size="40" type="text" placeholder="Placa" value="<?php echo !empty($placa) ? $placa : ''; ?>">
                                <?php if (!empty($placaError)) : ?>
                                    <span class="text-danger"><?php echo $placaError; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <br />
                        <div class="form-actions">
                            <button type="submit" class="btn btn-warning">Atualizar</button>
                            <a href="index.php" type="btn" class="btn btn-default">Voltar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>
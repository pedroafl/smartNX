<?php
require 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $marcaError = null;
    $modeloError = null;
    $anoError = null;
    $placaError = null;

    if (!empty($_POST)) {
        $validacao = True;
        $novoCarro = False;
        if (!empty($_POST['marca'])) {
            $marca = $_POST['marca'];
        } else {
            $marcaError = 'Por favor digite a marca do carro!';
            $validacao = False;
        }


        if (!empty($_POST['modelo'])) {
            $modelo = $_POST['modelo'];
        } else {
            $modeloError = 'Por favor digite o modelo do carro!';
            $validacao = False;
        }


        if (!empty($_POST['ano'])) {
            $ano = $_POST['ano'];
        } else {
            $anoError = 'Por favor digite o ano do modelo!';
            $validacao = False;
        }


        if (!empty($_POST['placa'])) {
            $placa = $_POST['placa'];
            $regex = '/[A-Z]{3}[0-9][0-9A-Z][0-9]{2}/';

            if (preg_match($regex, $placa) !== 1) {
                $placaError = 'Por favor digite uma placa válida!';
                $validacao = False;
            }
        } else {
            $placaErro = 'Por favor digite a placa do veículo!';
            $validacao = False;
        }
    }

    if ($validacao) {
        $pdo = Connection::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO carro (marca, modelo, ano, placa) VALUES(?,?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($marca, $modelo, $ano, $placa));
        Connection::disconnect();
        header("Location: index.php");
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>Adicionar Carro</title>
</head>

<body>
    <div class="container">
        <div clas="span10 offset1">
            <div class="card">
                <div class="card-header">
                    <h3 class="well"> Adicionar Carro </h3>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="create.php" method="post">

                        <div class="control-group  <?php echo !empty($marcaError) ? 'error ' : ''; ?>">
                            <label class="control-label">Marca</label>
                            <div class="controls">
                                <input size="50" class="form-control" name="marca" type="text" placeholder="Marca" value="<?php echo !empty($marca) ? $marca : ''; ?>">
                                <?php if (!empty($marcaError)) : ?>
                                    <span class="text-danger"><?php echo $marcaError; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="control-group <?php echo !empty($modeloError) ? 'error ' : ''; ?>">
                            <label class="control-label">Modelo</label>
                            <div class="controls">
                                <input size="80" class="form-control" name="modelo" type="text" placeholder="Modelo" value="<?php echo !empty($modelo) ? $modelo : ''; ?>">
                                <?php if (!empty($modeloError)) : ?>
                                    <span class="text-danger"><?php echo $modeloError; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="control-group <?php echo !empty($anoError) ? 'error ' : ''; ?>">
                            <label class="control-label">Ano</label>
                            <div class="controls">
                                <input size="35" class="form-control" name="ano" type="text" placeholder="Ano" value="<?php echo !empty($ano) ? $ano : ''; ?>">
                                <?php if (!empty($anoError)) : ?>
                                    <span class="text-danger"><?php echo $anoError; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="control-group <?php !empty($placaErro) ? 'error ' : ''; ?>">
                            <label class="control-label">Placa</label>
                            <div class="controls">
                                <input size="40" class="form-control" name="placa" type="text" placeholder="Placa" value="<?php echo !empty($placa) ? $placa : ''; ?>">
                                <?php if (!empty($placaError)) : ?>
                                    <span class="text-danger"><?php echo $placaError; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-actions">
                            <br />
                            <button type="submit" class="btn btn-success">Adicionar</button>
                            <a href="index.php" type="btn" class="btn btn-default">Voltar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>
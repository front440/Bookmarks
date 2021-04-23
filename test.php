<?php

include('Model/Usuario.php');
include('Model/Marcador.php');

$usuario = $password = $marcadores = "";
$datosLogin = array();

$user = Usuario::getInstancia();
$marcador = Marcador::getInstancia();

if (!isset($_POST['enviar'])) {
    $usuario = $_POST['usuario'] ?? "";
    $password = $_POST['password'] ?? "";

    $datosLogin = $user->login($usuario, $password);
    if ($datosLogin["usuario"] != "invitado") {
        echo "Acesso Permitido<br>";
        echo "Usuario: " . $datosLogin["usuario"] . "<br>";
        // echo "intentos:" . $_SESSION["intentos"] . "<br>";

        $marcadores = $marcador->getMarcadorbyUser($datosLogin["id"]);
    } else {
        echo "Acesso no Permitido<br>";
        echo "Usuario: " . $datosLogin["usuario"] . "<br>";
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookmarks</title>
</head>

<body>
    <h1>Bookmarks</h1>
    <form action="" method="post">
        <label for="usuario"><input type="text" name="usuario" placeholder="usuario"></label>
        <label for="password"><input type="text" name="password" placeholder="password"></label>
        <input type="submit" value="enviar">
    </form>

    <table>
        <tr>
            <td>Descripcion</td>
            <td>Enlace</td>
        </tr>
        <?php
        // var_dump($marcadores);

        foreach ($marcadores as $key) {
            echo "<td>" . $key["descripcion"] . "</td>";
            echo "<td>" . $key["enlace"] . "</td>";
        }

        ?>
    </table>

</body>

</html>
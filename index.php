<?php

include('Model/Marcador.php');
include('Model/Usuario.php');

session_start();

$user = Usuario::getInstancia();
$marcador = Marcador::getInstancia();

$usuario = $password = $marcadores = $descripcion = $enlace = "";
$datosLogin = array();

if (!isset($_SESSION['usuario'])) {
    $_SESSION['usuario'] = "invitado";
}

if (!isset($_SESSION['idUsuario'])) {
    $_SESSION['idUsuario'] = "";
}

if (!isset($_POST["enviar"])) {
    $usuario = $_POST["usuario"] ?? "";
    $password = $_POST["password"] ?? "";

    $datosLogin = $user->login($usuario, $password);
    if ($datosLogin["usuario"] != "invitado") {

        $_SESSION["usuario"] = $usuario; // EEEEEEEEEEEE
        $_SESSION["idUsuario"] = $datosLogin["id"]; // EEEEEEEEEEEE

        echo "Acesso Permitido<br>";
        echo "Usuario: " . $datosLogin["usuario"] . "<br>";

        $marcadores = $marcador->getMarcadorbyUser($datosLogin["id"]);
    } else {
        echo "Acesso no Permitido<br>";
        echo "Usuario: " . $datosLogin["usuario"] . "<br>";
    }
}

if (isset($_POST["crear"])) {
    $descripcion = $_POST["descripcion"];
    $enlace = $_POST["enlace"];

    $marcador->setDescripcion("OSTIAS");
    $marcador->setEnlace("CAWENDIO");
    $marcador->setIdUsuario(1);
    $marcador->set();
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

    <!-- <table>
        <tr>
            <td>Descripcion</td>
            <td>Enlace</td>
        </tr>
    </table> -->
    <?php

    if ($_SESSION["usuario"] == "invitado") {
        echo "<h2>Login</h2>";
        echo '<form action="" method="POST">';
        echo '<label for="usuario"><input type="text" name="usuario" placeholder="usuario"></label>';
        echo '<label for="password"><input type="text" name="password" placeholder="password"></label>';
        echo '<input type="submit" value="enviar">';
        echo '</form>';
        var_dump($marcadores);
    } else {

        echo "<h2>Booksmarks de " . $usuario . "</h2>";
        echo '<form action="" method="POST">';
        echo '<label for="descripcion"><input type="text" name="descripcion" placeholder="descripcion" value=' . $descripcion . '></label>';
        echo '<label for="enlace"><input type="text" name="enlace" placeholder="enlace" value=' . $enlace . '></label>';
        echo '<input type="submit" value="crear">';
        echo '</form>';

        echo "<table>";
        echo "<tr>";
        echo "<td>Descripcion</td>";
        echo "<td>Enlace</td>";
        var_dump($marcadores);

        echo "</table";
        $marcadores = $marcador->getMarcadorbyUser($_SESSION["idUsuario"]);

        foreach ($marcadores as $key) {
            echo "<td>" . $key["descripcion"] . "</td>";
            echo "<td>" . $key["enlace"] . "</td>";
        }
    }
    ?>
    <button><a href="cerrarSesion.php">Cerrar Sesion</a></button>



</body>

</html>
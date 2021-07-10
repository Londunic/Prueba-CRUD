<?php 
    //inicio de session
    session_start();

    require_once "pdo.php";

    $stmt = $pdo->query("SELECT cedula,edad,nombre,apellido,genero FROM usuario");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <link href="starter-template.css" rel="stylesheet">

    <title>Edwar Jose Londoño Correa </title>
</head>
<body>
<div class="container">
    <h1>Hola, bienvenido.</h1>
    <br>
    <?php
    if (isset($_SESSION['success'])) {
        echo('<p style="color: green;">' . htmlentities($_SESSION['success']) . "</p>\n");
        unset($_SESSION['success']);
    }

    if (isset($_SESSION['error'])) {
        echo('<p style="color: red;">' . htmlentities($_SESSION['error']) . "</p>\n");
        unset($_SESSION['error']);
    }
    ?>

    <ul>
        <?php
            if (sizeof($rows) > 0) {
                echo "<table border='1'>
                        <thead>
                            <tr>
                                <th>Cedula</th>
                                <th>Edad</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Género</th>
                                <th>Opciones</th>
                                </tr></thead>";

                foreach ($rows as $row) {
                    echo("<tr><td>");
                    echo($row['cedula']);
                    echo("</td><td>");
                    echo($row['edad']);
                    echo("</td><td>");
                    echo($row['nombre']);
                    echo("</td><td>");
                    echo($row['apellido']);
                    echo("</td><td>");
                    echo($row['genero']);
                    echo("</td><td>");
                    echo('<a href="edit.php?cedula='.$row['cedula'].'">Editar</a> / <a href="delete.php?cedula='.$row['cedula'].'">Borrar</a>');
                    echo("</td></tr>\n");
                }
                echo "</table>";
            } else {
                echo 'No hay usuarios registrados';
            }
            echo '</li><br/></ul>';
            echo '<p><a href="add.php">Agregar un nuevo usuario</a></p>';
        
        ?>
</div>
</body>
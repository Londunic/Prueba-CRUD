<?php
    //inicio de session
    session_start();

    if ( isset($_POST['cancelar'] ) ) {    
        header("Location: index.php");
        return;
    }

    require_once "pdo.php";

    if ( isset($_POST['cedula']) && isset($_POST['edad']) && isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['genero']) ) {
        if (strlen($_POST['cedula']) < 1 || strlen($_POST['edad']) < 1 || strlen($_POST['nombre']) < 1 || strlen($_POST['apellido']) < 1 ) {
            $_SESSION['error'] = 'Todo los campos son requeridos';
            header("Location: add.php");
            return;
        } elseif (!is_numeric($_POST['cedula']) || !is_numeric($_POST['edad'])) {
            $_SESSION['error'] = "Cédula y edad deben ser numéricos";
            header("Location: add.php");
            return;
        }

        //Verifico que no exista un usuario ya registrado con la cedula que ingresa
        $stmt = $pdo->prepare("SELECT * FROM usuario where cedula = :xyz");
        $stmt->execute(array(":xyz" => $_POST['cedula']));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ( $row >=1 ) {
            $_SESSION['error'] = "Ya existe un usuario registrado con esta cédula";
            header('Location: add.php');
            return;
        }

        $stmt = $pdo->prepare('INSERT INTO usuario (cedula, edad, nombre, apellido, genero) VALUES ( :cedula, :edad, :nombre, :apellido, :genero)');
        $stmt->execute(array(
                    ':cedula' => $_POST['cedula'],
                    ':edad' => $_POST['edad'],
                    ':nombre' => $_POST['nombre'],
                    ':apellido' => $_POST['apellido'],
                    ':genero' => $_POST['genero'])
        );
        $_SESSION['success'] = "Registro agregado exitosamente.";
        header("Location: index.php");
        return;
    } 
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
    <h1>Registro de Usuario Nuevo</h1>

    <?php
    if (isset($_SESSION['error'])) {
        echo('<p style="color: red;">' . htmlentities($_SESSION['error']) . "</p>\n");
        unset($_SESSION['error']);
    }
    ?>

    <form method="post">
        <p>Cedula:

            <input type="text" name="cedula" size="40"/></p>
        <p>Edad:

            <input type="text" name="edad" size="40"/></p>
        <p>Nombre:

            <input type="text" name="nombre" size="10"/></p>
        <p>Apellido:

            <input type="text" name="apellido" size="10"/></p>
        <p>Género M/F:
            <br>
            <input type="radio" name="genero" value="M" checked>M<br>
            <input type="radio" name="genero" value="F">F<br></p>
        <input type="submit" name="agregar" value="Agregar">
        <input type="submit" name="cancelar" value="Cancelar">
    </form>


</div>
</body>
</html>
<?php
    //inicio de session
    session_start();

    require_once "pdo.php";

    if ( isset($_POST['cancelar'] ) ) {    
        header("Location: index.php");
        return;
    }

    if (isset($_POST['edad']) && isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['genero'])) {
        if (!is_numeric($_POST['edad'])) {
            $_SESSION['error'] = 'La edad debe ser numérica';
            header("Location: index.php");
            return;
        }
        elseif ( strlen($_POST['edad']) < 1 || strlen($_POST['nombre']) < 1 || strlen($_POST['apellido']) < 1 || strlen($_POST['genero']) < 1) {
            $_SESSION['error'] = 'Todo los campos son requeridos';
            header("Location: index.php");
            return;
        }
        elseif( ($_POST['genero'] == "M") || ($_POST['genero'] == "F") ){
            $sql = "UPDATE usuario SET edad = :edad,
            nombre = :nombre, apellido = :apellido, genero=:genero
            WHERE cedula = :cedula";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':edad' => $_POST['edad'],
                ':nombre' => $_POST['nombre'],
                ':apellido' => $_POST['apellido'],
                ':genero' => $_POST['genero'],
                ':cedula' => $_GET['cedula'])
            );
            $_SESSION['success'] = 'Regristro actualizado';
            header('Location: index.php');
            return;
        }
        else{
            $_SESSION['error'] = 'Género invalido, tiene que ser M/F';
            header("Location: index.php");
            return;
        }

    }

    // Para estar seguros que la cedula esta presente
    if (!isset($_GET['cedula'])) {
        $_SESSION['error'] = "Falta cedula";
        header('Location: index.php');
        return;
    }

    $stmt = $pdo->prepare("SELECT * FROM usuario where cedula = :xyz");
    $stmt->execute(array(":xyz" => $_GET['cedula']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row === false) {
        $_SESSION['error'] = 'Valor incorrecto para cédula';
        header('Location: index.php');
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
    <h1>Editar Usuario</h1>
    <form method="post">
        <p>Cedula: <?php echo $row['edad'] ?></p>
        <p>Edad <input type="text" name="edad" size="40" value="<?php echo $row['edad'] ?>"/> (Obligatorio)</p>
        <p>Nombre <input type="text" name="nombre" size="40" value="<?php echo $row['nombre'] ?>"/> (Obligatorio)</p>
        <p>Apellido <input type="text" name="apellido" size="10" value="<?php echo $row['apellido'] ?>"/> (Obligatorio)</p>
        <?php
        if ($row['genero'] == "M"){
            echo "<p>Género M/F 
                    <br>
                    <input type='radio' name='genero' value='M' checked>M<br>
                    <input type='radio' name='genero' value='F'>F<br></p>";
        }
        else{
            echo "<p>Género M/F 
                    <br>
                    <input type='radio' name='genero' value='M'>M<br>
                    <input type='radio' name='genero' value='F' checked>F<br></p>";
        }
        ?>
        <input type="submit" value="Guardar">
        <input type="submit" name="cancelar" value="Cancelar">
    </form>
    <p>
</div>
</body>
</html>
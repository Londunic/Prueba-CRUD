<?php
    //inicio de session
    session_start();

    require_once "pdo.php";

    if ( isset($_POST['cancelar'] ) ) {    
        header("Location: index.php");
        return;
    }

    if ( isset($_POST['eliminar']) && isset($_POST['cedula']) ) {
        $sql = "DELETE FROM usuario WHERE cedula = :zip";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':zip' => $_POST['cedula']));
        $_SESSION['success'] = 'Registro eliminado';
        header( 'Location: index.php' ) ;
        return;
    }

    // Para estar seguros que la cedula esta presente
    if ( ! isset($_GET['cedula']) ) {
        $_SESSION['error'] = "Falta cedula";
        header('Location: index.php');
        return;
    }

    $stmt = $pdo->prepare("SELECT nombre, apellido FROM usuario where cedula = :xyz");
    $stmt->execute(array(":xyz" => $_GET['cedula']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ( $row === false ) {
        $_SESSION['error'] = 'Mal valor de cedula';
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
    <h1>Confirmación: Borrado de <?php echo $row['nombre']." ".$row['apellido'] ?></h1>
    <br>
    <form method="post">
        <input type="hidden" name="cedula" value="<?php echo $_GET['cedula'] ?>"> 
        <input type="submit" value="Eliminar" name="eliminar">
        <input type="submit" name="cancelar" value="Cancelar">
    </form>
</div>
</body>
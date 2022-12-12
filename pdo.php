<?php

    //Se realiza el acceso a la base de datos.
    try 
    {
        $pdo = new PDO("mysql:host=localhost;port=3306;dbname=prueba", "edwar", "zap");
        // set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
        die();
    }
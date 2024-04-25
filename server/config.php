<?php
    include 'utils.php';
    //make the connection string
    $host = "localhost";
    $user = "root";
    $password = "";

    $dbname = "tree_identification_db";

    $dsn = "mysql:host=".$host.";dbname=".$dbname;

    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

?>
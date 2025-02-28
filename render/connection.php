<?php
    $server = "localhost";
    $user = "root";
    $pass = "";
    $db = "hfa";

    // $server = "127.0.0.1";
    // $user = "u428758214_hfa";
    // $pass = "Hfaservices1";
    // $db = "u428758214_hfa";

    $conn = mysqli_connect($server, $user, $pass, $db);
        if (!$conn) {
        die("connection error " . mysqli_connect_error());
    }

    try {
        $pdo = new PDO("mysql:host=$server;dbname=$db", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>
<?php

$host = "localhost";  /* caminho ou site */
$db   = "genfinancas"; /* nome do BD */
$user = "root";       /* usuário do BD */
$pass = "";           /* senha do BD */

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

?>



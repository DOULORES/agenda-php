<?php

$host = "localhost";
$dbname = "agenda";
$user = "root";
$pass = "";

try {

    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    // Ativa o modo de Erros
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Apresenta o erro caso ele ocorra
    $error = $e->getMessage();
    echo "Erro: $error";
}

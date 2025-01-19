<?php

session_start();

include_once("config/connection.php");
include_once("config/url.php");

$id;

if (!empty($_GET)) {
    $id = $_GET["id"];
}
// Retorna 1 contato
if (!empty($id)) {

    $query = "SELECT * FROM contacts WHERE id = :id";

    $stmt = $conn->prepare($query);

    $stmt->bindParam(":id", $id);

    $stmt->execute();

    $contact = $stmt->fetch();
} else {
    // Retorna todos os contatos
    $contacts = [];
    $query = "SELECT * FROM contacts";

    $stmt = $conn->prepare($query);

    $stmt->execute();

    $contacts = $stmt->fetchAll();
}

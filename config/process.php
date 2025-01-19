<?php

session_start();

include_once("connection.php");
include_once("url.php");

$data = $_POST;

// MODIFICAÇÕES NO BANCO
if (!empty($data)) {

    if ($data["type"] === "create") {
        $name         = $data["name"];
        $phone        = $data["phone"];
        $observations = $data["observations"];

        $sql  = "INSERT INTO contacts (name, phone, observations) VALUES (:name, :phone, :observations)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":observations", $observations);

        try {
            $stmt->execute();
            $_SESSION["msg"] = "Contato criado com sucesso";
        } catch (PDOException $e) {
            // Apresenta o erro caso ele ocorra
            $error = $e->getMessage();
            echo "Erro: $error";
        }
    } elseif ($data["type"] === "edit") {
        $name         = $data["name"];
        $phone        = $data["phone"];
        $observations = $data["observations"];
        $id           = $data["id"];

        $sql = "UPDATE contacts SET name = :name, phone = :phone, observations = :observations WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":observations", $observations);
        $stmt->bindParam(":id", $id);

        try {
            $stmt->execute();
            $_SESSION["msg"] = "Contato editado com sucesso";
        } catch (PDOException $e) {
            // Apresenta o erro caso ele ocorra
            $error = $e->getMessage();
            echo "Erro: $error";
        }
    } elseif ($data["type"] === "delete") {

        $id = $data["id"];
        $sql = "DELETE FROM contacts WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        try {
            $stmt->execute();
            $_SESSION["msg"] = "Contato removido com sucesso!";
        } catch (PDOException $e) {
            // Apresenta o erro caso ele ocorra
            $error = $e->getMessage();
            echo "Erro: $error";
        }
    }

    // Redirecionando para HOME
    header("Location: " . $BASE_URL . "../index.php");
} else {
    // SESSÃO DE DADOS
    $id;

    if (!empty($_GET)) {
        $id = $_GET["id"];
    }
    // Retorna 1 contato
    if (!empty($id)) {
        $query = "SELECT * FROM contacts WHERE id = :id";
        $stmt  = $conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $contact = $stmt->fetch();
    } else {
        // Retorna todos os contatos
        $contacts = [];
        $query    = "SELECT * FROM contacts";
        $stmt     = $conn->prepare($query);
        $stmt->execute();
        $contacts = $stmt->fetchAll();
    }
}

// Encerrar conexão
$conn = null;

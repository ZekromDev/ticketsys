<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}


if (isset($_GET['id'])) {
  
    $ticket_id = $_GET['id'];

    $db_host = 'localhost';
    $db_username = 'root';
    $db_password = '';
    $db_database = 'ticketsys';

    $conn = new mysqli($db_host, $db_username, $db_password, $db_database);

    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    $sql = "DELETE FROM tickets WHERE id = $ticket_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: home.php");
        exit();
    } else {
        echo "Erreur lors de la suppression du ticket : " . $conn->error;
    }
    $conn->close();
} else {
    header("Location: home.php");
    exit();
}
?>

<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ticketId']) && isset($_POST['title']) && isset($_POST['description'])) {
   
    $ticketId = $_POST['ticketId'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    
    $db_host = 'localhost';
    $db_username = 'root'; 
    $db_password = ''; 
    $db_database = 'ticketsys';

    $conn = new mysqli($db_host, $db_username, $db_password, $db_database);


    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    
    $title = $conn->real_escape_string($title);
    $description = $conn->real_escape_string($description);

    $sql = "UPDATE tickets SET title='$title', description='$description' WHERE id='$ticketId'";

    if ($conn->query($sql) === TRUE) {
        header("Location: home.php");
        exit();
    } else {
        echo "Erreur lors de la mise à jour du ticket : " . $conn->error;
    }

    $conn->close();
} else {
    header("Location: home.php");
    exit();
}
?>

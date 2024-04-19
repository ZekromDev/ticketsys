<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['username'])) {
    exit('Erreur : Utilisateur non connecté.');
}

$db_host = 'localhost';
$db_username = 'root'; 
$db_password = ''; 
$db_database = 'ticketsys'; 

$conn = new mysqli($db_host, $db_username, $db_password, $db_database);

if ($conn->connect_error) {
    exit('Erreur de connexion à la base de données : ' . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message'])) {
    $message = $_POST['message'];
    $username = $_SESSION['username'];

    $sql = "INSERT INTO chat_messages (username, message) VALUES ('$username', '$message')";
    if ($conn->query($sql) === TRUE) {
        exit('Message envoyé avec succès.');
    } else {
        exit('Erreur lors de l\'envoi du message : ' . $conn->error);
    }
}

$sql = "SELECT * FROM chat_messages ORDER BY id DESC LIMIT 20"; // Limite à 20 messages
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $username = $row['username'];
        $message = $row['message'];
        echo "<p><strong>$username:</strong> $message</p>";
    }
} else {
    echo "Aucun message dans le chat.";
}

$conn->close();
?>

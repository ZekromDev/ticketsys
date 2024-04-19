<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}


$db_host = 'localhost';
$db_username = 'root'; 
$db_password = ''; 
$db_database = 'ticketsys';

$conn = new mysqli($db_host, $db_username, $db_password, $db_database);


if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}


$user_id = $_SESSION['user_id'];


$sql_role = "SELECT role_id FROM users WHERE id = '$user_id'";
$result_role = $conn->query($sql_role);
if ($result_role->num_rows > 0) {
    $row_role = $result_role->fetch_assoc();
    $role_id = $row_role['role_id'];

   
    if ($role_id == 1) {
       
        $sql_tickets = "SELECT * FROM tickets";
    }
   
    elseif ($role_id == 2) {
        
        $sql_tickets = "SELECT * FROM tickets WHERE user_id != '$user_id'";
    }
    
    else {
       
        $sql_tickets = "SELECT * FROM tickets WHERE user_id = '$user_id'";
    }

    $result_tickets = $conn->query($sql_tickets);
}

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['title']) && isset($_POST['description'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $user_id = $_SESSION['user_id'];

        $sql = "INSERT INTO tickets (user_id, title, description) VALUES ('$user_id', '$title', '$description')";
        if ($conn->query($sql) === TRUE) {
            echo "Nouveau ticket créé avec succès.";
        } else {
            $error = "Erreur lors de la création du ticket : " . $conn->error;
        }
    } else {
        $error = "Veuillez remplir tous les champs du formulaire.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        #chat-container {
            width: 300px;
            height: 400px;
            border: 1px solid #ccc;
            overflow-y: auto;
        }

        #chat-messages {
            padding: 10px;
        }

        #message-input {
            width: calc(100% - 70px);
            padding: 5px;
        }

        #send-button {
            width: 60px;
            padding: 5px;
            margin-top: 5px;
            margin-left: 5px;
        }
    </style>
</head>
<body>

    <h1>Bienvenue, <?php echo $_SESSION['username']; ?>!</h1>

    <h2>Mes Tickets</h2>
    <ul>
        <?php
        if (isset($result_tickets) && $result_tickets->num_rows > 0) {
            while($row = $result_tickets->fetch_assoc()) {
                $title = htmlspecialchars($row['title']);
                $description = htmlspecialchars($row['description']);
                $userId = $row['user_id'];
                $ticketId = $row['id'];
                $userColor = ($userId == 1) ? 'red' : (($userId == 2) ? 'green' : 'blue'); // Choisir la couleur en fonction du type d'utilisateur

                echo "<li><span style='color: $userColor;'>$title</span> - <span style='color: $userColor;'>$description</span>";

                if ($role_id == 1) {
                    echo " <a href='javascript:void(0);' onclick='deleteTicket($ticketId)' style='color: red;'>Supprimer</a>";
                }

                echo "</li>";
            }
        } else {
            echo "Aucun ticket trouvé.";
        }
        ?>
    </ul>

    <h2>Créer un nouveau ticket</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="title">Titre :</label><br>
        <input type="text" id="title" name="title" required><br>
        <label for="description">Description :</label><br>
        <textarea id="description" name="description" required></textarea><br>
        <input type="submit" value="Créer">
    </form>

    <?php if ($error): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <br>
    <a href="logout.php">Déconnexion</a>

    <div id="chat-container">
        <div id="chat-messages"></div>
        <textarea id="message-input" placeholder="Entrez votre message..."></textarea>
        <button id="send-button">Envoyer</button>
    </div>

    <script>
        function getMessages() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        document.getElementById('chat-messages').innerHTML = xhr.responseText;
                    } else {
                        console.error('Une erreur est survenue lors de la récupération des messages.');
                    }
                }
            };
            xhr.open('GET', 'chat.php', true);
            xhr.send();
        }

        function sendMessage() {
            var message = document.getElementById('message-input').value;
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        document.getElementById('message-input').value = ''; // Efface le champ après l'envoi
                        getMessages(); 
                    } else {
                        console.error('Une erreur est survenue lors de l\'envoi du message.');
                    }
                }
            };
            xhr.open('POST', 'chat.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('message=' + encodeURIComponent(message));
        }

       
        setInterval(getMessages, 3000); 

        document.getElementById('send-button').addEventListener('click', function() {
            sendMessage();
        });

        document.getElementById('message-input').addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                sendMessage();
            }
        });
    </script>
</body>
</html>

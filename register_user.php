<?php
$host = '192.168.1.100';
$db = 'radius';
$user = 'radius';
$pass = 'radpass';

$conn = new mysqli($host, $user, $pass, $db);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Registrazione</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #4A90E2, #9013FE);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: rgba(255, 255, 255, 0.2);
            padding: 30px;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            text-align: center;
            animation: fadeIn 1s ease-in-out;
            max-width: 400px;
        }
        a {
            color: #FFEB3B;
            text-decoration: underline;
        }
        .success {
    color: #00d4ff; 
    font-weight: bold;
    font-size: 1.1em;
    text-shadow: 1px 1px 2px #00000044;
}
        .error {
            color: #ff5252;
            font-weight: bold;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if ($conn->connect_error) {
            echo '<p class="error">Connessione fallita: ' . $conn->connect_error . '</p>';
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            if ($username != '' && $password != '') {
                $stmt = $conn->prepare("INSERT INTO radcheck (username, attribute, op, value) VALUES (?, 'Cleartext-Password', ':=', ?)");
                $stmt->bind_param("ss", $username, $password);
                if ($stmt->execute()) {
                    echo '<p class="success">Registrazione completata con successo!</p>';
                    echo '<a class="back-btn" href="http://192.168.1.1:8002/index.php?zone=captiveportal">Torna al login</a>';
                   
                } else {
                    echo '<p class="error">Errore durante la registrazione: ' . $stmt->error . '</p>';
                }
                $stmt->close();
            } else {
                echo '<p class="error">Tutti i campi sono obbligatori.</p>';
            }
        }
        $conn->close();
        ?>
    </div>
</body>
</html>

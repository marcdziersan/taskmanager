<?php
// Einbindung der Datenbankverbindung und Funktionen
include 'db.php';
include 'functions.php';

// Registrierung verarbeiten
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        $message = create_user($conn, $username, $password);
    } else {
        $message = "Bitte füllen Sie alle Felder aus!";
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrieren</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .register-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        input:focus {
            outline: none;
            border-color: #3498db;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2980b9;
        }

        .message {
            margin-top: 20px;
            color: red;
            font-size: 14px;
        }

        .link {
            margin-top: 15px;
            display: block;
            color: #3498db;
            text-decoration: none;
        }

        .link:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            body {
                padding: 20px;
            }

            .register-container {
                padding: 25px;
            }
        }
    </style>
</head>
<body>

    <div class="register-container">
        <h1>Registrieren</h1>
        
        <form method="POST" action="">
            <label for="username">Benutzername:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Passwort:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Registrieren</button>
        </form>

        <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <a href="login.php" class="link">Bereits ein Konto? Jetzt einloggen</a>
    </div>

</body>
</html>

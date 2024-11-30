<?php
// db.php einbinden (für die Datenbankverbindung)
require_once 'db.php';
// functions.php einbinden (für Funktionen)
require_once 'functions.php';

// Registrierung
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Benutzer erstellen
    $result = create_user($conn, $username, $password);

    // Nachricht ausgeben
    if (strpos($result, 'Fehler') !== false) {
        $error = $result;
    } else {
        $success = $result;
    }
}

// Anmeldung
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['login_username'];
    $password = $_POST['login_password'];
    
    // Benutzer einloggen
    $result = login_user($conn, $username, $password);
    
    // Nachricht ausgeben
    if (strpos($result, 'Login erfolgreich') !== false) {
        header("Location: dashboard.php"); // Weiterleitung zum Dashboard nach erfolgreichem Login
        exit;
    } else {
        $error = $result;
    }
}

// Bestimmen, ob das Registrierungs- oder Login-Formular angezeigt wird
$show_register_form = isset($_GET['form']) && $_GET['form'] === 'register';
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzeranmeldung und -registrierung</title>
    <style>
        /* Allgemeine Einstellungen */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1 {
            text-align: center;
            color: #444;
            margin-bottom: 20px;
        }

        h2 {
            color: #444;
            margin-bottom: 10px;
        }

        /* Formulareinstellungen */
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
            color: #555;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
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

        /* Fehlermeldungen */
        p {
            font-size: 14px;
            color: red;
            text-align: center;
        }

        p.success {
            color: green;
        }

        /* Trennlinie */
        hr {
            margin: 20px 0;
            border: 0;
            border-top: 1px solid #ccc;
        }

        /* Mobile Anpassung */
        @media (max-width: 480px) {
            body {
                padding: 20px;
                height: auto;
            }

            form {
                width: 100%;
                max-width: none;
            }
        }

        /* Switch-Link */
        .switch-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #3498db;
            text-decoration: none;
        }

        .switch-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Anzeige der Erfolgs- und Fehlermeldungen -->
    <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
    <?php if (isset($success)) { echo "<p class='success'>$success</p>"; } ?>
    <!-- Registrierung Formular -->
    <?php if ($show_register_form): ?>
    <form method="POST" action="">
        <h2>Registrierung</h2>
        <label for="username">Benutzername:</label>
        <input type="text" name="username" required><br><br>
        <label for="password">Passwort:</label>
        <input type="password" name="password" required><br><br>
        <button type="submit" name="register">Registrieren</button>
        <a class="switch-link" href="?form=login">Schon registriert? Jetzt einloggen</a>
    </form>
    <?php else: ?>
    <!-- Login Formular -->
    <form method="POST" action="">
        <h2>Login</h2>
        <label for="login_username">Benutzername:</label>
        <input type="text" name="login_username" required><br><br>
        <label for="login_password">Passwort:</label>
        <input type="password" name="login_password" required><br><br>
        <button type="submit" name="login">Einloggen</button>
        <a class="switch-link" href="?form=register">Noch keinen Account? Jetzt registrieren</a>
    </form>    
    <?php endif; ?>
</body>
</html>
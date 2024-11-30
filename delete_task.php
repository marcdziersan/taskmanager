<?php
// Sitzungsstart und Überprüfung der Anmeldung
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Einbindung der Datenbankverbindung und Funktionen
include 'db.php';
include 'functions.php';

// Initialisierung der Nachricht
$message = '';
$task_id = $_GET['id'] ?? null;

if (!$task_id) {
    header("Location: dashboard.php");
    exit;
}

// Aufgabe laden
$task = get_task_by_id($conn, $task_id);
if (!$task || $task['user_id'] !== $_SESSION['user_id']) {
    header("Location: dashboard.php");
    exit;
}

// Aufgabe löschen
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = delete_task($conn, $task_id);
    if ($message === "Aufgabe erfolgreich gelöscht.") {
        header("Location: dashboard.php"); // Weiterleitung zum Dashboard
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aufgabe löschen</title>
    <style>
        /* Grundlegendes Styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Hauptcontainer */
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }

        /* Titel */
        h1 {
            color: #d9534f;
            font-size: 36px;
            text-align: center;
            margin-bottom: 30px;
        }

        /* Text */
        p {
            font-size: 18px;
            text-align: center;
            color: #555;
        }

        /* Button */
        button {
            padding: 12px 20px;
            background-color: #d9534f;
            color: white;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: block;
            margin: 20px auto;
        }

        button:hover {
            background-color: #c9302c;
        }

        /* Nachricht */
        .message {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
        }

        .message.success {
            background-color: #d4edda;
            color: #155724;
        }

        .message.error {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Link */
        a {
            color: #4CAF50;
            text-decoration: none;
            font-size: 16px;
            display: block;
            text-align: center;
            margin-top: 20px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Aufgabe löschen</h1>
        
        <p>Sind Sie sicher, dass Sie die Aufgabe "<strong><?php echo htmlspecialchars($task['title']); ?></strong>" löschen möchten?</p>
        
        <!-- Löschen-Formular -->
        <form method="POST" action="">
            <button type="submit">Ja, Aufgabe löschen</button>
        </form>

        <!-- Nachricht -->
        <?php if ($message): ?>
            <div class="message <?php echo strpos($message, 'erfolgreich') !== false ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <!-- Link zurück zum Dashboard -->
        <a href="dashboard.php">Zurück zum Dashboard</a>
    </div>

</body>
</html>

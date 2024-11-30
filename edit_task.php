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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date']; // Fälligkeitsdatum aus dem Formular

    if (!empty($title)) {
        $message = update_task($conn, $task_id, $title, $description, $due_date);
        $task = get_task_by_id($conn, $task_id); // Aktualisierte Daten abrufen
    } else {
        $message = "Der Titel der Aufgabe darf nicht leer sein!";
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aufgabe bearbeiten</title>
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
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }

        /* Titel */
        h1 {
            color: #4CAF50;
            font-size: 36px;
            text-align: center;
            margin-bottom: 30px;
        }

        /* Formular */
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-size: 16px;
            color: #555;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
            transition: border-color 0.3s ease;
        }

        input:focus, textarea:focus {
            border-color: #4CAF50;
            outline: none;
        }

        /* Date Picker */
        input[type="date"]:focus {
            border-color: #4CAF50;
            outline: none;
        }

        button {
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
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
        <h1>Aufgabe bearbeiten</h1>

        <!-- Formular -->
        <form method="POST" action="">
            <label for="title">Titel:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($task['title']); ?>" required>
            
            <label for="description">Beschreibung:</label>
            <textarea id="description" name="description" rows="5"><?php echo htmlspecialchars($task['description']); ?></textarea>
            
            <!-- Fälligkeitsdatum hinzufügen -->
            <label for="due_date">Fälligkeitsdatum:</label>
            <input type="date" id="due_date" name="due_date" value="<?php echo htmlspecialchars($task['due_date']); ?>" required>

            <button type="submit">Speichern</button>
        </form>

        <!-- Nachricht -->
        <?php if ($message): ?>
            <div class="message <?php echo strpos($message, 'Fehler') !== false ? 'error' : 'success'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <!-- Link zurück zum Dashboard -->
        <a href="dashboard.php">Zurück zum Dashboard</a>
    </div>

</body>
</html>

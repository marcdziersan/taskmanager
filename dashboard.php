<?php
// Sitzungsstart und Überprüfung der Anmeldung
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Weiterleitung zur Login-Seite, falls nicht eingeloggt
    exit;
}

// Einbindung der Datenbankverbindung und Funktionen
include 'db.php';
include 'functions.php';

// Benutzerinformationen
$user_id = $_SESSION['user_id'];
$user = get_user_by_id($conn, $user_id);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
            max-width: 1200px;
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
            margin-bottom: 20px;
        }

        /* Navigation */
        nav {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 10px;
        }

        nav a {
            text-decoration: none;
            color: #4CAF50;
            font-size: 16px;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        nav a:hover {
            background-color: #e6f7e6;
        }

        /* Abschnitt für Aufgaben */
        .task-list {
            margin-top: 30px;
        }

        .task {
            background-color: #f9f9f9;
            padding: 20px;
            margin-bottom: 15px;
            border-left: 5px solid #4CAF50;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .task h3 {
            color: #333;
            font-size: 24px;
            margin: 0;
        }

        .task p {
            color: #666;
            font-size: 16px;
            margin-top: 10px;
        }

        .task small {
            display: block;
            color: #999;
            margin-top: 10px;
        }

        .task-actions {
            margin-top: 15px;
        }

        .task-actions a {
            color: #007bff;
            font-size: 16px;
            text-decoration: none;
            margin-right: 10px;
            transition: color 0.3s ease;
        }

        .task-actions a:hover {
            color: #0056b3;
        }

        .task-actions .delete {
            color: #e74c3c;
        }

        .task-actions .delete:hover {
            color: #c0392b;
        }

        .stats {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            background-color: #e7f7e7;
            padding: 15px;
            border-radius: 8px;
        }

        .stats div {
            text-align: center;
            padding: 10px;
        }

        .stats div h4 {
            margin: 0;
            color: #333;
        }

        .stats div p {
            margin-top: 5px;
            color: #555;
        }

        /* Farben für die Fälligkeit */
        .due-today {
            background-color: #f9e5b4; /* Gelb für fällige Aufgaben */
        }

        .due-now {
            background-color: #f9d16f; /* Orange für Aufgaben, die heute fällig sind */
        }

        .overdue {
            background-color: #f8c7c7; /* Rot für abgelaufene Aufgaben */
        }

    </style>
</head>
<body>

    <div class="container">
        <h1>Willkommen, <?php echo htmlspecialchars($user['username']); ?>!</h1>
        <p>Sie sind erfolgreich eingeloggt.</p>
        
        <!-- Navigation -->
        <nav>
            <a href="create_task.php">Aufgabe erstellen</a>
            <a href="logout.php">Logout</a>
        </nav>

        <!-- Statistiken -->
        <section class="stats">
            <div>
                <h4>Meine Aufgaben</h4>
                <p><?php echo count_tasks_by_user_id($conn, $user_id); ?></p>
            </div>
        </section>

        <!-- Aufgaben anzeigen -->
        <section class="task-list">
            <h2>Ihre Aufgaben</h2>
            <?php
            $tasks = get_tasks_by_user_id($conn, $user_id);
            if (empty($tasks)) {
                echo "<p>Keine Aufgaben gefunden.</p>";
            } else {
                foreach ($tasks as $task) {
                    // Fälligkeitsdatum prüfen
                    $due_date = strtotime($task['due_date']);
                    $today = strtotime(date('Y-m-d'));
                    $due_today = ($due_date === $today);
                    $overdue = ($due_date < $today);

                    // Bestimme die Klasse basierend auf dem Status der Aufgabe
                    if ($due_today) {
                        $status_class = 'due-now'; // Heute fällig
                    } elseif ($overdue) {
                        $status_class = 'overdue'; // Abgelaufen
                    } else {
                        $status_class = 'due-today'; // Fällig
                    }

                    echo '<div class="task ' . $status_class . '">';
                    echo '<h3>' . htmlspecialchars($task['title']) . '</h3>';
                    echo '<p>' . nl2br(htmlspecialchars($task['description'])) . '</p>';
                    echo '<small>Erstellt am: ' . htmlspecialchars($task['created_at']) . ' | Fällig am: ' . htmlspecialchars($task['due_date']) . '</small>';
                    echo '<div class="task-actions">';
                    echo '<a href="edit_task.php?id=' . $task['id'] . '">Bearbeiten</a>';
                    echo ' | <a class="delete" href="delete_task.php?id=' . $task['id'] . '">Löschen</a>';
                    echo '</div>';
                    echo '</div>';
                }
            }
            ?>
        </section>
    </div>

</body>
</html>

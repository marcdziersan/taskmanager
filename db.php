<?php
// Datenbankkonfigurationsvariablen
$host = 'localhost'; // Hostname
$user = 'root'; // Datenbank-Benutzer
$pass = ''; // Datenbank-Passwort
$db = 'user_task_management'; // Name der Datenbank

// Verbindung zur Datenbank herstellen
$conn = new mysqli($host, $user, $pass, $db);

// Fehlerprüfung der Verbindung
if ($conn->connect_error) {
    die("Datenbankverbindung fehlgeschlagen: " . $conn->connect_error);
}

// Charset setzen
$conn->set_charset("utf8mb4");

// Globale Zugriffsfunktion für Verbindungsprüfung
function db_check_connection($conn) {
    if (!$conn || $conn->connect_error) {
        die("Es besteht ein Problem mit der Datenbankverbindung.");
    }
}
?>

<?php
// Funktionen für User- und Aufgabenverwaltung

// -------------------------
// User-Funktionen
// -------------------------

// User anlegen
function create_user($conn, $username, $password) {
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password_hash);

    if ($stmt->execute()) {
        return "User erfolgreich angelegt!";
    } else {
        return "Fehler beim Anlegen des Users: " . $stmt->error;
    }
}

// User anmelden
// Benutzer-Login
function login_user($conn, $username, $password) {
    // Benutzer anhand des Benutzernamens suchen
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Benutzer gefunden
        $user = $result->fetch_assoc();
        
        // Passwort überprüfen
        if (password_verify($password, $user['password'])) {
            // Sitzung starten
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            return "Login erfolgreich!";
        } else {
            return "Ungültiges Passwort.";
        }
    } else {
        return "Benutzer nicht gefunden.";
    }
}

// User anzeigen (alle)
function get_all_users($conn) {
    $stmt = $conn->prepare("SELECT id, username, created_at FROM users");
    $stmt->execute();
    $result = $stmt->get_result();

    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    return $users;
}

// User anzeigen (id)
function get_user_by_id($conn, $user_id) {
    $stmt = $conn->prepare("SELECT id, username, created_at FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc();
}

// User bearbeiten (id)
function update_user($conn, $user_id, $username, $password = null) {
    if ($password) {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
        $stmt->bind_param("ssi", $username, $password_hash, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET username = ? WHERE id = ?");
        $stmt->bind_param("si", $username, $user_id);
    }

    if ($stmt->execute()) {
        return "User erfolgreich aktualisiert!";
    } else {
        return "Fehler beim Aktualisieren des Users: " . $stmt->error;
    }
}

// User löschen (id)
function delete_user($conn, $user_id) {
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        return "User erfolgreich gelöscht!";
    } else {
        return "Fehler beim Löschen des Users: " . $stmt->error;
    }
}

// Anzahl der Benutzer zählen
function count_users($conn) {
    $stmt = $conn->prepare("SELECT COUNT(*) AS total_users FROM users");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['total_users'];
}

// -------------------------
// Aufgaben-Funktionen
// -------------------------

// Aufgabe anlegen
function create_task($conn, $user_id, $title, $description, $due_date) {
    $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, description, due_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $title, $description, $due_date);

    if ($stmt->execute()) {
        return "Aufgabe erfolgreich angelegt!";
    } else {
        return "Fehler beim Anlegen der Aufgabe: " . $stmt->error;
    }
}

// Aufgabe anzeigen (alle)
function get_all_tasks($conn) {
    $stmt = $conn->prepare("SELECT id, user_id, title, description, due_date, created_at FROM tasks");
    $stmt->execute();
    $result = $stmt->get_result();

    $tasks = [];
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }

    return $tasks;
}

// Aufgabe anzeigen (id)
function get_task_by_id($conn, $task_id) {
    $stmt = $conn->prepare("SELECT id, user_id, title, description, due_date, created_at FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc();
}

// Aufgaben anzeigen (user id)
function get_tasks_by_user_id($conn, $user_id) {
    $stmt = $conn->prepare("SELECT id, title, description, due_date, created_at FROM tasks WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $tasks = [];
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }

    return $tasks;
}

// Aufgabe bearbeiten (id)
function update_task($conn, $task_id, $title, $description, $due_date) {
    $stmt = $conn->prepare("UPDATE tasks SET title = ?, description = ?, due_date = ? WHERE id = ?");
    $stmt->bind_param("sssi", $title, $description, $due_date, $task_id);

    if ($stmt->execute()) {
        return "Aufgabe erfolgreich aktualisiert!";
    } else {
        return "Fehler beim Aktualisieren der Aufgabe: " . $stmt->error;
    }
}

// Aufgabe löschen (id)
function delete_task($conn, $task_id) {
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $task_id);

    if ($stmt->execute()) {
        return "Aufgabe erfolgreich gelöscht!";
    } else {
        return "Fehler beim Löschen der Aufgabe: " . $stmt->error;
    }
}

// Anzahl der Aufgaben zählen
function count_tasks($conn) {
    $stmt = $conn->prepare("SELECT COUNT(*) AS total_tasks FROM tasks");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['total_tasks'];
}

// Anzahl der Aufgaben für einen bestimmten Benutzer zählen
function count_tasks_by_user_id($conn, $user_id) {
    $stmt = $conn->prepare("SELECT COUNT(*) AS total_tasks FROM tasks WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['total_tasks'];
}

?>
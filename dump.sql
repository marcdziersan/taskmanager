-- Erstellen der Datenbank (falls sie noch nicht existiert)
CREATE DATABASE IF NOT EXISTS user_task_management;

-- Nutzung der erstellten Datenbank
USE user_task_management;

-- Tabelle "users" erstellen
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,           -- Eindeutige ID für jeden Benutzer
    username VARCHAR(100) NOT NULL UNIQUE,       -- Benutzername (muss eindeutig sein)
    password VARCHAR(255) NOT NULL,              -- Gehashtes Passwort
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Zeitpunkt der Erstellung
);

-- Tabelle "tasks" erstellen
CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,           -- Eindeutige ID für jede Aufgabe
    user_id INT NOT NULL,                        -- ID des zugeordneten Benutzers
    title VARCHAR(255) NOT NULL,                 -- Titel der Aufgabe
    description TEXT,                            -- Beschreibung der Aufgabe
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Zeitpunkt der Erstellung
    FOREIGN KEY (user_id) REFERENCES users(id)   -- Fremdschlüssel: Verknüpfung mit der Tabelle "users"
        ON DELETE CASCADE                        -- Aufgaben löschen, wenn der Benutzer gelöscht wird
);

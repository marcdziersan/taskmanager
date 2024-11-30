
# Aufgabenverwaltung - Lernvorlage

Dieses Projekt stellt eine einfache Aufgabenverwaltungsanwendung dar, die als Lernvorlage für Anfänger dient. Es ist keine fertige Anwendung, sondern ein praktisches Beispiel, um grundlegende Webentwicklungskonzepte wie PHP, MySQL und einfache CRUD-Operationen zu erlernen.

## Funktionen

- **Benutzerregistrierung und -authentifizierung:**
  - Registrieren und Einloggen von Benutzern.
  - Sitzungsverwaltung mit PHP-Sessions.

- **CRUD für Aufgaben:**
  - Erstellen, Bearbeiten und Löschen von Aufgaben.
  - Aufgaben anzeigen und nach Benutzer filtern.
  - Fälligkeitsanzeige für Aufgaben mit farblicher Hervorhebung:
    - **Gelb**: Bald fällig.
    - **Orange**: Heute fällig.
    - **Rot**: Überfällig.

- **Responsive Benutzeroberfläche:**
  - Modernes und einfaches Styling mit CSS.

## Dateistruktur

| Datei              | Beschreibung                                     |
|--------------------|-------------------------------------------------|
| `README.md`        | Projektbeschreibung und Anweisungen.            |
| `index.php`        | Startseite oder Landing Page des Projekts.      |
| `login.php`        | Login-Formular und Sitzungsstart.               |
| `register.php`     | Registrierungsformular für neue Benutzer.       |
| `dashboard.php`    | Benutzer-Dashboard mit Aufgabenübersicht.       |
| `create_task.php`  | Formular zum Erstellen neuer Aufgaben.          |
| `edit_task.php`    | Formular zum Bearbeiten bestehender Aufgaben.   |
| `delete_task.php`  | Skript zum Löschen einer Aufgabe.               |
| `logout.php`       | Logout-Skript zur Beendigung der Sitzung.       |
| `db.php`           | Datenbankverbindung und Konfiguration.          |
| `functions.php`    | Hilfsfunktionen für Datenbankoperationen.       |
| `dump.sql`         | Beispiel-Datenbank-Dump zum Importieren.        |

## Installation

### Voraussetzungen

- PHP 7.4 oder höher
- MySQL
- Ein lokaler Webserver (z. B. XAMPP, MAMP, WAMP)

### Schritte

1. Klone das Repository:
   ```bash
   git clone https://github.com/marcdziersan/taskmanager.git
   ```
2. Importiere die Datenbank:
   - Nutze die Datei `dump.sql`, um die MySQL-Datenbank zu erstellen.
3. Konfiguriere die Datenbankverbindung:
   - Passe die Datei `db.php` an, um deine lokalen Datenbankzugangsdaten einzutragen.
4. Starte einen lokalen Server und öffne die Anwendung im Browser.

## Hinweise

- **Lernfokus**: Dieses Projekt dient ausschließlich zu Lernzwecken und sollte nicht in Produktionsumgebungen verwendet werden.
- **Erweiterung**: Du kannst das Projekt erweitern, um zusätzliche Funktionen wie Benutzerrollen, Prioritäten für Aufgaben oder eine REST-API zu implementieren.

## Vorschläge zur Verbesserung

- Integration eines Frameworks wie Laravel oder Symfony.
- Nutzung eines Frontend-Frameworks wie React oder Vue.js.
- Verbesserung der Sicherheit (z. B. Passwort-Hashing, CSRF-Schutz).

---

Viel Erfolg beim Lernen und Erweitern dieser Vorlage! 🎓

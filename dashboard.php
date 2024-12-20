<?php
session_start(); // Inicjalizacja sesji

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Przekierowanie na stronę logowania
    exit();
}

// Połączenie z bazą danych
$host = "127.0.0.1";
$user = "root"; // Twój użytkownik bazy danych
$password = ""; // Twoje hasło bazy danych
$dbname = "todo";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id']; // ID zalogowanego użytkownika
$user_login = $_SESSION['user_login'];

// Pobranie notatek dla zalogowanego użytkownika
$stmt = $conn->prepare("SELECT * FROM notatka WHERE Uzytkownik_id = ? ORDER BY Priorytet ASC, notatka_id DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Podział notatek na priorytety
$notes = ['1' => [], '2' => [], '3' => []];
while ($row = $result->fetch_assoc()) {
    $notes[$row['Priorytet']][] = $row;
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* Stylowanie ogólne */
        /* Globalne style */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #b39b6f;
    color: #000;
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 300px; /* 3 kolumny na notatki + 1 na guziki */
    grid-template-rows: auto 1fr; /* Pierwsza linia z przyciskami, druga na notatki */
    gap: 20px;
    min-height: 100vh;
}

/* Kontenery kolumn */
.column {
    background-color: #d6c7a1;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.column h2 {
    text-align: center;
    margin-bottom: 15px;
    font-size: 18px;
    color: #000;
}

/* Notatki */
.note {
    background-color: #f0e9d7;
    padding: 15px;
    margin-bottom: 10px;
    border-radius: 5px;
    border-left: 5px solid;
    position: relative;
}

.note.prio-1 {
    border-left-color: #e74c3c;
}

.note.prio-2 {
    border-left-color: #f1c40f;
}

.note.prio-3 {
    border-left-color: #2ecc71;
}

/* Styl dla notatek oznaczonych jako "zrobione" */
.note.done h3,
.note.done p {
    text-decoration: line-through;
    color: #777; /* Przyciemnienie tekstu */
}

/* Przycisk "Usuń" */
.delete-button {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #e74c3c;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 5px 10px;
    cursor: pointer;
    font-size: 12px;
}

.delete-button:hover {
    background-color: #c0392b;
}

/* Przycisk "Zrobione" */
.btn-done {
    margin-top: 10px;
    display: inline-block;
    background-color: #3498db;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 5px 10px;
    cursor: pointer;
    font-size: 12px;
}

.btn-done:hover {
    background-color: #2980b9;
}

/* Sekcja przycisków */
.buttons {
    grid-column: span 4; /* Zajmuje całą szerokość */
    background-color: #d6c7a1;
    padding: 20px;
    display: flex;
    flex-direction: column; /* Ustawia elementy pionowo */
    align-items: center;
    gap: 10px; /* Dodaje przestrzeń pomiędzy przyciskami */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
}

/* Stylowanie przycisków w sekcji "buttons" */
.buttons a {
    text-decoration: none;
    color: #fff;
    background-color: #a37b4a;
    padding: 10px 15px;
    border-radius: 5px;
    transition: background-color 0.3s;
    width: 100%; /* Sprawia, że przycisk zajmuje całą szerokość */
    text-align: center; /* Wyrównuje tekst wewnątrz przycisku */
}

.buttons a:hover {
    background-color: #8a6533;
}
/* Styl kontenera dla przycisków w notatce */
.note-buttons {
    display: flex;
    flex-direction: column; /* Ustawia przyciski pionowo */
    gap: 5px; /* Odstęp między przyciskami */
    position: absolute;
    top: 10px;
    right: 10px;
}

/* Przycisk "Usuń" */
.delete-button {
    background-color: #e74c3c;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 5px 10px;
    cursor: pointer;
    font-size: 12px;
}

.delete-button:hover {
    background-color: #c0392b;
}

/* Przycisk "Zrobione" */
.btn-done {
    background-color: #3498db;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 5px 10px;
    cursor: pointer;
    font-size: 12px;
}

.btn-done:hover {
    background-color: #2980b9;
}

        
    </style>
</head>
<body>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-done').forEach(button => {
        button.addEventListener('click', function () {
            const notatkaId = this.dataset.id;
            const zrobione = this.dataset.zrobione;

            fetch('zrobione_notatka.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `notatka_id=${notatkaId}&zrobione=${zrobione}`
            })
            .then(response => response.text())
            .then(result => {
                if (result === 'success') {
                    location.reload(); // Odśwież stronę po sukcesie
                } else {
                    alert('Wystąpił błąd podczas aktualizacji notatki.');
                }
            });
        });
    });
});
</script>

    <!-- Sekcja z notatkami -->
    <div class="column">
    <h2>Ważne</h2>
    <?php if (!empty($notes['1'])): ?>
        <?php foreach ($notes['1'] as $note): ?>
            <div class="note prio-1 <?php echo $note['zrobione'] ? 'done' : ''; ?>">
                <h3><?php echo htmlspecialchars($note['Nazwa_Notatki']); ?></h3>
                <p><?php echo htmlspecialchars($note['Tresc']); ?></p>
                
                <!-- Przycisk "Usuń" -->
                <form method="POST" action="usun_notatke.php" style="display: inline-block;">
                    <input type="hidden" name="notatka_id" value="<?php echo $note['notatka_id']; ?>">
                    <button type="submit" class="delete-button">Usuń</button>
                </form>

                <!-- Przycisk "Zrobione" -->
                <button 
                    class="btn-done" 
                    data-id="<?php echo $note['notatka_id']; ?>" 
                    data-zrobione="<?php echo $note['zrobione'] ? 0 : 1; ?>">
                    <?php echo $note['zrobione'] ? 'Oznacz jako niezrobione' : 'Zrobione'; ?>
                </button>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Brak notatek o ważnym priorytecie.</p>
    <?php endif; ?>
</div>


<div class="column">
    <h2>Średnie</h2>
    <?php if (!empty($notes['2'])): ?>
        <?php foreach ($notes['2'] as $note): ?>
            <div class="note prio-2 <?php echo $note['zrobione'] ? 'done' : ''; ?>">
                <h3><?php echo htmlspecialchars($note['Nazwa_Notatki']); ?></h3>
                <p><?php echo htmlspecialchars($note['Tresc']); ?></p>
                
                <!-- Przycisk "Usuń" -->
                <form method="POST" action="usun_notatke.php" style="display: inline-block;">
                    <input type="hidden" name="notatka_id" value="<?php echo $note['notatka_id']; ?>">
                    <button type="submit" class="delete-button">Usuń</button>
                </form>

                <!-- Przycisk "Zrobione" -->
                <button 
                    class="btn-done" 
                    data-id="<?php echo $note['notatka_id']; ?>" 
                    data-zrobione="<?php echo $note['zrobione'] ? 0 : 1; ?>">
                    <?php echo $note['zrobione'] ? 'Oznacz jako niezrobione' : 'Zrobione'; ?>
                </button>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Brak notatek o średnim priorytecie.</p>
    <?php endif; ?>
</div>

<!-- Sekcja Mało Ważne -->
<div class="column">
    <h2>Mało ważne</h2>
    <?php if (!empty($notes['3'])): ?>
        <?php foreach ($notes['3'] as $note): ?>
            <div class="note prio-3 <?php echo $note['zrobione'] ? 'done' : ''; ?>">
                <h3><?php echo htmlspecialchars($note['Nazwa_Notatki']); ?></h3>
                <p><?php echo htmlspecialchars($note['Tresc']); ?></p>
                
                <!-- Przycisk "Usuń" -->
                <form method="POST" action="usun_notatke.php" style="display: inline-block;">
                    <input type="hidden" name="notatka_id" value="<?php echo $note['notatka_id']; ?>">
                    <button type="submit" class="delete-button">Usuń</button>
                </form>

                <!-- Przycisk "Zrobione" -->
                <button 
                    class="btn-done" 
                    data-id="<?php echo $note['notatka_id']; ?>" 
                    data-zrobione="<?php echo $note['zrobione'] ? 0 : 1; ?>">
                    <?php echo $note['zrobione'] ? 'Oznacz jako niezrobione' : 'Zrobione'; ?>
                </button>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Brak notatek o małym priorytecie.</p>
    <?php endif; ?>
</div>

        <div class="column4">
                <div class="buttons">
                <span>Witaj, <?php echo htmlspecialchars($_SESSION['user_login']); ?>!</span>
                <a href="dodaj.php">Dodaj Notatkę</a>
                <a href="wyloguj.php">Wyloguj się</a>
            </div>
        </div>
    </div>
</body>
</html>

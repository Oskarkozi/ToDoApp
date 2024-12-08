<?php
session_start();

// Sprawdź, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_login = $_SESSION['user_login'];

$success_message = ""; // Zmienna na komunikat o sukcesie

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nazwa_notatki = trim($_POST['nazwa_notatki']);
    $tresc = trim($_POST['tresc']);
    $priorytet = (int)$_POST['priorytet'];

    // Połączenie z bazą danych
    $conn = new mysqli('localhost', 'root', '', 'todo');

    if ($conn->connect_error) {
        die("Błąd połączenia z bazą danych: " . $conn->connect_error);
    }

    // Dodaj dane do bazy
    $stmt = $conn->prepare("INSERT INTO notatka (Nazwa_Notatki, Tresc, Priorytet, Uzytkownik_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $nazwa_notatki, $tresc, $priorytet, $user_id);

    if ($stmt->execute()) {
        $success_message = "Notatka została dodana pomyślnie!";
    } else {
        echo "<p>Błąd podczas dodawania notatki: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Dodaj Notatkę</title>
    <style>
        .success-message {
            color: #2e7d32; /* Zielony kolor */
            background-color: #c8e6c9; /* Jasnozielone tło */
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1>Witaj, <?php echo htmlspecialchars($user_login); ?>!</h1>
        
        <!-- Wyświetlenie komunikatu sukcesu -->
        <?php if (!empty($success_message)): ?>
            <div class="success-message"><?php echo htmlspecialchars($success_message); ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <label for="note-name">Nazwa notatki:</label>
            <input type="text" id="note-name" name="nazwa_notatki" placeholder="Wpisz nazwę notatki" required>

            <label for="note-content">Treść:</label>
            <textarea id="note-content" name="tresc" placeholder="Wpisz treść notatki" required></textarea>

            <label for="priority">Priorytet:</label>
            <input type="number" id="priority" name="priorytet" min="1" max="3" required>

            <button type="submit">Dodaj Notatkę</button>
        </form>

        <a href="dashboard.php"><button>Wróć do notatek</button></a>
    </div>
</body>
</html>

<?php
session_start();

// Sprawdź, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Połączenie z bazą danych
$conn = new mysqli('localhost', 'root', '', 'todo');
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

// Pobranie danych z żądania
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $notatka_id = intval($_POST['notatka_id']);
    $zrobione = intval($_POST['zrobione']);

    // Aktualizacja pola "zrobione"
    $stmt = $conn->prepare("UPDATE notatka SET zrobione = ? WHERE notatka_id = ?");
    $stmt->bind_param("ii", $zrobione, $notatka_id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
}

$conn->close();
?>

<?php
session_start(); // Rozpoczęcie sesji

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Przekierowanie na stronę logowania
    exit();
}

// Sprawdzenie, czy przekazano ID notatki
if (!isset($_POST['notatka_id'])) {
    die("Brak ID notatki do usunięcia.");
}

$notatka_id = intval($_POST['notatka_id']); // ID notatki do usunięcia

// Połączenie z bazą danych
$host = "127.0.0.1";
$user = "root"; // Twój użytkownik bazy danych
$password = ""; // Twoje hasło bazy danych
$dbname = "todo";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

// Usuwanie notatki, jeśli należy do zalogowanego użytkownika
$user_id = $_SESSION['user_id']; // ID zalogowanego użytkownika

$stmt = $conn->prepare("DELETE FROM notatka WHERE notatka_id = ? AND Uzytkownik_id = ?");
$stmt->bind_param("ii", $notatka_id, $user_id);

if ($stmt->execute()) {
    // Notatka została usunięta
    header("Location: dashboard.php"); // Przekierowanie na dashboard
    exit();
} else {
    // Błąd podczas usuwania
    echo "Nie udało się usunąć notatki. Spróbuj ponownie później.";
}

$stmt->close();
$conn->close();
?>

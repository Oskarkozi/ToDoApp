<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_POST['notatka_id'])) {
    die("Brak ID notatki.");
}

$notatka_id = intval($_POST['notatka_id']);
$host = "127.0.0.1";
$user = "root";
$password = "";
$dbname = "todo";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("UPDATE notatka SET zrobione = NOT zrobione WHERE notatka_id = ? AND Uzytkownik_id = ?");
$stmt->bind_param("ii", $notatka_id, $user_id);

if ($stmt->execute()) {
    header("Location: dashboard.php");
    exit();
} else {
    echo "Błąd zmiany statusu notatki.";
}

$stmt->close();
$conn->close();
?>

<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_login = $_SESSION['user_login'];
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Witaj, <?php echo htmlspecialchars($user_login); ?>!</h1>
        <p>Twój ID użytkownika: <?php echo htmlspecialchars($user_id); ?></p>

        <!-- Button to redirect to dodaj.php -->
        <a href="dodaj.php"><button>Dodaj nowe dane</button></a>

    </div>
</body>
</html>

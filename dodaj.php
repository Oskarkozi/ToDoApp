<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj dane</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
        <?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $info = $_POST['dane']; // Get the 'dane' field from the form

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'tozrob');

    // Check connection
    if ($conn->connect_error) {
        die("Połączenie zerwane: " . $conn->connect_error);
    }

    // Prepare the SQL statement to insert the new data
    $stmt = $conn->prepare("INSERT INTO dane (Id_uzytkownika, Info) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $info);
    if ($stmt->execute()) {
        echo "<p style='color: green; text-align: center;'>Dane zostały dodane!</p>";
    } else {
        echo "<p style='color: red; text-align: center;'>Wystąpił błąd. Spróbuj ponownie.</p>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
            <h1>Dodaj nowe dane</h1>
            <!-- Form to submit new data -->
            <form action="dodaj.php" method="POST">
                <input type="text" placeholder="Wpisz dane" name="dane" required>
                <button type="submit">Wyślij</button>
            </form>
            <br>
            <a href="dashboard.php"><button>Wróć do dashboardu</button></a>
        </div>
    </div>
</body>
</html>

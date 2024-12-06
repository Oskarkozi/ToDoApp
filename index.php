<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToZrob - Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h1>ToZrob</h1>
            <?php
session_start(); // Start the session at the top of the file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $haslo = $_POST['password'];

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'tozrob');

    // Check connection
    if ($conn->connect_error) {
        die("Połączenie zerwane: " . $conn->connect_error);
    }

    // Prepare the SQL statement to fetch the user
    $stmt = $conn->prepare("SELECT * FROM uzytkownicy WHERE Login = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Check if user exists and if the password matches
    if ($user && $user['Password'] === $haslo) {
        // Store the user's ID in the session
        $_SESSION['user_id'] = $user['Id'];
        $_SESSION['user_login'] = $user['Login']; // You can also store the username if needed

        // Redirect to dashboard.php
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<p style='color: red; text-align: center;'>Nieprawidłowy login lub hasło. Spróbuj ponownie.</p>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

            <!-- Formularz wysyła dane do login.php za pomocą POST -->
            <form action="index.php" method="POST">
                <input type="text" placeholder="Login" name="login" required>
                <input type="password" placeholder="Hasło" name="password" required>
                <button type="submit">Zaloguj się</button>
            </form>
            <br><a href="Rejestracja.php"> <button>Nie masz konta? zalóż</button></a>
        </div>
    </div>
</body>
</html> 
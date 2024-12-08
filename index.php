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
            session_start();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $login = trim($_POST['login']);
                $haslo = trim($_POST['password']);

                $conn = new mysqli('localhost', 'root', '', 'todo');

                if ($conn->connect_error) {
                    die("<p style='color: red; text-align: center;'>Błąd połączenia z bazą danych: " . $conn->connect_error . "</p>");
                }

                $stmt = $conn->prepare("SELECT * FROM uzytkownicy WHERE Login = ?");
                $stmt->bind_param("s", $login);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();

                if ($user && $user['Haslo'] === $haslo) { // Sprawdzanie hasła w formie jawnej
                    $_SESSION['user_id'] = $user['uzytkownik_id'];
                    $_SESSION['user_login'] = $user['Login'];
                    header("Location: dashboard.php");
                    exit();
                } else {
                    echo "<p style='color: red; text-align: center;'>Nieprawidłowy login lub hasło. Spróbuj ponownie.</p>";
                }

                $stmt->close();
                $conn->close();
            }
            ?>

            <form action="index.php" method="POST">
                <input type="text" placeholder="Login" name="login" required>
                <input type="password" placeholder="Hasło" name="password" required>
                <button type="submit">Zaloguj się</button>
            </form>
            <br><a href="rejestracja.php"><button type="button">Nie masz konta? Załóż</button></a>
        </div>
    </div>
</body>
</html>

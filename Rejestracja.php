<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToZrob - Rejestracja</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h1>Zarejestruj się</h1>

            <?php
            if (isset($_POST['submit'])) {
                $login = trim($_POST['login']);
                $haslo = trim($_POST['password']);
                $hasloPotwierdz = trim($_POST['confirm_password']);

                $conn = new mysqli('localhost', 'root', '', 'todo');

                if ($conn->connect_error) {
                    die("<p style='color: red; text-align: center;'>Błąd połączenia z bazą danych: " . $conn->connect_error . "</p>");
                }

                if ($haslo !== $hasloPotwierdz) {
                    echo "<p style='color: red; text-align: center;'>Hasła nie są identyczne! Spróbuj ponownie.</p>";
                } else {
                    $stmt = $conn->prepare("SELECT COUNT(*) FROM uzytkownicy WHERE Login = ?");
                    $stmt->bind_param("s", $login);
                    $stmt->execute();
                    $stmt->bind_result($count);
                    $stmt->fetch();
                    $stmt->close();

                    if ($count > 0) {
                        echo "<p style='color: red; text-align: center;'>Użytkownik o podanym loginie już istnieje. Wybierz inny login.</p>";
                    } else {
                        $stmt = $conn->prepare("INSERT INTO uzytkownicy (Login, Haslo) VALUES (?, ?)");
                        $stmt->bind_param("ss", $login, $haslo);

                        if ($stmt->execute()) {
                            echo "<p style='color: green; text-align: center;'>Rejestracja udana! Możesz się teraz zalogować.</p>";
                        } else {
                            echo "<p style='color: red; text-align: center;'>Wystąpił błąd podczas rejestracji. Spróbuj ponownie później.</p>";
                        }

                        $stmt->close();
                    }
                }

                $conn->close();
            }
            ?>

            <form action="rejestracja.php" method="POST">
                <input type="text" placeholder="Login" name="login" required>
                <input type="password" placeholder="Hasło" name="password" required>
                <input type="password" placeholder="Potwierdź hasło" name="confirm_password" required>
                <button type="submit" name="submit">Zarejestruj się</button>
            </form>
            <br>
            <a href="index.php"><button type="button">Zaloguj się</button></a>
        </div>
    </div>
</body>
</html>

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

            if(isset($_POST['submit'])){
                $login = $_POST['login'];
                $haslo = $_POST['password'];
                $hasloPotwierdz = $_POST['confirm_password'];

                $conn = new mysqli('localhost', 'root', '', 'tozrob');
                if ($conn->connect_error) {
                    die("Połączenie zerwane: " . $conn->connect_error);
                } else {
                if ($haslo != $hasloPotwierdz) {
                    echo "<p style='color: red; text-align: center;'>Hasła nie są identyczne! Spróbuj ponownie.</p>";
                } else {

                    $stmt = $conn->prepare("insert into uzytkownicy(Login,Password)values(?,?)");
                    $stmt->bind_param("ss",$login,$haslo);
                    $stmt->execute();
                    echo "<p style='color: green; text-align: center;'>Rejestracja udana!</p>";
                    $stmt->close();
                    $conn->close();
                }
            }
        }
            ?>

            <!-- Formularz rejestracyjny -->
            <form action="rejestracja.php" method="POST">
                <input type="text" placeholder="Login" name="login" required>
                <input type="password" placeholder="Hasło" name="password" required>
                <input type="password" placeholder="Potwierdź hasło" name="confirm_password" required>
                <button type="submit" name="submit">Zarejestruj się</button>
                
            </form>
            <br><a href="index.php"> <button>Zaloguj się</button></a>
        </div>
    </div>
</body>
</html>

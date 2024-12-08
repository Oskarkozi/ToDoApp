<?php
session_start(); // Rozpoczynamy sesję

// Usuwamy wszystkie zmienne sesyjne
session_unset();

// Zniszczamy sesję
session_destroy();

// Przekierowujemy użytkownika na stronę logowania (index.php)
header("Location: index.php");
exit();
?>

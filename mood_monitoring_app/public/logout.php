<?php
session_start();
session_destroy(); // Niszczenie sesji
header('Location: login.php'); // Przekierowanie do ekranu logowania
exit();
?>

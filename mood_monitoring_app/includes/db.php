<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "moodapp_db";

// Utworzenie połączenia
$conn = new mysqli($servername, $username, $password, $dbname);

// Sprawdzenie połączenia
if ($conn->connect_error) {
  die("Połączenie nieudane: " . $conn->connect_error);
}
?>
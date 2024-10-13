<?php
include('../includes/db.php');
include('../includes/auth.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['register'])) {
        // Rejestracja
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $conn->query("INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')");
        echo "Rejestracja zakończona sukcesem!";
    } elseif (isset($_POST['login'])) {
        // Logowanie
        if (login($_POST['email'], $_POST['password'])) {
            header('Location: dashboard.php');
        } else {
            echo "Błędne dane logowania.";
        }
    }
}
?>

<form method="POST">
    <h2>Zarejestruj się</h2>
    <input type="text" name="username" placeholder="Nazwa użytkownika" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Hasło" required>
    <button type="submit" name="register">Zarejestruj się</button>
</form>

<form method="POST">
    <h2>Zaloguj się</h2>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Hasło" required>
    <button type="submit" name="login">Zaloguj się</button>
</form>

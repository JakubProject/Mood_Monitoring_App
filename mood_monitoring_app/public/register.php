<?php
include('../includes/db.php');
include('../includes/auth.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Sprawdzenie, czy email już istnieje
    $result = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($result->num_rows > 0) {
        $error = "Email jest już zarejestrowany.";
    } else {
        // Dodanie nowego użytkownika
        $conn->query("INSERT INTO users (email, password) VALUES ('$email', '$password')");
        
        // Po rejestracji przekierowanie do logowania
        header('Location: login.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Register</title>
</head>
<body>
    <div class="login-container">
        <h2>Register</h2>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
        <a href="login.php">Login</a>
    </div>
</body>
</html>

<?php
include('../includes/db.php');
include('../includes/auth.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (login($_POST['email'], $_POST['password'])) {
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Błędny email lub hasło.";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <a href="register.php">Register</a>
    </div>
</body>
</html>

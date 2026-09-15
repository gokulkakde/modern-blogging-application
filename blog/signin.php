<?php
require_once __DIR__ . '/config/constants.php';

// if user is already logged in, redirect to admin
if (isset($_SESSION['user-id'])) {
    header('location: ' . ROOT_URL . 'admin/');
    die();
}

$username_email = $_SESSION['signin-data']['username_email'] ?? null;
$password = $_SESSION['signin-data']['password'] ?? null;

unset($_SESSION['signin-data']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - College Blogs</title>
    <!-- CUSTOM STYLESHEET -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css">
    <!-- ICONSCOUT CDN -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <!-- GOOGLE FONT (Montserrat) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Sign In</h2>
        <?php if (isset($_SESSION['signup-success'])) : ?>
            <div class="alert__message success">
                <p>
                    <?= htmlspecialchars($_SESSION['signup-success']);
                    unset($_SESSION['signup-success']); ?>
                </p>
            </div>
        <?php elseif (isset($_SESSION['signin'])) : ?>
            <div class="alert__message error">
                <p>
                    <?= htmlspecialchars($_SESSION['signin']);
                    unset($_SESSION['signin']); ?>
                </p>
            </div>
        <?php endif ?>
        <form action="<?= ROOT_URL ?>signin-logic.php" method="POST">
            <input type="text" name="username_email" value="<?= htmlspecialchars($username_email ?? '') ?>" placeholder="Username or Email" required>
            <input type="password" name="password" value="<?= htmlspecialchars($password ?? '') ?>" placeholder="Password" required>
            <button type="submit" name="submit" class="btn">Sign In</button>
            <small>Don't have an account? <a href="<?= ROOT_URL ?>signup.php">Sign Up</a></small>
        </form>
    </div>
</section>
</body>
</html>
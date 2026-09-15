<?php
require_once __DIR__ . '/config/constants.php';

// if user is already logged in, redirect to admin
if (isset($_SESSION['user-id'])) {
    header('location: ' . ROOT_URL . 'admin/');
    die();
}

// get back form data if there was a registration error
$firstname = $_SESSION['signup-data']['firstname'] ?? null;
$lastname = $_SESSION['signup-data']['lastname'] ?? null;
$username = $_SESSION['signup-data']['username'] ?? null;
$email = $_SESSION['signup-data']['email'] ?? null;
$createpassword = $_SESSION['signup-data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['signup-data']['confirmpassword'] ?? null;

// delete signup data session
unset($_SESSION['signup-data']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - College Blogs</title>
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
        <h2>Sign Up</h2>
        <?php if(isset($_SESSION['signup'])): ?> 
        <div class="alert__message error">
            <p>
                <?= htmlspecialchars($_SESSION['signup']);
                unset($_SESSION['signup']);
                ?>
            </p>
        </div>
        <?php endif ?>
        <form action="<?= ROOT_URL ?>signup-logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" name="firstname" value="<?= htmlspecialchars($firstname ?? '') ?>" placeholder="First Name" required>
            <input type="text" name="lastname" value="<?= htmlspecialchars($lastname ?? '') ?>" placeholder="Last Name" required>
            <input type="text" name="username" value="<?= htmlspecialchars($username ?? '') ?>" placeholder="Username" required>
            <input type="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" placeholder="Email" required>
            <input type="password" name="createpassword" value="<?= htmlspecialchars($createpassword ?? '') ?>" placeholder="Create Password" required>
            <input type="password" name="confirmpassword" value="<?= htmlspecialchars($confirmpassword ?? '') ?>" placeholder="Confirm Password" required>
            <div class="form__control">
                <label for="avatar">User Avatar</label>
                <input type="file" name="avatar" id="avatar" required>
            </div>
            <button type="submit" name="submit" class="btn">Sign Up</button>
            <small>Already have an account? <a href="<?= ROOT_URL ?>signin.php">Sign In</a></small>
        </form>
    </div>
</section>
</body>
</html>
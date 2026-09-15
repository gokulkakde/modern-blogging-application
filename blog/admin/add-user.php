<?php
require_once __DIR__ . '/partials/header.php';

// check if user is admin
if (!isset($_SESSION['user_is_admin'])) {
    header('location: ' . ROOT_URL . 'admin/');
    die();
}

// get back form data if there was an error
$firstname = $_SESSION['add-user-data']['firstname'] ?? null;
$lastname = $_SESSION['add-user-data']['lastname'] ?? null;
$username = $_SESSION['add-user-data']['username'] ?? null;
$email = $_SESSION['add-user-data']['email'] ?? null;
$createpassword = $_SESSION['add-user-data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['add-user-data']['confirmpassword'] ?? null;

// delete session data
unset($_SESSION['add-user-data']);
?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Add User</h2>
        <?php if(isset($_SESSION['add-user'])) : ?>
            <div class="alert__message error">
                <p>
                    <?= htmlspecialchars($_SESSION['add-user']);
                    unset($_SESSION['add-user']);
                    ?>
                </p>
            </div>
        <?php endif ?>
        <form action="<?= ROOT_URL ?>admin/add-user-logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" name="firstname" value="<?= htmlspecialchars($firstname ?? '') ?>" placeholder="First Name" required>
            <input type="text" name="lastname" value="<?= htmlspecialchars($lastname ?? '') ?>" placeholder="Last Name" required>
            <input type="text" name="username" value="<?= htmlspecialchars($username ?? '') ?>" placeholder="Username" required>
            <input type="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" placeholder="Email" required>
            <input type="password" name="createpassword" value="<?= htmlspecialchars($createpassword ?? '') ?>" placeholder="Create Password" required>
            <input type="password" name="confirmpassword" value="<?= htmlspecialchars($confirmpassword ?? '') ?>" placeholder="Confirm Password" required>
            <select name="userrole">
                <option value="0">Author</option>
                <option value="1">Admin</option>
            </select>
            <div class="form__control">
                <label for="avatar">User Avatar</label>
                <input type="file" name="avatar" id="avatar" required>
            </div>
            <button type="submit" name="submit" class="btn">Add User</button>
        </form>
    </div>
</section>

<?php
require_once __DIR__ . '/../partials/footer.php';
?>
<?php
require_once __DIR__ . '/partials/header.php';

// check if user is admin
if (!isset($_SESSION['user_is_admin'])) {
    header('location: ' . ROOT_URL . 'admin/');
    die();
}

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM users WHERE id=$id LIMIT 1";
    $result = mysqli_query($connection, $query);
    $user = ($result && mysqli_num_rows($result) > 0) ? mysqli_fetch_assoc($result) : null;

    if (!$user) {
        header('location: ' . ROOT_URL . 'admin/manage-users.php');
        die();
    }
} else {
    header('location: ' . ROOT_URL . 'admin/manage-users.php');
    die();
}
?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Edit User</h2>
        <form action="<?= ROOT_URL ?>admin/edit-user-logic.php" method="POST">
            <input type="hidden" value="<?= $user['id'] ?>" name="id">
            <input type="text" value="<?= htmlspecialchars($user['firstname']) ?>" name="firstname" placeholder="First Name" required>
            <input type="text" value="<?= htmlspecialchars($user['lastname']) ?>" name="lastname" placeholder="Last Name" required>
            <select name="userrole">
                <option value="0" <?= ($user['is_admin'] == 0) ? 'selected' : '' ?>>Author</option>
                <option value="1" <?= ($user['is_admin'] == 1) ? 'selected' : '' ?>>Admin</option>
            </select>
            
            <button type="submit" name="submit" class="btn">Update User</button>
        </form>
    </div>
</section>

<?php
require_once __DIR__ . '/../partials/footer.php';
?>
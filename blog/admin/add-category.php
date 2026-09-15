<?php
require_once __DIR__ . '/partials/header.php';

// check if user is admin
if (!isset($_SESSION['user_is_admin'])) {
    header('location: ' . ROOT_URL . 'admin/');
    die();
}

// get back form data if invalid
$title = $_SESSION['add-category-data']['title'] ?? null;
$description = $_SESSION['add-category-data']['description'] ?? null;

unset($_SESSION['add-category-data']);
?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Add Category</h2>
        <?php if(isset($_SESSION['add-category'])) : ?>
        <div class="alert__message error">
            <p>
                <?= htmlspecialchars($_SESSION['add-category']);
                unset($_SESSION['add-category'])?>
            </p>
        </div>
        <?php endif ?>
        <form action="<?= ROOT_URL ?>admin/add-category-logic.php" method="POST">
            <input type="text" value="<?= htmlspecialchars($title ?? '') ?>" name="title" placeholder="Title" required>
            <textarea rows="4" name="description" placeholder="Description" required><?= htmlspecialchars($description ?? '') ?></textarea>
            <button type="submit" name="submit" class="btn">Add Category</button>
        </form>
    </div>
</section>

<?php
require_once __DIR__ . '/../partials/footer.php';
?>
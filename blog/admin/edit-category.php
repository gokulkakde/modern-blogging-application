<?php
require_once __DIR__ . '/partials/header.php';

// check if user is admin
if (!isset($_SESSION['user_is_admin'])) {
    header('location: ' . ROOT_URL . 'admin/');
    die();
}

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    // fetch category from database
    $query = "SELECT * FROM categories WHERE id=$id LIMIT 1";
    $result = mysqli_query($connection, $query);
    $category = ($result && mysqli_num_rows($result) == 1) ? mysqli_fetch_assoc($result) : null;

    if (!$category) {
        header('location: ' . ROOT_URL . 'admin/manage-categories.php');
        die();
    }
} else {
    header('location: ' . ROOT_URL . 'admin/manage-categories.php');
    die();
}
?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Edit Category</h2>
        <form action="<?= ROOT_URL ?>admin/edit-category-logic.php" method="POST">
            <input type="hidden" name="id" value="<?= $category['id'] ?>">
            <input type="text" name="title" value="<?= htmlspecialchars($category['title']) ?>" placeholder="Title" required>
            <textarea rows="4" name="description" placeholder="Description" required><?= htmlspecialchars($category['description']) ?></textarea>
            <button type="submit" name="submit" class="btn">Update Category</button>
        </form>
    </div>
</section>

<?php
require_once __DIR__ . '/../partials/footer.php';
?>
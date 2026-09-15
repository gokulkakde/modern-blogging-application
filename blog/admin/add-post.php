<?php
require_once __DIR__ . '/partials/header.php';

// fetch categories from database
$query = "SELECT * FROM categories ORDER BY title ASC";
$categories = mysqli_query($connection, $query);

// get back form data if form was invalid
$title = $_SESSION['add-post-data']['title'] ?? null;
$body = $_SESSION['add-post-data']['body'] ?? null;
$selected_category = $_SESSION['add-post-data']['category'] ?? null;

// delete form data session
unset($_SESSION['add-post-data']);
?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Add Post</h2>
        <?php if (isset($_SESSION['add-post'])) : ?>
        <div class="alert__message error">
            <p>
                <?= htmlspecialchars($_SESSION['add-post']);
                unset($_SESSION['add-post']);
                ?>
            </p>
        </div>
        <?php endif ?>
        <form action="<?= ROOT_URL ?>admin/add-post-logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" name="title" value="<?= htmlspecialchars($title ?? '') ?>" placeholder="Title" required>
            <select name="category" required>
                <?php while($category = mysqli_fetch_assoc($categories)): ?>
                <option value="<?= $category['id'] ?>" <?= ($selected_category == $category['id']) ? 'selected' : '' ?>><?= htmlspecialchars($category['title']) ?></option>
                <?php endwhile ?>
            </select>
            <textarea rows="10" name="body" placeholder="Body" required><?= htmlspecialchars($body ?? '') ?></textarea>
            
            <?php if (isset($_SESSION['user_is_admin'])) : ?>
            <div class="form__control inline">
                <input type="checkbox" name="is_featured" value="1" id="is_featured">
                <label for="is_featured">Featured Post</label>
            </div>
            <?php endif ?>
            <div class="form__control">
                <label for="thumbnail">Add Thumbnail</label>
                <input type="file" name="thumbnail" id="thumbnail" required>
            </div>
            <button type="submit" name="submit" class="btn">Add Post</button>
        </form>
    </div>
</section>

<?php
require_once __DIR__ . '/../partials/footer.php';
?>
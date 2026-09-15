<?php
require_once __DIR__ . '/partials/header.php';

// fetch categories from database
$category_query = "SELECT * FROM categories ORDER BY title ASC";
$categories = mysqli_query($connection, $category_query);

// fetch post from database if id is set
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id=$id LIMIT 1";
    $result = mysqli_query($connection, $query);
    $post = ($result && mysqli_num_rows($result) == 1) ? mysqli_fetch_assoc($result) : null;

    if (!$post) {
        header('location: ' . ROOT_URL . 'admin/');
        die();
    }

    // Authorization check: if not admin, user can only edit their own post
    if (!isset($_SESSION['user_is_admin']) && $post['author_id'] != $_SESSION['user-id']) {
        $_SESSION['edit-post'] = "You are not authorized to edit this post.";
        header('location: ' . ROOT_URL . 'admin/');
        die();
    }
} else {
    header('location: ' . ROOT_URL . 'admin/');
    die();
}
?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Edit Post</h2>
        <form action="<?= ROOT_URL ?>admin/edit-post-logic.php" enctype="multipart/form-data" method="POST">
            <input type="hidden" name="id" value="<?= $post['id'] ?>">
            <input type="hidden" name="previous_thumbnail_name" value="<?= htmlspecialchars($post['thumbnail']) ?>">
            <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" placeholder="Title" required>
            <select name="category" required>
                <?php while($category = mysqli_fetch_assoc($categories)) : ?>
                <option value="<?= $category['id'] ?>" <?= ($category['id'] == $post['category_id']) ? 'selected' : '' ?>><?= htmlspecialchars($category['title']) ?></option>
                <?php endwhile ?>
            </select>
            <textarea rows="10" name="body" placeholder="Body" required><?= htmlspecialchars($post['body']) ?></textarea>
            
            <?php if (isset($_SESSION['user_is_admin'])) : ?>
            <div class="form__control inline">
                <input type="checkbox" name="is_featured" id="is_featured" value="1" <?= ($post['is_featured'] == 1) ? 'checked' : '' ?>>
                <label for="is_featured">Featured Post</label>
            </div>
            <?php endif ?>

            <div class="form__control">
                <label for="thumbnail">Change Thumbnail (leave blank to keep current)</label>
                <input type="file" name="thumbnail" id="thumbnail">
            </div>
            <button type="submit" name="submit" class="btn">Update Post</button>
        </form>
    </div>
</section>

<?php
require_once __DIR__ . '/../partials/footer.php';
?>
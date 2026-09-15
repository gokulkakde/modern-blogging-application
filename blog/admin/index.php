<?php
require_once __DIR__ . '/partials/header.php';

// fetch current user's posts from database (if admin, fetch all or user's posts)
$current_user_id = (int)$_SESSION['user-id'];
if (isset($_SESSION['user_is_admin'])) {
    $query = "SELECT posts.id, posts.title, posts.category_id, users.firstname, users.lastname 
              FROM posts 
              LEFT JOIN users ON posts.author_id = users.id 
              ORDER BY posts.id DESC";
} else {
    $query = "SELECT id, title, category_id FROM posts WHERE author_id=$current_user_id ORDER BY id DESC";
}
$posts = mysqli_query($connection, $query);
?>

<section class="dashboard">
    <?php if (isset($_SESSION['add-post-success'])) : ?>
        <div class="alert__message success container">
            <p>
                <?= htmlspecialchars($_SESSION['add-post-success']);
                unset($_SESSION['add-post-success']); ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-post-success'])) : ?>
        <div class="alert__message success container">
            <p>
                <?= htmlspecialchars($_SESSION['edit-post-success']);
                unset($_SESSION['edit-post-success']); ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-post'])) : ?>
        <div class="alert__message error container">
            <p>
                <?= htmlspecialchars($_SESSION['edit-post']);
                unset($_SESSION['edit-post']); ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['delete-post-success'])) : ?>
        <div class="alert__message success container">
            <p>
                <?= htmlspecialchars($_SESSION['delete-post-success']);
                unset($_SESSION['delete-post-success']); ?>
            </p>
        </div>
    <?php endif ?>

    <div class="container dashboard__container">
        <button id="show__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-right-b"></i></button>
        <button id="hide__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-left-b"></i></button>
        <aside>
            <ul>
                <li><a href="add-post.php"><i class="uil uil-pen"></i>
                        <h5>Add Post</h5>
                    </a>
                </li>
                <li><a href="index.php" class="active"><i class="uil uil-postcard"></i>
                        <h5>Manage Posts</h5>
                    </a>
                </li>
                <?php if (isset($_SESSION['user_is_admin'])): ?>
                <li><a href="add-user.php"><i class="uil uil-user-plus"></i>
                    <h5>Add User</h5>
                </a>
                </li>
                <li><a href="manage-users.php"><i class="uil uil-users-alt"></i>
                    <h5>Manage Users</h5>
                </a>
                </li>
                <li><a href="add-category.php"><i class="uil uil-edit"></i>
                    <h5>Add Category</h5>
                </a>
                </li>
                <li><a href="manage-categories.php"><i class="uil uil-list-ul"></i>
                    <h5>Manage Categories</h5>
                </a>
                </li>
                <?php endif ?>
            </ul>
        </aside>
        <main>
            <h2>Manage Posts</h2>
            <?php if ($posts && mysqli_num_rows($posts) > 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <?php if (isset($_SESSION['user_is_admin'])): ?>
                        <th>Author</th>
                        <?php endif ?>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($post = mysqli_fetch_assoc($posts)) : ?>
                        <?php
                        $category_id = (int)$post['category_id'];
                        $category_query = "SELECT title FROM categories WHERE id=$category_id";
                        $category_result = mysqli_query($connection, $category_query);
                        $category = ($category_result && mysqli_num_rows($category_result) > 0) ? mysqli_fetch_assoc($category_result) : null;
                        $category_title = $category ? $category['title'] : 'Uncategorized';
                        ?>
                    <tr>
                        <td><?= htmlspecialchars($post['title']) ?></td>
                        <td><?= htmlspecialchars($category_title) ?></td>
                        <?php if (isset($_SESSION['user_is_admin'])): ?>
                        <td><?= htmlspecialchars(($post['firstname'] ?? '') . ' ' . ($post['lastname'] ?? '')) ?></td>
                        <?php endif ?>
                        <td><a href="<?= ROOT_URL ?>admin/edit-post.php?id=<?= $post['id'] ?>" class="btn sm">Edit</a></td>
                        <td><a href="<?= ROOT_URL ?>admin/delete-post.php?id=<?= $post['id'] ?>" class="btn sm danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete</a></td>
                    </tr>   
                    <?php endwhile ?>               
                </tbody>
            </table>
            <?php else : ?>
                <div class="alert__message error">No posts found</div>
            <?php endif ?>
        </main>
    </div>
</section>

<?php
require_once __DIR__ . '/../partials/footer.php';
?>
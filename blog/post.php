<?php
require_once __DIR__ . '/partials/header.php';

// fetch post from database if id is set
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id=$id LIMIT 1";
    $result = mysqli_query($connection, $query);
    $post = ($result && mysqli_num_rows($result) > 0) ? mysqli_fetch_assoc($result) : null;

    if (!$post) {
        header('location: ' . ROOT_URL . 'blog.php');
        die();
    }
} else {
    header('location: ' . ROOT_URL . 'blog.php');
    die();
}
?>

    <section class="singlepost">
        <div class="container singlepost__container">
            <h2><?= htmlspecialchars($post['title']) ?></h2>
            <div class="post__author">
                <?php
                    // fetch author from users table using author_id
                    $author_id = (int)$post['author_id'];
                    $author_query = "SELECT * FROM users WHERE id=$author_id";
                    $author_result = mysqli_query($connection, $author_query);
                    $author = ($author_result && mysqli_num_rows($author_result) > 0) ? mysqli_fetch_assoc($author_result) : null;
                    $author_name = $author ? "{$author['firstname']} {$author['lastname']}" : "Anonymous";
                    $author_avatar = (!empty($author['avatar'])) ? $author['avatar'] : '1731062212avatar01.jpg';
                ?>
                <div class="post__author-avatar">
                    <img src="<?= ROOT_URL ?>images/<?= htmlspecialchars($author_avatar) ?>" alt="Author Avatar">
                </div>
                <div class="post__author-info">
                    <h5>By: <?= htmlspecialchars($author_name) ?></h5>
                    <small>
                        <?= date("M d, Y - H:i A", strtotime($post['date_time'])) ?>
                    </small>
                </div>
            </div>
            <div class="singlepost__thumbnail">
                <img src="<?= ROOT_URL ?>images/<?= htmlspecialchars($post['thumbnail']) ?>" alt="Post Thumbnail">
            </div>
            <div class="singlepost__body">
                <p><?= nl2br(htmlspecialchars($post['body'])) ?></p>
            </div>
        </div>
    </section>
<!-- ===================================END OF SINGLE POST================================== -->

<?php
require_once __DIR__ . '/partials/footer.php';
?>
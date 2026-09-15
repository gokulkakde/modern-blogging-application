<?php
require_once __DIR__ . '/partials/header.php';

// fetch posts if id is set
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE category_id=$id ORDER BY date_time DESC";
    $posts = mysqli_query($connection, $query);

    // fetch category title
    $category_query = "SELECT * FROM categories WHERE id=$id";
    $category_result = mysqli_query($connection, $category_query);
    $category = ($category_result && mysqli_num_rows($category_result) > 0) ? mysqli_fetch_assoc($category_result) : null;
    $category_title = $category ? $category['title'] : 'Category';
} else {
    header('location: ' . ROOT_URL . 'blog.php');
    die();
}
?>

    <header class="category__title">
        <h2><?= htmlspecialchars($category_title) ?></h2>
    </header>
    <!-- ===================================END OF Category Title================================== -->

    <?php if ($posts && mysqli_num_rows($posts) > 0) : ?>
    <section class="posts">
        <div class="container posts__container">
            <?php while($post = mysqli_fetch_assoc($posts)) : ?>
            <article class="post">
                <div class="post__thumbnail">
                    <img src="<?= ROOT_URL ?>images/<?= htmlspecialchars($post['thumbnail']) ?>" alt="Post Thumbnail">
                </div>
                <div class="post__info">
                    <h3 class="post__title">
                        <a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>"><?= htmlspecialchars($post['title']) ?></a>
                    </h3>
                    <p class="post__body">
                    <?= htmlspecialchars(substr($post['body'], 0, 150)) ?>. . . . .
                    </p>
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
                </div>
            </article>
            <?php endwhile ?>
        </div>
    </section>
    <?php else : ?>
        <div class="alert__message error lg">
            <p>No posts found for this category</p>
        </div>
    <?php endif ?>
    <!-- ==============================================END OF POSTS====================================== -->

    <section class="category__buttons">
        <div class="container category__buttons-container">
            <?php  
                $all_categories_query = "SELECT * FROM categories ORDER BY title ASC";
                $all_categories = mysqli_query($connection, $all_categories_query);
            ?>  
            <?php if ($all_categories) : ?>
                <?php while($cat = mysqli_fetch_assoc($all_categories)) : ?>
                <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $cat['id'] ?>" class="category__button"><?= htmlspecialchars($cat['title']) ?></a>
                <?php endwhile ?>
            <?php endif ?>
        </div>
    </section>
    <!-- ==============================================END OF CATEGORY BUTTONS====================================== -->

<?php
require_once __DIR__ . '/partials/footer.php';
?>
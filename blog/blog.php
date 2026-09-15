<?php
require_once __DIR__ . '/partials/header.php';

// fetch all posts from posts table
$query = "SELECT * FROM posts ORDER BY date_time DESC";
$posts = mysqli_query($connection, $query);
?>

    <section class="search__bar">
        <form class="container search__bar-container" action="<?= ROOT_URL ?>search.php" method="GET">
            <div>
                <i class="uil uil-search"></i>
                <input type="search" name="search" placeholder="Search" required>
            </div>
            <button type="submit" name="submit" class="btn">Go</button>
        </form>
    </section>
<!-- ===================================END OF SEARCH================================== -->

<section class="posts section__extra-margin">
    <div class="container posts__container">
        <?php if ($posts && mysqli_num_rows($posts) > 0) : ?>
            <?php while($post = mysqli_fetch_assoc($posts)) : ?>
            <article class="post">
                <div class="post__thumbnail">
                    <img src="<?= ROOT_URL ?>images/<?= htmlspecialchars($post['thumbnail']) ?>" alt="Post Thumbnail">
                </div>
                <div class="post__info">
                <?php
                // fetch category from categories table using category_id of post
                $category_id = (int)$post['category_id']; 
                $category_query = "SELECT * FROM categories WHERE id=$category_id";
                $category_result = mysqli_query($connection, $category_query);
                $category = $category_result ? mysqli_fetch_assoc($category_result) : null;
                $category_title = $category['title'] ?? 'General';
                ?>
                    <a href="<?= ROOT_URL?>category-posts.php?id=<?= $post['category_id'] ?>" class="category__button"><?= htmlspecialchars($category_title) ?></a>
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
                        $author = $author_result ? mysqli_fetch_assoc($author_result) : null;
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
        <?php else : ?>
            <div class="alert__message error lg">
                <p>No posts found. Be the first to publish a post!</p>
            </div>
        <?php endif ?>
    </div>
</section>
<!-- ==============================================END OF POSTS====================================== -->
<section class="category__buttons">
    <div class="container category__buttons-container">
        <?php  
            $all_categories_query = "SELECT * FROM categories ORDER BY title ASC";
            $all_categories = mysqli_query($connection, $all_categories_query);
        ?>  
        <?php if ($all_categories) : ?>
            <?php while($category = mysqli_fetch_assoc($all_categories)) : ?>
            <a href="<?= ROOT_URL?>category-posts.php?id=<?= $category['id'] ?>" class="category__button"><?= htmlspecialchars($category['title']) ?></a>
            <?php endwhile ?>
        <?php endif ?>
    </div>
</section>
<!-- ==============================================END OF CATEGORY BUTTONS====================================== -->

<?php
require_once __DIR__ . '/partials/footer.php';
?>
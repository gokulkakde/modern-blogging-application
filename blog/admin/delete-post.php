<?php
require_once __DIR__ . '/config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // fetch post from database in order to delete thumbnail from folder
    $query = "SELECT * FROM posts WHERE id=$id";
    $result = mysqli_query($connection, $query);

    // make sure only 1 record/post was fetched
    if ($result && mysqli_num_rows($result) == 1) {
        $post = mysqli_fetch_assoc($result);
        $thumbnail_name = $post['thumbnail'];
        $thumbnail_path = __DIR__ . '/../images/' . $thumbnail_name;

        if ($thumbnail_name && file_exists($thumbnail_path)) {
            unlink($thumbnail_path);
        }

        // delete post from database
        $delete_post_query = "DELETE FROM posts WHERE id=$id LIMIT 1";
        $delete_post_result = mysqli_query($connection, $delete_post_query);

        if (!mysqli_errno($connection)) {
            $_SESSION['delete-post-success'] = "Post deleted successfully";
        } else {
            $_SESSION['edit-post'] = "Failed to delete post: " . mysqli_error($connection);
        }
    }
}

header('location: ' . ROOT_URL . 'admin/');
die();
<?php
require_once __DIR__ . '/config/database.php';

if (isset($_POST['submit'])) {
    $author_id = $_SESSION['user-id'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'] ?? 0, FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'] ?? null;

    // set is_featured to 0 if unchecked
    $is_featured = ($is_featured == 1) ? 1 : 0;

    // validate form data
    if (!$title) {
        $_SESSION['add-post'] = "Enter post title";
    } elseif (!$category_id) {
        $_SESSION['add-post'] = "Select post category";
    } elseif (!$body) {
        $_SESSION['add-post'] = "Enter post body";
    } elseif (!$thumbnail || empty($thumbnail['name'])) {
        $_SESSION['add-post'] = "Choose post thumbnail";
    } else {
        // WORK ON THUMBNAIL
        $time = time(); // make each image name unique
        $thumbnail_name = $time . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $thumbnail['name']);
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = __DIR__ . '/../images/' . $thumbnail_name;

        // make sure file is an image
        $allowed_files = ['png', 'jpg', 'jpeg', 'webp'];
        $extension = pathinfo($thumbnail_name, PATHINFO_EXTENSION);
        if (in_array(strtolower($extension), $allowed_files)) {
            // make sure image is not too big (2mb+)
            if ($thumbnail['size'] < 2000000) {
                // upload thumbnail
                move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
            } else {
                $_SESSION['add-post'] = "File size too big. Should be less than 2mb";
            }
        } else {
            $_SESSION['add-post'] = "File should be png, jpg, jpeg, or webp";
        }
    }

    // redirect back (with form data) to add-post page if there is any problem
    if (isset($_SESSION['add-post'])) {
        $_SESSION['add-post-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/add-post.php');
        die();
    } else {
        // set is_featured of all posts to 0 if is_featured for this post is 1
        if ($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured=0";
            mysqli_query($connection, $zero_all_is_featured_query);
        }

        // insert post into database
        $query = "INSERT INTO posts (title, body, thumbnail, category_id, author_id, is_featured) VALUES('$title', '$body', '$thumbnail_name', $category_id, $author_id, $is_featured)";
        $result = mysqli_query($connection, $query);

        if (!mysqli_errno($connection)) {
            $_SESSION['add-post-success'] = "New post added successfully";
            header('location: ' . ROOT_URL . 'admin/');
            die();
        } else {
            $_SESSION['add-post'] = "Database error adding post: " . mysqli_error($connection);
            header('location: ' . ROOT_URL . 'admin/add-post.php');
            die();
        }
    }
}

header('location: ' . ROOT_URL . 'admin/add-post.php');
die();
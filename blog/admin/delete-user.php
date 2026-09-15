<?php
require_once __DIR__ . '/config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Prevent self-deletion
    if ($id == $_SESSION['user-id']) {
        $_SESSION['delete-user'] = "You cannot delete your own active admin account.";
        header('location: ' . ROOT_URL . 'admin/manage-users.php');
        die();
    }

    // fetch user from database
    $query = "SELECT * FROM users WHERE id=$id";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $avatar_name = $user['avatar'];
        $avatar_path = __DIR__ . '/../images/' . $avatar_name;

        // delete avatar image if file exists
        if ($avatar_name && file_exists($avatar_path)) {
            unlink($avatar_path);
        }

        // fetch all thumbnails of user's posts and delete them
        $thumbnails_query = "SELECT thumbnail FROM posts WHERE author_id=$id";
        $thumbnails_result = mysqli_query($connection, $thumbnails_query);
        if ($thumbnails_result && mysqli_num_rows($thumbnails_result) > 0) {
            while ($thumbnail = mysqli_fetch_assoc($thumbnails_result)) {
                $thumbnail_name = $thumbnail['thumbnail'];
                $thumbnail_path = __DIR__ . '/../images/' . $thumbnail_name;
                if ($thumbnail_name && file_exists($thumbnail_path)) {
                    unlink($thumbnail_path);
                }
            }
        }

        // delete user's posts first to maintain integrity
        $delete_posts_query = "DELETE FROM posts WHERE author_id=$id";
        mysqli_query($connection, $delete_posts_query);

        // delete user from database
        $delete_user_query = "DELETE FROM users WHERE id=$id";
        $delete_user_result = mysqli_query($connection, $delete_user_query);

        if (!mysqli_errno($connection)) {
            $_SESSION['delete-user-success'] = "{$user['firstname']} {$user['lastname']} deleted successfully";
        } else {
            $_SESSION['delete-user'] = "Couldn't delete '{$user['firstname']} {$user['lastname']}': " . mysqli_error($connection);
        }
    }
}

header('location: ' . ROOT_URL . 'admin/manage-users.php');
die();

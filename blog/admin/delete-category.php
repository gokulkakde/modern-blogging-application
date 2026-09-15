<?php
require_once __DIR__ . '/config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Find fallback category or create Uncategorized if needed
    $uncat_query = "SELECT id FROM categories WHERE title='Uncategorized' OR id=5 LIMIT 1";
    $uncat_result = mysqli_query($connection, $uncat_query);
    $fallback_category_id = 5;
    if ($uncat_result && mysqli_num_rows($uncat_result) > 0) {
        $uncat = mysqli_fetch_assoc($uncat_result);
        $fallback_category_id = $uncat['id'];
    }

    // Reassign posts belonging to this category to fallback
    if ($id != $fallback_category_id) {
        $update_query = "UPDATE posts SET category_id=$fallback_category_id WHERE category_id=$id";
        mysqli_query($connection, $update_query);
    }

    // Delete category
    $query = "DELETE FROM categories WHERE id=$id LIMIT 1";
    $result = mysqli_query($connection, $query);

    if (!mysqli_errno($connection)) {
        $_SESSION['delete-category-success'] = "Category deleted successfully";
    } else {
        $_SESSION['edit-category'] = "Failed to delete category: " . mysqli_error($connection);
    }
}

header('location: ' . ROOT_URL . 'admin/manage-categories.php');
die();
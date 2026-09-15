<?php
require_once __DIR__ . '/constants.php';

// Connect to the database
$connection = mysqli_init();
if (!$connection) {
    die("mysqli_init failed");
}

// Set connection timeout
$connection->options(MYSQLI_OPT_CONNECT_TIMEOUT, 10);

if (!@$connection->real_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT)) {
    die("Database Connection Error (" . mysqli_connect_errno() . "): " . mysqli_connect_error());
}

$connection->set_charset("utf8mb4");

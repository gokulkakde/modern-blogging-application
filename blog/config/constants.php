<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Parse DATABASE_URL / MYSQL_URL if available (common in Railway, Render, Heroku)
$db_url = getenv('DATABASE_URL') ?: getenv('MYSQL_URL');
if ($db_url) {
    $parsed_url = parse_url($db_url);
    $env_db_host = $parsed_url['host'] ?? 'localhost';
    $env_db_port = $parsed_url['port'] ?? 3306;
    $env_db_user = $parsed_url['user'] ?? 'root';
    $env_db_pass = $parsed_url['pass'] ?? '';
    $env_db_name = isset($parsed_url['path']) ? ltrim($parsed_url['path'], '/') : 'blog';
} else {
    $env_db_host = getenv('DB_HOST') ?: 'localhost';
    $env_db_port = getenv('DB_PORT') ? (int)getenv('DB_PORT') : 3306;
    $env_db_user = getenv('DB_USER') ?: 'root';
    $env_db_pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';
    $env_db_name = getenv('DB_NAME') ?: 'blog';
}

// Database Constants
if (!defined('DB_HOST')) define('DB_HOST', $env_db_host);
if (!defined('DB_USER')) define('DB_USER', $env_db_user);
if (!defined('DB_PASS')) define('DB_PASS', $env_db_pass);
if (!defined('DB_NAME')) define('DB_NAME', $env_db_name);
if (!defined('DB_PORT')) define('DB_PORT', $env_db_port);

// Determine ROOT_URL dynamically if not set via environment variable
if (!defined('ROOT_URL')) {
    $env_root = getenv('ROOT_URL');
    if ($env_root) {
        define('ROOT_URL', rtrim($env_root, '/') . '/');
    } elseif (isset($_SERVER['HTTP_HOST'])) {
        $is_https = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ||
                    (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
        $protocol = $is_https ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'];
        
        // Compute base path if running inside a subfolder
        $script_dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        // Strip out /admin if constants is required from within admin subfolder
        $script_dir = preg_replace('#/admin(/.*)?$#', '', $script_dir);
        $base_path = rtrim($script_dir, '/') . '/';
        
        define('ROOT_URL', $protocol . $host . $base_path);
    } else {
        define('ROOT_URL', 'http://localhost:8080/');
    }
}

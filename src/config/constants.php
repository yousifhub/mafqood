<?php
// Base URL
define('ROOT_URL', '/');

// CSS Version for cache busting
define('CSS_VERSION', '1.0.0');

// Prevent FOUC (Flash of Unstyled Content)
define('PREVENT_FOUC', true);

define('PHP_ROOT_URL', 'http://localhost:8080/');
define('NODE_ROOT_URL', 'http://localhost:3000/');

if (!defined('DB_HOST')) {
    define('DB_HOST', 'db');
}
if (!defined('DB_USER')) {
    define('DB_USER', 'root');
}
if (!defined('DB_PASS')) {
    define('DB_PASS', '');
}
if (!defined('DB_NAME')) {
    define('DB_NAME', 'children_db');
}
?>
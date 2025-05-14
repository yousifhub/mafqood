<?php
$host = 'db'; // Matches the service name in docker-compose.yml
$username = 'root';
$password = ''; // No password
$database = 'children_db'; // Matches MYSQL_DATABASE

$connection = mysqli_connect($host, $username, $password, $database);

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
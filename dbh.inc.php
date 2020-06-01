<?php
// Database handler file: gives the informations we need to connect to the database

$servername = "localhost";
$db_username = "admin";
$db_password = "admin";
$db_name = "login_facebook";

// Run the connection
$conn = mysqli_connect($servername, $db_username, $db_password, $db_name);

// Check if the connection fails
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error);
}

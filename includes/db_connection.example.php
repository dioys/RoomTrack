<?php
// Copy this file to db_connection.php and fill in your own MySQL details.
// db_connection.php is ignored by git so your password never gets uploaded.
$host = "localhost";
$user = "root";
$pass = "";            // your MySQL password
$db   = "directory";   // database name created by database/schema.sql

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

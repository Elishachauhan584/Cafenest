<?php
$host     = "localhost";
$user     = "root";
$password = "";
$database = "cafenest_db";

$conn = new mysqli($host, $user, $password, $database, 3307);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'DB Error: ' . $conn->connect_error]));
}
?>
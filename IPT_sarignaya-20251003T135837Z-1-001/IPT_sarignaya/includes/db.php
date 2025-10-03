<?php
$servername = "localhost";
$username = "root"; // default for Laragon/XAMPP
$password = "";     // default password is empty
$database = "db_portfolio";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

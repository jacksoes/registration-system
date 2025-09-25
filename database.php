<?php
$servername = "school-project.cubcw8ayasbz.us-east-1.rds.amazonaws.com";
$username   = "admin";
$password   = "";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully<br>";




$conn->close();
?>

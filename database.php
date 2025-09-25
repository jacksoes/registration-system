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

if ($conn->query("USE registration")) {
    
}
echo "connected to registraion";

$result = $conn->query("SHOW TABLES");

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Each row will have the table name as the value of the first column
        echo $row[array_keys($row)[0]] . "<br>";
    }
} else {
    echo "No tables found.";
}


$conn->close();
?>

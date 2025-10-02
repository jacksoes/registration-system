<?php
$servername = "school-project.cubcw8ayasbz.us-east-1.rds.amazonaws.com";
$username   = "admin";
$password   = "system_design";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully<br>";

if ($conn->query("USE registration")) {
    
}
echo "connected to registraion";
drop_all_tables($conn);

$result = $conn->query("SHOW TABLES");

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo $row[array_keys($row)[0]] . "<br>";
    }
} else {
    echo "No tables found.";
}


function drop_all_tables($conn) {
    if (!$conn->query("SET FOREIGN_KEY_CHECKS = 0")) {
        echo "Error disabling foreign key checks: " . $conn->error . "<br>";
        return;
    }

    $result = $conn->query("SHOW TABLES");
    if (!$result) {
        echo "Error fetching tables: " . $conn->error . "<br>";
        return;
    }

    while ($row = $result->fetch_array()) {
        $table = $row[0];
        $drop_sql = "DROP TABLE IF EXISTS `$table`";
        if (!$conn->query($drop_sql)) {
            echo "Error dropping table $table: " . $conn->error . "<br>";
        } else {
            echo "Dropped table $table<br>";
        }
    }

    if (!$conn->query("SET FOREIGN_KEY_CHECKS = 1")) {
        echo "Error enabling foreign key checks: " . $conn->error . "<br>";
    }
}


$conn->close();
?>

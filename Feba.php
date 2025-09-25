<?php
$servername = "school-project.cubcw8ayasbz.us-east-1.rds.amazonaws.com";
$username   = "admin";
$password   = "";
$conn = new mysqli($servername, $username, $password);

connect_database_registration($conn);
create_all_tables($conn);






$conn->close();

function create_table_login ($conn) {


    $result = $conn->query("CREATE TABLE IF NOT EXISTS Log_in (
        userID INT PRIMARY KEY, 
        FOREIGN KEY (userID) REFERENCES User(userID),
        // continue writing code here

)");

}

function connect_database_registration($conn){
    // Check connection
    if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully<br>";

    if ($conn->query("USE registration")) {
    
    }
    echo "connected to registraion";
}


function create_all_tables($conn){

    create_table_login($conn);
    
}

?>

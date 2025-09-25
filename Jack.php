<?php
$servername = "school-project.cubcw8ayasbz.us-east-1.rds.amazonaws.com";
$username   = "admin";
$password   = "";
$conn = new mysqli($servername, $username, $password);

connect_database_registration($conn);
create_all_tables($conn);






$conn->close();

function create_table_user ($conn) {


    $result = $conn->query("CREATE TABLE IF NOT EXISTS User(
    userID varchar(255) PRIMARY KEY,
    first_name varchar(255),
    middle_name varchar(255),
    last_name varchar(255),
    house_APT_number INT,
    street_name varchar(255),
    city_name varchar(255),
    state_name varchar(255),
    zipcode INT,
    gender varchar(255),
    DOB DATE,
    user_type varchar(255)

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

    create_table_user($conn);

}



?>

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
    userID INT PRIMARY KEY, #WAS CHANGED FROM VARCHAR TABLE MUST BE DELEATED AND REMADE
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

function create_table_student_hold ($conn) { 
    $result = $conn->query("CREATE TABLE IF NOT EXISTS Student_Hold(
    studentID INT PRIMARY KEY,
    holdID INT PRIMARY KEY,
    date_of_hold DATE,
    FOREIGN KEY (holdID) REFERENCES Hold (holdID),
    FOREIGN KEY (studentID) REFERENCES Student (studentID)
    )");
}

function create_table_hold ($conn) { 
    $result = $conn->query("CREATE TABLE IF NOT EXISTS Student_Hold(
    holdID INT PRIMARY KEY,
    hold_type varchar(255)

    )");
}


function create_student_history ($conn) { 
    $result = $conn->query("CREATE TABLE IF NOT EXISTS Student_History(
    studentID INT,
    semesterID INT,
    courseID INT,
    CRN INT,
    grade varchar(4)
    FOREIGN KEY (studentID) REFERENCES Student (studentID),
    FOREIGN KEY (semesterID) REFERENCES Semester (semesterID),
    FOREIGN KEY (courseID) REFERENCES Course (courseID),
    FOREIGN KEY (CRN) REFERENCES Course_Section (CRN)

    )");
}



function create_table_classroom ($conn) { 
    $result = $conn->query("CREATE TABLE IF NOT EXISTS Classroom(
    roomID INT,
    number_seats INT,
    FOREIGN KEY (roomID) REFERENCES Room (roomID)
    )");
}

function create_table_student ($conn) { 
    $result = $conn->query("CREATE TABLE IF NOT EXISTS Student(
    studentID INT PRIMARY KEY,
    majorID INT,
    Year DATE,
    student_type VARCHAR(4),
    )");
}

function create_table_advisor ($conn) { 
    $result = $conn->query("CREATE TABLE IF NOT EXISTS Advisor(
    studentID INT PRIMARY KEY,
    facultyID INT,
    date_of_appointment DATETIME,
    FOREIGN KEY (facultyID) REFERENCES Faculty (facultyID)
    )");
}

function create_table_faculty ($conn) {
     $result = $conn->query("CREATE TABLE IF NOT EXISTS Faculty(
     facultyID INT PRIMARY KEY,
     office INT,
     specialty varchar(255),
     rank varchar(255),
     faculty_type varchar(4),
     FOREIGN KEY (office) REFERENCES Office (roomID)  
     )");

}

function create_table_admin ($conn) {
     $result = $conn->query("CREATE TABLE IF NOT EXISTS Admin(
     adminID INT PRIMARY KEY,
     security_type varchar(255),
     FOREIGN KEY (adminID) REFERENCES User (userID)
     )");
}

function create_table_stats_staff ($conn) {
     $result = $conn->query("CREATE TABLE IF NOT EXISTS Stats_Staff(
     stats_staffID INT PRIMARY KEY,
     status varchar(255),
     FOREIGN KEY (stats_staffID) REFERENCES User (userID)
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

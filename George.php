<?php
$servername = "school-project.cubcw8ayasbz.us-east-1.rds.amazonaws.com";
$username   = "admin";
$password   = "";
$conn = new mysqli($servername, $username, $password);

connect_database_registration($conn);
create_all_tables($conn);





$conn->close();

function create_table_attendance ($conn) {
    $result = $conn->query("CREATE TABLE IF NOT EXISTS Attendance(
    studentID INT PRIMARY KEY,
    courseID INT PRIMARY KEY,
    CRN INT,
    attendance_datetime DATETIME,
    present VARCHAR(1) NOT NULL,
    FOREIGN KEY (studentID) REFERENCES Student (studentID),
    FOREIGN KEY (courseID) REFERENCES Course(courseID),
    FOREIGN KEY (CRN) REFERENCES CourseSection(CRN)
)");
}

function create_table_enrollment ($conn) {
    $result = $conn->query("CREATE TABLE IF NOT EXISTS Enrollment(
    studentID INT PRIMARY KEY,
    CRN INT,
    enroll_date DATETIME,
    grade varchar(4),
    FOREIGN KEY (studentID) REFERENCES Student (studentID),
    ");
}

function create_table_course_section ($conn) {
    $result = $conn->query("CREATE TABLE IF NOT EXISTS CourseSection(
    CRN INT PRIMARY KEY,
    courseID INT,
    sectionID INT,
    timeslot VARCHAR(255),
    year INT,
    semID VARCHAR(255),
    avaliable_seats INT,
    facultyID INT,
    buildingID VARCHAR(255),
    FOREIGN KEY (CourseID) REFERENCES Course(courseID),
    FOREIGN KEY (semID) REFERENCES Semester(semID),
    FOREIGN KEY (facultyID) REFERENCES Faculty(facultyID),
    FOREIGN KEY (buildingID) REFERENCES Building(buildingID)");
}

function create_table_requirements ($conn) {
    $result = $conn->query("CREATE TABLE IF NOT EXISTS Requirements(
    requirementID INT PRIMARY KEY,
    CRN INT,
    passingGrade VARCHAR(255),
    FOREIGN KEY (CRN) REFERENCES CourseSection(CRN),");
}

function create_table_timeslot ($conn) {
    $result = $conn->query("CREATE TABLE IF NOT EXISTS Timeslot(
    TS_ID VARCHAR(255) PRIMARY KEY,
    day_ID VARCHAR(255),
    periodID VARCHAR(255))");
}

function create_table_timeslot_day ($conn) {
    $result = $conn->query("CREATE TABLE IF NOT EXISTS TimeslotDay(
    TS_ID VARCHAR(255) PRIMARY KEY,
    day_ID VARCHAR(255),
    FOREIGN KEY (day_ID) REFERENCES Day(dayID),
    FOREIGN KEY (TS_ID) REFERENCES Timeslot(TS_ID),");
}

function create_table_day ($conn) {
    $result = $conn->query("CREATE TABLE IF NOT EXISTS Day(
    dayID VARCHAR(255) PRIMARY KEY
    ");
}

function create_table_timeslotPeriod($conn) {
    $result = $conn->query("CREATE TABLE IF NOT EXISTS TimeslotPeriod(
    TS_ID VARCHAR(255) PRIMARY KEY,
    periodID VARCHAR(255),
    FOREIGN KEY (TS_ID) REFERENCES Timeslot(TS_ID),
    FOREIGN KEY (periodID) REFERENCES Period(periodID),");
}

function create_table_period($conn) {
    $result = $conn->query("CREATE TABLE IF NOT EXISTS Period(
    periodID VARCHAR(255) PRIMARY KEY
    startTime DATETIME,
    endTime DATETIME");
}

function create_table_room ($conn) {
    $result = $conn->query("CREATE TABLE IF NOT EXISTS Room(
    roomID INT PRIMARY KEY,
    buildingID INT,
    capacity INT,
    typeID VARCHAR(255),
    FOREIGN KEY (buildingID) REFERENCES Building(buildingID)");
}

function create_table_building ($conn) {
    $result = $conn->query("CREATE TABLE IF NOT EXISTS Building(
    buildingID INT PRIMARY KEY,
    buildingName VARCHAR(255),
    usage VARCHAR(255)
    ");
}

function create_table_lab ($conn) {
    $result = $conn->query("CREATE TABLE IF NOT EXISTS Lab(
    roomID INT PRIMARY KEY,
    numStations INT,
    FOREIGN KEY (roomID) REFERENCES Room(roomID)");
}

function create_table_office ($conn) {
    $result = $conn->query("CREATE TABLE IF NOT EXISTS Office(
    roomID INT PRIMARY KEY,
    numSeats INT,
    FOREIGN KEY (roomID) REFERENCES Room(roomID)");
}

function create_table_semester ($conn) {
    $result = $conn->query("CREATE TABLE IF NOT EXISTS Semester(
    semesterID INT PRIMARY KEY,
    semesterName VARCHAR(255),
    year INT,
    startTime DATETIME,
    endTime DATETIME");
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

    create_table_semester($conn);

}



?>

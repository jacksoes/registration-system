<?php
$servername = "school-project.cubcw8ayasbz.us-east-1.rds.amazonaws.com";
$username   = "admin";
$password   = "";
$conn = new mysqli($servername, $username, $password);

connect_database_registration($conn);
create_all_tables($conn);


$conn->close();

function create_table_login ($conn) {

    $result = $conn->query("CREATE TABLE IF NOT EXISTS Log_in(
        userID varchar(255) PRIMARY KEY, 
        email varchar(255),
        user_password varchar(255),
        no_of_tries INT,
        locked_up INT,
        userType varchar(255),
        FOREIGN KEY (userID) REFERENCES User(userID)

)");

}

function create_table_full_time_graduate($conn){
     $result = $conn->query("CREATE TABLE IF NOT EXISTS Full_Time_Graduate(
     studentID INT PRIMARY KEY,
     credits_earned INT,
     thesis_year YEAR,
     FOREIGN KEY (StudentID) REFERENCES Student(StudentID)
       
)");

}

function create_table_part_time_undergraduate($conn){
     $result = $conn->query("CREATE TABLE IF NOT EXISTS Part_Time_Undergraduate(
     studentID INT PRIMARY KEY,
     deptID INT,
     current_year YEAR,
     max_credits INT,
     min_credits INT,
     credits_earned INT,
     FOREIGN KEY (studentID) REFERENCES Undergraduate (studentID),
     FOREIGN KEY (deptID) REFERENCES Department (deptID)
             

)");

}

function create_table_department($conn){
     $result = $conn->query("CREATE TABLE IF NOT EXISTS Department(
     deptID INT PRIMARY KEY,
     dept_name VARCHAR(255) NOT NULL,
     roomID INT,
     chairID INT,
     email VARCHAR(255),
     phone_number VARCHAR(20),
     dept_assistant VARCHAR(255),
     FOREIGN KEY (roomID) REFERENCES Room(roomID),
     FOREIGN KEY (chairID) REFERENCES Faculty(facultyID) 
     

)");

}

function create_table_faculty_dept($conn){
     $result = $conn->query("CREATE TABLE IF NOT EXISTS Faculty_Dept(
     facultyID INT PRIMARY KEY ,
     deptID INT,
     percent_time DECIMAL(5,2),
     date_of_appointment DATE,
     PRIMARY KEY (facultyID, deptID), 
     FOREIGN KEY (facultyID) REFERENCES Faculty(facultyID),
     FOREIGN KEY (deptID) REFERENCES Department(deptID)
     

)");

}

function create_table_full_time_faculty($conn){
     $result = $conn->query("CREATE TABLE IF NOT EXISTS Full_Time_Faculty(
     facultyID INT,
     min_course INT,
     max_course INT,
     FOREIGN KEY (facultyID) REFERENCES Faculty(facultyID)

)");

}

function create_table_part_time_faculty($conn){
     $result = $conn->query("CREATE TABLE IF NOT EXISTS Part_Time_Faculty(
     facultyID INT,
     min_course INT,
     max_course INT,
     FOREIGN KEY (facultyID) REFERENCES Faculty(facultyID)

)");

}

function create_table_major($conn){
     $result = $conn->query("CREATE TABLE IF NOT EXISTS Major(
     majorID INT PRIMARY KEY,
     deptID INT,
     major_name VARCHAR(250) NOT NULL,
     credits_required INT NOT NULL,
     FOREIGN KEY (deptID) REFERENCES Department(deptID) 

)");

}

function create_table_major_requirements($conn){
     $result = $conn->query("CREATE TABLE IF NOT EXISTS Major_Requirements(
     majorID INT,
     courseID INT, 
     min_grade VARCHAR(2),
     PRIMARY KEY (majorID, courseID),
     FOREIGN KEY (majorID) REFERENCES Major (majorID),
     FOREIGN KEY (courseID) REFERENCES Course(courseID)

)");

}

function create_table_student_major($conn){
     $result = $conn->query("CREATE TABLE IF NOT EXISTS Student_Major(
     studentID INT,
     majorID INT,
     date_of_declaration DATE,
     PRIMARY KEY (studentID, Major_ID),
     FOREIGN KEY (studentID) REFERENCES Student (studentID),
     FOREIGN KEY (majorID) REFERENCES Major (majorID)
       
)");

}


function create_table_minor($conn){
     $result = $conn->query("CREATE TABLE IF NOT EXISTS Minor(
     minorID INT PRIMARY KEY,
     deptID INT,
     minor_name VARCHAR(250) NOT NULL,
     credits_required INT NOT NULL,
     FOREIGN KEY (deptID) REFERENCES Department(deptID)

)");

}

function create_table_minor_requirements($conn){
     $result = $conn->query("CREATE TABLE IF NOT EXISTS Minor_Requirements(
     minorID INT,
     courseID INT,
     min_grade VARCHAR(2),
     PRIMARY KEY (minorID, courseID),
     FOREIGN KEY (minorID) REFERENCES Minor(minorID),
     FOREIGN KEY (courseID) REFERENCES Course(courseID)

)");

}

function create_table_student_minor($conn){
     $result = $conn->query("CREATE TABLE IF NOT EXISTS Student_Minor(
     studentID INT,
     minorID INT,
     date_of_declaration DATE,
     PRIMARY KEY (studentID, minorID),
     FOREIGN KEY (studentID) REFERENCES Student(studentID),
     FOREIGN KEY (minorID) REFERENCES Minor(minorID)
          
)");

}

function create_table_course($conn){
     $result = $conn->query("CREATE TABLE IF NOT EXISTS Course(

     courseID INT PRIMARY KEY,
     courseName VARCHAR(100) NOT NULL,
     deptID INT,
     course_description TEXT,
     credits INT NOT NULL,
     type_of_course VARCHAR(100),
     FOREIGN KEY (deptID) REFERENCES Department(deptID)
       
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
    create_table_department($conn);
    create_table_faculty_dept($conn);
    create_table_full_time_faculty($conn);
    create_table_part_time_faculty($conn);
    create_table_major($conn);
    create_table_major_requirements($conn);
    create_table_student_major($conn);
    create_table_minor($conn);
    create_table_minor_requirements($conn);
    create_table_student_minor($conn);
    create_table_course($conn);
    create_table_full_time_graduate($conn);
    create_table_part_time_underSgraduate($conn);
    
}

?>

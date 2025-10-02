
<?php
$servername = "school-project.cubcw8ayasbz.us-east-1.rds.amazonaws.com";
$username   = "admin";
$password   = "system_design";
$conn = new mysqli($servername, $username, $password);

connect_database_registration($conn);
create_all_tables($conn);
$conn->close();



function create_table_user($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS User (
        userID INT PRIMARY KEY,
        first_name VARCHAR(255),
        middle_name VARCHAR(255),
        last_name VARCHAR(255),
        house_APT_number INT,
        street_name VARCHAR(255),
        city_name VARCHAR(255),
        state_name VARCHAR(255),
        zipcode INT,
        gender VARCHAR(255),
        DOB DATE,
        user_type VARCHAR(255)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating User: " . $conn->error . "<br>";
    }
}

function create_table_login($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Log_in (
        userID INT PRIMARY KEY,
        email VARCHAR(255),
        user_password VARCHAR(255),
        no_of_tries INT,
        locked_up INT,
        userType VARCHAR(255),
        FOREIGN KEY (userID) REFERENCES User(userID)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Log_in: " . $conn->error . "<br>";
    }
}

function create_table_building($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Building (
        buildingID VARCHAR(8) PRIMARY KEY,
        buildingName VARCHAR(255),
        building_usage VARCHAR(255)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Building: " . $conn->error . "<br>";
    }
}

function create_table_room($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Room (
        roomID INT,
        buildingID VARCHAR(8),
        typeID VARCHAR(255),
        PRIMARY KEY(roomID, buildingID),
        FOREIGN KEY (buildingID) REFERENCES Building(buildingID)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Room: " . $conn->error . "<br>";
    }
}

function create_table_lecture($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Lecture (
        lectureRoomID INT PRIMARY KEY,
        numSeats INT,
        FOREIGN KEY (lectureRoomID) REFERENCES Room(roomID)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Room: " . $conn->error . "<br>";
    }

}


function create_table_office($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Office (
        officeRoomID INT PRIMARY KEY,
        numSeats INT,
        FOREIGN KEY (officeRoomID) REFERENCES Room(roomID)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Office: " . $conn->error . "<br>";
    }
}

function create_table_lab($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Lab (
        roomID INT PRIMARY KEY,
        numStations INT,
        FOREIGN KEY (roomID) REFERENCES Room(roomID)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Lab: " . $conn->error . "<br>";
    }
}

function create_table_faculty($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Faculty (
        facultyID INT PRIMARY KEY,
        officeRoomID INT,
        specialty VARCHAR(255),
        faculty_rank VARCHAR(255),
        faculty_type VARCHAR(255),
        FOREIGN KEY (facultyID) REFERENCES User(userID),
        FOREIGN KEY (officeRoomID) REFERENCES Office(officeRoomID)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Faculty: " . $conn->error . "<br>";
    }
}

function create_table_department($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Department (
        deptID VARCHAR(255) PRIMARY KEY,
        dept_name VARCHAR(255) NOT NULL,
        roomID INT,
        chairID INT,
        email VARCHAR(255),
        phone_number VARCHAR(20),
        dept_assistant VARCHAR(255),
        FOREIGN KEY (roomID) REFERENCES Room(roomID),
        FOREIGN KEY (chairID) REFERENCES Faculty(facultyID)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Department: " . $conn->error . "<br>";
    }
}

function create_table_faculty_dept($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Faculty_Dept (
        facultyID INT,
        deptID VARCHAR(255),
        percent_time DECIMAL(5,2),
        date_of_appointment DATE,
        PRIMARY KEY (facultyID, deptID),
        FOREIGN KEY (facultyID) REFERENCES Faculty(facultyID),
        FOREIGN KEY (deptID) REFERENCES Department(deptID)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Faculty_Dept: " . $conn->error . "<br>";
    }
}

function create_table_full_time_faculty($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Full_Time_Faculty (
        facultyID INT PRIMARY KEY,
        min_course INT,
        max_course INT,
        FOREIGN KEY (facultyID) REFERENCES Faculty(facultyID)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Full_Time_Faculty: " . $conn->error . "<br>";
    }
}

function create_table_part_time_faculty($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Part_Time_Faculty (
        facultyID INT PRIMARY KEY,
        min_course INT,
        max_course INT,
        FOREIGN KEY (facultyID) REFERENCES Faculty(facultyID)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Part_Time_Faculty: " . $conn->error . "<br>";
    }
}

function create_table_course($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Course (
        courseID INT PRIMARY KEY,
        courseName VARCHAR(100) NOT NULL,
        deptID VARCHAR(255),
        course_description TEXT,
        credits INT NOT NULL,
        type_of_course VARCHAR(100),
        FOREIGN KEY (deptID) REFERENCES Department(deptID)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Course: " . $conn->error . "<br>";
    }
}

function create_table_major($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Major (
        majorID INT PRIMARY KEY,
        deptID VARCHAR(255),
        major_name VARCHAR(250) NOT NULL,
        credits_required INT NOT NULL,
        FOREIGN KEY (deptID) REFERENCES Department(deptID)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Major: " . $conn->error . "<br>";
    }
}

function create_table_minor($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Minor (
        minorID INT PRIMARY KEY,
        deptID VARCHAR(255),
        minor_name VARCHAR(250) NOT NULL,
        credits_required INT NOT NULL,
        FOREIGN KEY (deptID) REFERENCES Department(deptID)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Minor: " . $conn->error . "<br>";
    }
}

function create_table_major_requirements($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Major_Requirements (
        majorID INT,
        courseID INT,
        min_grade VARCHAR(2),
        PRIMARY KEY (majorID, courseID),
        FOREIGN KEY (majorID) REFERENCES Major(majorID),
        FOREIGN KEY (courseID) REFERENCES Course(courseID)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Major_Requirements: " . $conn->error . "<br>";
    }
}

function create_table_minor_requirements($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Minor_Requirements (
        minorID INT,
        courseID INT,
        min_grade VARCHAR(2),
        PRIMARY KEY (minorID, courseID),
        FOREIGN KEY (minorID) REFERENCES Minor(minorID),
        FOREIGN KEY (courseID) REFERENCES Course(courseID)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Minor_Requirements: " . $conn->error . "<br>";
    }
}

function create_table_student($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Student (
        studentID INT PRIMARY KEY,
        /*majorID INT,*/
        Year DATE,
        student_type VARCHAR(255),
        FOREIGN KEY (studentID) REFERENCES User(userID)
        /*FOREIGN KEY (majorID) REFERENCES Major(majorID)*/
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Student: " . $conn->error . "<br>";
    }
}

function create_table_student_major($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Student_Major (
        studentID INT,
        majorID INT,
        date_of_declaration DATE,
        PRIMARY KEY (studentID, majorID),
        FOREIGN KEY (studentID) REFERENCES Student(studentID),
        FOREIGN KEY (majorID) REFERENCES Major(majorID)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Student_Major: " . $conn->error . "<br>";
    }
}

function create_table_student_minor($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Student_Minor (
        studentID INT,
        minorID INT,
        date_of_declaration DATE,
        PRIMARY KEY (studentID, minorID),
        FOREIGN KEY (studentID) REFERENCES Student(studentID),
        FOREIGN KEY (minorID) REFERENCES Minor(minorID)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Student_Minor: " . $conn->error . "<br>";
    }
}

function create_table_undergraduate($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Undergraduate (
        studentID INT PRIMARY KEY,
        deptID VARCHAR(255),
        student_type VARCHAR(255),
        FOREIGN KEY (studentID) REFERENCES Student(studentID),
        FOREIGN KEY (deptID) REFERENCES Department(deptID)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Undergraduate: " . $conn->error . "<br>";
    }
}

function create_table_graduate($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Graduate (
        studentID INT PRIMARY KEY,
        deptID VARCHAR(255),
        student_type VARCHAR(255),
        program VARCHAR(255),
        FOREIGN KEY (studentID) REFERENCES Student(studentID),
        FOREIGN KEY (deptID) REFERENCES Department(deptID)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Graduate: " . $conn->error . "<br>";
    }
}

function create_table_full_time_undergraduate($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Full_Time_Undergraduate (
        studentID INT PRIMARY KEY,
        deptID VARCHAR(255),
        current_year YEAR,
        max_credits INT,
        min_credits INT,
        credits_earned INT,
        FOREIGN KEY (studentID) REFERENCES Undergraduate(studentID),
        FOREIGN KEY (deptID) REFERENCES Department(deptID)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Full_Time_Undergraduate: " . $conn->error . "<br>";
    }
}

function create_table_part_time_undergraduate($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Part_Time_Undergraduate (
        studentID INT PRIMARY KEY,
        deptID VARCHAR(255),
        current_year YEAR,
        max_credits INT,
        min_credits INT,
        credits_earned INT,
        FOREIGN KEY (studentID) REFERENCES Undergraduate(studentID),
        FOREIGN KEY (deptID) REFERENCES Department(deptID)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Part_Time_Undergraduate: " . $conn->error . "<br>";
    }
}

function create_table_full_time_graduate($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Full_Time_Graduate (
        studentID INT PRIMARY KEY,
        credits_earned INT,
        thesis_year YEAR,
        FOREIGN KEY (studentID) REFERENCES Graduate(studentID)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Full_Time_Graduate: " . $conn->error . "<br>";
    }
}

function create_table_part_time_graduate($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Part_Time_Graduate (
        studentID INT PRIMARY KEY,
        deptID VARCHAR(255),
        credits_earned INT,
        thesis_year YEAR,
        FOREIGN KEY (studentID) REFERENCES Graduate(studentID),
        FOREIGN KEY (deptID) REFERENCES Department(deptID)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Part_Time_Graduate: " . $conn->error . "<br>";
    }
}

function create_table_hold($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Hold (
        holdID INT PRIMARY KEY,
        hold_type VARCHAR(255)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Hold: " . $conn->error . "<br>";
    }
}

function create_table_student_hold($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Student_Hold (
        studentID INT,
        holdID INT,
        date_of_hold DATE,
        PRIMARY KEY (studentID, holdID),
        FOREIGN KEY (holdID) REFERENCES Hold(holdID),
        FOREIGN KEY (studentID) REFERENCES Student(studentID)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Student_Hold: " . $conn->error . "<br>";
    }
}

function create_table_advisor($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Advisor (
        studentID INT PRIMARY KEY,
        facultyID INT,
        date_of_appointment DATETIME,
        FOREIGN KEY (studentID) REFERENCES Student(studentID),
        FOREIGN KEY (facultyID) REFERENCES Faculty(facultyID)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Advisor: " . $conn->error . "<br>";
    }
}

function create_table_admin($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Admin (
        adminID INT PRIMARY KEY,
        security_type VARCHAR(255),
        FOREIGN KEY (adminID) REFERENCES User(userID)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Admin: " . $conn->error . "<br>";
    }
}

function create_table_stats_staff($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Stats_Staff (
        stats_staffID INT PRIMARY KEY,
        status VARCHAR(255),
        FOREIGN KEY (stats_staffID) REFERENCES User(userID)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Stats_Staff: " . $conn->error . "<br>";
    }
}

function create_table_semester($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Semester (
        semester_name VARCHAR(255),
        semester_year INT,
        startTime DATETIME,
        endTime DATETIME,
        PRIMARY KEY (semester_name, semester_year)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Semester: " . $conn->error . "<br>";
    }
}

function create_table_day($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Day (
        dayID VARCHAR(255) PRIMARY KEY
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Day: " . $conn->error . "<br>";
    }
}

function create_table_period($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Period (
        periodID VARCHAR(255) PRIMARY KEY,
        startTime DATETIME,
        endTime DATETIME
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Period: " . $conn->error . "<br>";
    }
}

function create_table_timeslot($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Timeslot (
        TS_ID VARCHAR(255) PRIMARY KEY,
        day_ID VARCHAR(255),
        periodID VARCHAR(255),
        FOREIGN KEY (day_ID) REFERENCES Day(dayID),
        FOREIGN KEY (periodID) REFERENCES Period(periodID)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Timeslot: " . $conn->error . "<br>";
    }
}

function create_table_timeslot_day($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS TimeslotDay (
        TS_ID VARCHAR(255),
        day_ID VARCHAR(255),
        PRIMARY KEY (TS_ID, day_ID),
        FOREIGN KEY (day_ID) REFERENCES Day(dayID),
        FOREIGN KEY (TS_ID) REFERENCES Timeslot(TS_ID)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating TimeslotDay: " . $conn->error . "<br>";
    }
}

function create_table_timeslotPeriod($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS TimeslotPeriod (
        TS_ID VARCHAR(255),
        periodID VARCHAR(255),
        PRIMARY KEY (TS_ID, periodID),
        FOREIGN KEY (TS_ID) REFERENCES Timeslot(TS_ID),
        FOREIGN KEY (periodID) REFERENCES Period(periodID)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating TimeslotPeriod: " . $conn->error . "<br>";
    }
}

function create_table_course_section($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS CourseSection (
        CRN INT PRIMARY KEY,
        courseID INT,
        sectionID INT,
        timeslot VARCHAR(255),
        course_year INT,
        semester_name VARCHAR(255),
        semester_year INT,
        available_seats INT,
        facultyID INT,
        buildingID VARCHAR(8),
        roomID INT,
        FOREIGN KEY (courseID) REFERENCES Course(courseID),
        FOREIGN KEY (semester_name, semester_year) REFERENCES Semester(semester_name, semester_year),
        FOREIGN KEY (facultyID) REFERENCES Faculty(facultyID),
        FOREIGN KEY (buildingID, roomID) REFERENCES Room(buildingID, roomID),
        FOREIGN KEY (timeslot) REFERENCES Timeslot(TS_ID)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating CourseSection: " . $conn->error . "<br>";
    }
}

function create_student_history($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Student_History (
        studentID INT,
        semester_name VARCHAR(255),
        semester_year INT,
        courseID INT,
        CRN INT,
        grade VARCHAR(4),
        PRIMARY KEY (studentID, semester_name, semester_year, courseID),
        FOREIGN KEY (studentID) REFERENCES Student(studentID),
        FOREIGN KEY (semester_name, semester_year) REFERENCES Semester(semester_name, semester_year),
        FOREIGN KEY (courseID) REFERENCES Course(courseID),
        FOREIGN KEY (CRN) REFERENCES CourseSection(CRN)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Student_History: " . $conn->error . "<br>";
    }
}




function create_table_faculty_history($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Student_History (
        facultyID INT,
        semester_name VARCHAR(255),
        semester_year INT,
        courseID INT,
        CRN INT,
        PRIMARY KEY (studentID, semester_name, semester_year, courseID),
        FOREIGN KEY (studentID) REFERENCES Student(studentID),
        FOREIGN KEY (semester_name, semester_year) REFERENCES Semester(semester_name, semester_year),
        FOREIGN KEY (courseID) REFERENCES Course(courseID),
        FOREIGN KEY (CRN) REFERENCES CourseSection(CRN)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Student_History: " . $conn->error . "<br>";
    }
}

function create_table_attendance($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Attendance (
        studentID INT,
        CRN INT,
        attendance_datetime DATETIME,
        present VARCHAR(1) NOT NULL,
        PRIMARY KEY (studentID, CRN, attendance_datetime),
        FOREIGN KEY (studentID) REFERENCES Student(studentID),
        FOREIGN KEY (CRN) REFERENCES CourseSection(CRN)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Attendance: " . $conn->error . "<br>";
    }
}

function create_table_enrollment($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Enrollment (
        studentID INT,
        CRN INT,
        enroll_date DATETIME,
        grade VARCHAR(4),
        PRIMARY KEY (studentID, CRN),
        FOREIGN KEY (studentID) REFERENCES Student(studentID),
        FOREIGN KEY (CRN) REFERENCES CourseSection(CRN)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Enrollment: " . $conn->error . "<br>";
    }
}

function create_table_requirements($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Requirements (
        requirementID INT PRIMARY KEY,
        CRN INT,
        passingGrade VARCHAR(255),
        FOREIGN KEY (CRN) REFERENCES CourseSection(CRN)
    )";
    if (!$conn->query($sql)) {
        echo "Error creating Requirements: " . $conn->error . "<br>";
    }
}

function connect_database_registration($conn) {
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully<br>";
    if ($conn->query("USE registration") === FALSE) {
        die("Cannot use database registration: " . $conn->error);
    }
    echo "Connected to registration<br>";
}

function create_all_tables($conn) {
    create_table_user($conn);
    create_table_building($conn);
    create_table_semester($conn);
    create_table_day($conn);
    create_table_period($conn);
    create_table_hold($conn);
    create_table_login($conn);
    create_table_admin($conn);
    create_table_stats_staff($conn);
    create_table_room($conn);
    create_table_timeslot($conn); 
    create_table_office($conn);
    create_table_lab($conn);
    create_table_lecture($conn);

    create_table_faculty($conn);
    create_table_department($conn);
    create_table_faculty_dept($conn);
    create_table_full_time_faculty($conn);
    create_table_part_time_faculty($conn);
    create_table_course($conn);
    create_table_major($conn);
    create_table_minor($conn);
    create_table_major_requirements($conn);
    create_table_minor_requirements($conn);
    create_table_student($conn);
    create_table_student_major($conn);
    create_table_student_minor($conn);
    create_table_student_hold($conn);
    create_table_advisor($conn);
    create_table_undergraduate($conn);
    create_table_graduate($conn);
    create_table_full_time_undergraduate($conn);
    create_table_part_time_undergraduate($conn);
    create_table_full_time_graduate($conn);
    create_table_part_time_graduate($conn);
    create_table_timeslot_day($conn);
    create_table_timeslotPeriod($conn);
    create_table_course_section($conn);
    create_student_history($conn);
    create_table_attendance($conn);
    create_table_enrollment($conn);
    create_table_requirements($conn);
    create_table_faculty_history($conn);

    }


?>
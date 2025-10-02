import mysql.connector
import json

# Load JSON file
with open("students_1600_years.json", "r") as f:
    students = json.load(f)

# Connect to MySQL
conn = mysql.connector.connect(
    host="school-project.cubcw8ayasbz.us-east-1.rds.amazonaws.com",
    user="admin",
    password="system_design",
    database="registration"  # <-- replace with your DB name
)

cursor = conn.cursor()

# Insert query
sql = """
INSERT INTO Student (studentID, Year, student_type)
VALUES (%s, %s, %s)
ON DUPLICATE KEY UPDATE
    Year = VALUES(Year),
    student_type = VALUES(student_type)
"""

# Insert each student from JSON file
for s in students:
    cursor.execute(sql, (s["studentID"], s["student_Year"], s["student_type"]))

# Commit and close
conn.commit()
print(f"{cursor.rowcount} rows processed from students_1600_years.json")

cursor.close()
conn.close()

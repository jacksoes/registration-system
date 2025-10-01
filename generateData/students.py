import json
import random
print("hello")
# Load users JSON
with open("users_2103_randomIDs.json", "r") as f:
    users = json.load(f)

# Filter student users
student_users = [u for u in users if u["userType"] == "Student"]

# Shuffle for randomness
random.shuffle(student_users)

# Split counts
undergrad_count = 1200
grad_count = 400

undergrads = student_users[:undergrad_count]
grads = student_users[undergrad_count:undergrad_count + grad_count]

# Academic years
undergrad_years = ["First", "Second", "Third", "Fourth"]
grad_years = ["First", "Second"]

students = []

# Undergraduates
for u in undergrads:
    students.append({
        "studentID": u["UserID"],
        "Year": random.choice(undergrad_years),
        "student_type": "Undergraduate"
    })

# Graduates
for u in grads:
    students.append({
        "studentID": u["UserID"],
        "Year": random.choice(grad_years),
        "student_type": "Graduate"
    })

# Save to JSON
with open("students_1600_years.json", "w") as f:
    json.dump(students, f, indent=4)

print(f"✅ Created students_1600_years.json with {len(students)} student records "
      f"({len(undergrads)} Undergraduate, {len(grads)} Graduate).")

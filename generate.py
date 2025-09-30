from faker import Faker
import json
import random
from datetime import datetime, timedelta

# Initialize Faker
fake = Faker()

# Configuration for each user type
user_groups = [
    {"count": 1600, "userType": "Student", "age_min": 18, "age_max": 25},
    {"count": 500, "userType": "Faculty", "age_min": 25, "age_max": 65},
    {"count": 3, "userType": "Admin", "age_min": 25, "age_max": 60},
]

genders = ["M", "F", "O"]

def generate_dob(age_min, age_max):
    today = datetime.today()
    start_date = today - timedelta(days=365*age_max)
    end_date = today - timedelta(days=365*age_min)
    return fake.date_between(start_date=start_date, end_date=end_date).isoformat()

# Generate unique 9-digit UserIDs starting with 999
def generate_userid(existing_ids):
    while True:
        last_six = random.randint(0, 999999)
        user_id = int(f"999{last_six:06d}")
        if user_id not in existing_ids:
            existing_ids.add(user_id)
            return user_id

users = []
existing_ids = set()

for group in user_groups:
    for _ in range(group["count"]):
        user_id = generate_userid(existing_ids)
        first_name = fake.first_name()
        middle_name = fake.first_name() if random.random() < 0.5 else None
        last_name = fake.last_name()
        house_no = random.randint(1, 999)
        street_name = fake.street_name()
        city_name = fake.city()
        state_name = fake.state_abbr()
        zipcode = int(fake.zipcode()[:5])  # first 5 digits
        gender = random.choice(genders)
        dob = generate_dob(group["age_min"], group["age_max"])
        user_type = group["userType"]

        users.append({
            "UserID": user_id,
            "firstName": first_name,
            "middleName": middle_name,
            "lastName": last_name,
            "houseNo": house_no,
            "streetName": street_name,
            "city": city_name,
            "state": state_name,
            "zipcode": zipcode,
            "gender": gender,
            "DOB": dob,
            "userType": user_type
        })

# Save to JSON file
with open("users_2103_randomIDs.json", "w") as f:
    json.dump(users, f, indent=4)

print(f"✅ Generated {len(users)} users in 'users_2103_randomIDs.json'")

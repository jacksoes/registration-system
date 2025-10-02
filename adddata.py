
'''
import mysql.connector
import json

# Connect to MySQL
def get_connection():
    return mysql.connector.connect(
        host="school-project.cubcw8ayasbz.us-east-1.rds.amazonaws.com",
        user="admin",
        password="system_design",
        database="registration"
    )

# Insert a single user record
def insert_user(user):
    conn = get_connection()
    cursor = conn.cursor()


    
    

    # Run a SELECT query
    cursor.execute("SELECT userID FROM User LIMIT 5")

    # Fetch results
    rows = cursor.fetchall()

    for row in rows:
        print(row)

    # Close connection
    cursor.close()
    conn.close()

'''
    sql = """
        INSERT INTO User (
            userID, first_name, middle_name, last_name,
            house_APT_number, street_name, city_name, state_name,
            zipcode, gender, DOB, user_type
        )
        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
    """

    values = (
        user["UserID"],
        user.get("firstName"),
        user.get("middleName"),
        user.get("lastName"),
        user.get("houseNo"),
        user.get("streetName"),
        user.get("city"),
        user.get("state"),
        user.get("zipcode"),
        user.get("gender"),
        user.get("DOB"),
        user.get("userType")
    )

    cursor.execute(sql, values)
    conn.commit()
    cursor.close()
    conn.close()
    print(f"✅ Inserted user {user['UserID']}")

'''

# Insert multiple users from JSON file
def insert_users_from_json(json_file):
    with open(json_file, "r") as f:
        data = json.load(f)

    if isinstance(data, list):
        for user in data:
            insert_user(user)
    elif isinstance(data, dict):
        insert_user(data)
    else:
        raise ValueError("Invalid JSON format for user data")

if __name__ == "__main__":
    insert_users_from_json("users_2103_randomIDs.json")
'''



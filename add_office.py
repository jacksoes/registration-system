import mysql.connector
import json
import os

# Connect to MySQL
def get_connection():
    return mysql.connector.connect(
        host="school-project.cubcw8ayasbz.us-east-1.rds.amazonaws.com",
        user="admin",
        password="system_design",
        database="registration"
    )

# Insert a single room
def insert_room(room):
    conn = get_connection()
    cursor = conn.cursor()

    sql = """
        INSERT INTO Room (roomID, buildingID, typeID)
        VALUES (%s, %s, %s)
    """

    values = (
        room["roomID"],
        room["buildingID"],
        room["typeID"]
    )

    try:
        cursor.execute(sql, values)
        conn.commit()
        print(f"✅ Inserted room {room['roomID']}")
    except mysql.connector.Error as err:
        print(f"❌ Error inserting room {room['roomID']}: {err}")
    finally:
        cursor.close()
        conn.close()

# Insert multiple rooms from JSON
def insert_rooms_from_json(json_file):
    with open(json_file, "r") as f:
        data = json.load(f)

    if isinstance(data, list):
        for room in data:
            insert_room(room)
    else:
        raise ValueError("Invalid JSON format for room data")

# Generate rooms.json in current directory
def generate_rooms_json():
    rooms = []
    room_id = 1

    # 250 offices, buildingID=2
    for _ in range(250):
        rooms.append({"roomID": room_id, "buildingID": "FO", "typeID": "office"})
        room_id += 1

    # 175 lecture rooms, buildingID=0
    for _ in range(175):
        rooms.append({"roomID": room_id, "buildingID": "AH", "typeID": "lecture"})
        room_id += 1

    # 75 labs, buildingID=1
    for _ in range(75):
        rooms.append({"roomID": room_id, "buildingID": "LB", "typeID": "lab"})
        room_id += 1

    filename = os.path.join(os.getcwd(), "rooms.json")
    with open(filename, "w") as f:
        json.dump(rooms, f, indent=4)

    print(f"📂 Generated {filename} with {len(rooms)} rooms")

if __name__ == "__main__":
    generate_rooms_json()                # Step 1: Create the file
    insert_rooms_from_json("rooms.json") # Step 2: Insert into DB

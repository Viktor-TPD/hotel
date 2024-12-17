<?php
// Connect to SQLite database (creates the database file if it doesn't exist)
$db = new PDO('sqlite:hotel.db');

// Function to execute a query
function executeQuery($db, $query)
{
    try {
        $stmt = $db->prepare($query);
        $stmt->execute();
        echo "Query executed successfully.\n";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

// SQL QUERIES
$queries = [
    // "--ADMIN SETTINGS
    // CREATE TABLE IF NOT EXISTS admin_settings (
    // id INTEGER PRIMARY KEY AUTOINCREMENT,
    // stars INTEGER NOT NULL,
    // greeting_message VARCHAR(60) NOT NULL,
    // image_url VARCHAR(200) NOT NULL
    // );",

    // "--ROOMS
    // CREATE TABLE IF NOT EXISTS rooms (
    // id INTEGER PRIMARY KEY AUTOINCREMENT,
    // type VARCHAR(60) NOT NULL,
    // price DECIMAL(10, 2) NOT NULL
    // );",

    // "-- AMENITIES
    // CREATE TABLE IF NOT EXISTS amenities (
    // id INTEGER PRIMARY KEY AUTOINCREMENT,
    // type VARCHAR(60) NOT NULL,
    // price DECIMAL(10, 2) NOT NULL
    // );",

    // "--GUESTS
    // CREATE TABLE IF NOT EXISTS guests (
    // id INTEGER PRIMARY KEY AUTOINCREMENT,
    // transfer_code VARCHAR(50) NOT NULL
    // );",

    // "--AMENITIES_GUESTS
    // CREATE TABLE IF NOT EXISTS amenities_guests (
    // id INTEGER PRIMARY KEY AUTOINCREMENT,
    // amenities_id INTEGER NOT NULL,
    // guests_id INTEGER NOT NULL,
    // FOREIGN KEY (amenities_id) REFERENCES amenities(id),
    // FOREIGN KEY (guests_id) REFERENCES guests_id
    // );",

    // "--BOOKINGS
    // CREATE TABLE IF NOT EXISTS bookings (
    // id INTEGER PRIMARY KEY AUTOINCREMENT,
    // guests_id INTEGER NOT NULL,
    // room_id INTEGER NOT NULL,
    // room_price DECIMAL(10,2) NOT NULL,
    // arrival_date DATE NOT NULL,
    // departure_date DATE NOT NULL,
    // total_price DECIMAL(10,2),
    // FOREIGN KEY (guests_id) REFERENCES guests(id),
    // FOREIGN KEY (room_id) REFERENCES rooms(id)
    // );",
    // "INSERT INTO rooms (type,price)
    // VALUES ('budget',1.00),
    // ('standard',2.00),
    // ('luxury',3.00)
    // "
];

// EXECUTE
foreach ($queries as $query) {
    executeQuery($db, $query);
}

echo "Database and tables created successfully.\n";

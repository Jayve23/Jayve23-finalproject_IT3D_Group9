<?php
// Database configuration
$servername = "localhost";  // Change to your server's hostname
$username = "root";         // Change to your database username
$password = "";             // Change to your database password
$dbname = "lost_and_found"; // Database name to be created

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully or already exists.<br>";
} else {
    echo "Error creating database: " . $conn->error;
}

// Select the created database
$conn->select_db($dbname);

// Create Users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    echo "Table 'users' created successfully.<br>";
} else {
    echo "Error creating 'users' table: " . $conn->error;
}

// Create Lost Items table
$sql = "CREATE TABLE IF NOT EXISTS lost_items (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(255) NOT NULL,
    description TEXT,
    location VARCHAR(255),
    date_lost TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_id INT(11),
    image_path VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id)
)";
if ($conn->query($sql) === TRUE) {
    echo "Table 'lost_items' created successfully.<br>";
} else {
    echo "Error creating 'lost_items' table: " . $conn->error;
}

// Create Found Items table
$sql = "CREATE TABLE IF NOT EXISTS found_items (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(255) NOT NULL,
    description TEXT,
    location VARCHAR(255),
    date_found TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_id INT(11),
    image_path VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id)
)";
if ($conn->query($sql) === TRUE) {
    echo "Table 'found_items' created successfully.<br>";
} else {
    echo "Error creating 'found_items' table: " . $conn->error;
}

// Create Retrieved Items table
$sql = "CREATE TABLE IF NOT EXISTS retrieved_items (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(255) NOT NULL,
    description TEXT,
    location VARCHAR(255),
    date_retrieved TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_id INT(11),
    image_path VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id)
)";
if ($conn->query($sql) === TRUE) {
    echo "Table 'retrieved_items' created successfully.<br>";
} else {
    echo "Error creating 'retrieved_items' table: " . $conn->error;
}

// Close connection
$conn->close();
?>

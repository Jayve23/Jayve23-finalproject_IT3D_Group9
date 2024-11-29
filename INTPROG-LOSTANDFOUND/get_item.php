<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "lost_and_found";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM lost_items WHERE id = $id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(["error" => "Item not found."]);
    }

    $conn->close();
} else {
    echo json_encode(["error" => "Invalid item ID."]);
}
?>

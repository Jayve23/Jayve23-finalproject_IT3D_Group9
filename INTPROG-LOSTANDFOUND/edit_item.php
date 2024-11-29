<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $item_name = $_POST['item_name'];
    $description = $_POST['description'];
    $location = $_POST['location'];

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "lost_and_found";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle file upload if a new image is provided
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $image_path = $target_file;

        $sql = "UPDATE lost_items SET item_name='$item_name', description='$description', location='$location', image_path='$image_path' WHERE id=$id";
    } else {
        $sql = "UPDATE lost_items SET item_name='$item_name', description='$description', location='$location' WHERE id=$id";
    }

    if ($conn->query($sql) === TRUE) {
        echo "<style>
                body {
                    background-color: #f0f0f0;
                    font-family: Arial, sans-serif;
                }
                .message {
                    padding: 20px;
                    background-color: #4CAF50;
                    color: white;
                    margin: 15px 0;
                    border-radius: 4px;
                    text-align: center;
                }
              </style>";
        echo "<div class='message'>Item updated successfully.
                <button onclick='window.location.href=\"amlost.php\"'>OK</button>
            </div>";
            
    } else {
        echo "<style>
                body {
                    background-color: #f0f0f0;
                    font-family: Arial, sans-serif;
                }
                .message {
                    padding: 20px;
                    background-color: #f44336;
                    color: white;
                    margin: 15px 0;
                    border-radius: 4px;
                    text-align: center;
                }
              </style>";
        echo "<div class='message'>Error updating item: " . $conn->error . "</div>";
    }

    $conn->close();
}
?>

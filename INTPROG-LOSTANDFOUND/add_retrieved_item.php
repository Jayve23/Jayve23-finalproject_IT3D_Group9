<?php
session_start();
// Check if the user is an admin
if (!isset($_SESSION['id']) || $_SESSION['email'] != "admin@gmail.com") {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_name = $_POST['item_name'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $date_retrieved = $_POST['date_retrieved'];
    $user_id = $_SESSION['id'];

    // Ensure the uploads directory exists
    if (!file_exists('uploads')) {
        mkdir('uploads', 0777, true);
    }

    // Handle file upload if an image is provided
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = $target_file;
        } else {
            $image_path = "";
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        $image_path = "";
    }

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "lost_and_found";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert into database
    $sql = "INSERT INTO retrieved_items (item_name, description, location, date_retrieved, image_path, user_id) 
            VALUES ('$item_name', '$description', '$location', '$date_retrieved', '$image_path', $user_id)";
    
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
                .message button {
                    background-color: #4CAF50;
                    color: white;
                    border: none;
                    padding: 10px 20px;
                    margin-top: 10px;
                    border-radius: 5px;
                    cursor: pointer;
                    font-size: 16px;
                }
                .message button:hover {
                    background-color: #45a049;
                }
              </style>";
        echo "<div class='message'>
                <p>Item added successfully.</p>
                <button onclick='window.location.href=\"amretrieved.php\"'>OK</button>
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
                .message button {
                    background-color: #f44336;
                    color: white;
                    border: none;
                    padding: 10px 20px;
                    margin-top: 10px;
                    border-radius: 5px;
                    cursor: pointer;
                    font-size: 16px;
                }
                .message button:hover {
                    background-color: #d32f2f;
                }
              </style>";
        echo "<div class='message'>
                <p>Error adding item: " . $conn->error . "</p>
                <button onclick='window.location.href=\"amretrieved.php\"'>OK</button>
              </div>";
    }

    $conn->close();
}
?>

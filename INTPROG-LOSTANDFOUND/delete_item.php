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

    $sql = "DELETE FROM lost_items WHERE id = $id";
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
        echo "<div class='message'>Item deleted successfully.</div>";
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
        echo "<div class='message'>Error deleting item: " . $conn->error . "</div>";
    }

    $conn->close();
}
?>

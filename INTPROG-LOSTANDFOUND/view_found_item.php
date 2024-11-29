<?php
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Ensure the ID is an integer

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "lost_and_found";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM found_items WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $item = $result->fetch_assoc();

        echo "<style>
                .modal-content {
                    background-color: #fefefe;
                    margin: 5% auto;
                    padding: 20px;
                    border: 1px solid #888;
                    width: 80%;
                    border-radius: 10px;
                }
                .close {
                    color: #aaa;
                    float: right;
                    font-size: 28px;
                    font-weight: bold;
                }
                .close:hover, .close:focus {
                    color: black;
                    text-decoration: none;
                    cursor: pointer;
                }
                img {
                    max-width: 100%;
                    height: auto;
                    display: block;
                    margin-top: 20px;
                }
              </style>";
        echo "<div class='modal-content'>";
        echo "<span class='close'>&times;</span>";
        echo "<h3>Item Name: " . $item['item_name'] . "</h3>";
        echo "<p>Description: " . $item['description'] . "</p>";
        echo "<p>Location: " . $item['location'] . "</p>";
        echo "<p>Date Found: " . $item['date_found'] . "</p>";
        if (!empty($item['image_path'])) {
            echo "<img src='" . $item['image_path'] . "' alt='" . $item['item_name'] . "'>";
        } else {
            echo "<p>No image available for this item.</p>";
        }
        echo "</div>";
    } else {
        echo "Item not found.";
    }
    $conn->close();
} else {
    echo "Invalid item ID.";
}
?>

<?php
session_start();
// Check if the user is an admin
if (!isset($_SESSION['id']) || $_SESSION['email'] != "admin@gmail.com") {
    header("Location: login.php");
    exit();
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

// Get the lost items
$lost_items = $conn->query("SELECT * FROM lost_items");

if ($conn->error) {
    die("Query failed: " . $conn->error);
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Lost Items</title>
    <script src="https://kit.fontawesome.com/f8e1a90484.js" crossorigin="anonymous"></script>
    <style> 
   /* Global styles */
   * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: sans-serif;
        }

        /* Full page height and background */
        html, body {
            height: 100%;
            width: 100%;
            background: rgb(244, 244, 203);
        }

        /* Navbar styling */
        nav {
            padding: 10px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(90deg, rgba(255,204,0,1) 0%, rgba(6,59,58,1) 0%, rgba(11,142,88,1) 100%, rgba(255,204,0,1) 100%);
            position: relative;
            height: 70px;
        }

        nav .logo {
            color: #fff;
            font-size: 24px;
            font-weight: bold;
        }

        nav ul {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        nav ul li {
            list-style-type: none;
        }

        button {
            padding: 10px 30px;
            background-color: rgba(11,142,88,1);
            border: none;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: rgba(6,59,58,1);
        }

        nav ul li a {
            text-decoration: none;
            color: #fff;
            font-size: 16px;
            font-weight: 500;
        }

        nav ul li a:hover {
            color: #9df385;
        }
    /* Menu icon (hamburger) for mobile view */ 
    .menu-icon { 
        display: none; 
    } 
    .menu-icon i { 
        color: #fff; 
        font-size: 30px;
    } 
    /* Admin dashboard content */ 
    .admin-dashboard { 
        padding: 40px; 
        background-color: #fff; 
        margin-top: 20px; 
        border-radius: 10px; 
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
        min-height: calc(100vh - 70px); 
    } 
    /* Table styles */ table { 
        width: 100%; 
        border-collapse: collapse; 
        margin-bottom: 20px; 
    } 
    table th, table td { 
        padding: 12px 15px; 
        text-align: left; 
        border-bottom: 1px solid #ddd; 
    } 
    table th { 
        background-color: #f4f4f4; 
        color: #333; 
        font-weight: bold; 
    } 
    table tr:nth-child(even) { 
        background-color: #f9f9f9;
    } 
    table tr:hover { 
        background-color: #f1f1f1; 
    } 
    table tr:last-child td { 
        border-bottom: none;
    } 
    /* Modal styles */ 
    .modal { 
        display: none; 
        position: fixed; 
        z-index: 1; 
        left: 0; 
        top: 0; 
        width: 100%; 
        height: 100%; 
        overflow: auto; 
        background-color: rgb(0,0,0); 
        background-color: rgba(0,0,0,0.4); 
        padding-top: 60px; 
    } 
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
    /* Buttons */ 
    .btn-view, .btn-edit, .btn-delete { 
        padding: 10px 20px; 
        margin: 5px; 
        border: none; 
        border-radius: 5px; 
        cursor: pointer; 
        font-size: 16px; 
        color: #fff; 
    } 
    .btn-view { 
        background-color: #0b8e58; 
    } 
    .btn-view:hover { 
        background-color: #065b3a; 
    } 
    .btn-edit { 
        background-color: #ffaa00; 
    } 
    .btn-edit:hover { 
        background-color: #cc8400; 
    } 
    .btn-delete { 
        background-color: #ff4444; 
    } 
    .btn-delete:hover { 
        background-color: #cc0000; 
    } 
    /* Responsive design for smaller screens */ 
    @media (max-width: 600px) { 
    nav ul { 
        position: absolute; 
        top: 70px; 
        left: 0; 
        right: 0; 
        flex-direction: column; 
        text-align: center; 
        background: green; 
        gap: 0; 
        overflow: hidden; 
    } 
    nav ul li { 
        padding: 20px; 
        padding-top: 10; 
    } 
    .menu-icon { 
        display: block; 
    } 
    #menuList { 
        transition: all 0.5s; 
    } 
    /* Make menu visible when clicked */ 
    #menuList.open { 
        max-height: 300px; 
    } 
    .admin-dashboard { 
        padding: 20px; 
        } 
    } 
    </style>
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 10px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        label {
            display: block;
            margin-top: 10px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        textarea,
        input[type="file"],
        input[type="datetime-local"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        .btn-view, .btn-edit, .btn-delete, .btn-add {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            color: #fff;
        }

        .btn-view {
            background-color: #0b8e58;
        }

        .btn-view:hover {
            background-color: #065b3a;
        }

        .btn-edit {
            background-color: #ffaa00;
        }

        .btn-edit:hover {
            background-color: #cc8400;
        }

        .btn-delete {
            background-color: #ff4444;
        }

        .btn-delete:hover {
            background-color: #cc0000;
        }

        .btn-add {
            background-color: #1a73e8;
        }

        .btn-add:hover {
            background-color: #155ab6;
        }
    </style>
</head>
<body>
<nav>
        <div class="logo">
            <h1>Welcome, Admin!</h1>
        </div>
        <ul id="menuList">
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="amlost.php">Lost</a></li>
            <li><a href="amfound.php">Found</a></li>
            <li><a href="amretrieved.php">Retrieved</a></li>
            <li><a href="about.php">About</a></li>
            <form method="POST" action="admin_dashboard.php">
            <button type="submit" name="logout">Logout</button>
            </form>
        </ul>
        <div class="menu-icon">
            <i class="fa-solid fa-bars" onclick="toggleMenu()"></i>
        </div>
    </nav>

    <div class="admin-dashboard">
        <h1>Lost Items</h1>
        <button class="btn-add" id="btnAddLostItem">ADD LOST ITEM</button>
        <table>
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Description</th>
                    <th>Location</th>
                    <th>Date Lost</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $lost_items->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['item_name']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['location']; ?></td>
                        <td><?php echo $row['date_lost']; ?></td>
                        <td>
                            <button class="btn-view" data-id="<?php echo $row['id']; ?>">View</button>
                            <button class="btn-edit" data-id="<?php echo $row['id']; ?>">Edit</button>
                            <button class="btn-delete" data-id="<?php echo $row['id']; ?>">Delete</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <style> 
    .modal { 
        display: none; 
        position: fixed; 
        z-index: 1; 
        left: 0; 
        top: 0; 
        width: 100%; 
        height: 100%; 
        overflow: auto; 
        background-color: rgba(0,0,0,0.4); 
        padding-top: 60px; 
    } 
    .modal-content { 
        background-color: #fefefe;
        margin: 5% auto; 
        padding: 20px; 
        border: 1px solid #888; 
        width: 80%; 
        max-width: 500px; 
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
    label { 
        display: block; 
        margin-top: 10px; 
        margin-bottom: 5px; 
        font-weight: bold; 
    } input[type="text"], textarea, input[type="file"] { width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; } button[type="submit"] { background-color: #4CAF50; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 16px; } button[type="submit"]:hover { background-color: #45a049; } </style>
    <!-- Add Item Modal -->
    <div id="addItemModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Add Lost Item</h2>
        <form id="addItemForm" method="POST" action="add_lost_item.php" enctype="multipart/form-data">
            <label for="addItemName">Item Name:</label>
            <input type="text" name="item_name" id="addItemName" required>
            <label for="addDescription">Description:</label>
            <textarea name="description" id="addDescription"></textarea>
            <label for="addLocation">Location:</label>
            <input type="text" name="location" id="addLocation" required>
            <label for="addDateLost">Date Lost:</label>
            <input type="datetime-local" name="date_lost" id="addDateLost" required>
            <label for="addImage">Image:</label>
            <input type="file" name="image" id="addImage" accept="image/*">
            <button type="submit">Add Item</button>
        </form>
    </div>
</div>

<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.4);
        padding-top: 60px;
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 500px;
        border-radius: 10px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    label {
        display: block;
        margin-top: 10px;
        margin-bottom: 5px;
        font-weight: bold;
    }

    input[type="text"],
    textarea,
    input[type="file"],
    input[type="datetime-local"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    button[type="submit"] {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    button[type="submit"]:hover {
        background-color: #45a049;
    }
</style>


    <!-- View Modal -->
    <div id="viewModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Item Details</h2>
            <div id="itemDetails"></div>
        </div>
    </div>

    <!-- Edit Modal -->
    <!-- Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Edit Item</h2>
        <form id="editForm" method="POST" action="edit_lost_item.php" enctype="multipart/form-data">
            <input type="hidden" name="id" id="editId">
            <label for="editItemName">Item Name:</label>
            <input type="text" name="item_name" id="editItemName">
            <label for="editDescription">Description:</label>
            <textarea name="description" id="editDescription"></textarea>
            <label for="editLocation">Location:</label>
            <input type="text" name="location" id="editLocation">
            <label for="editDateLost">Date Lost:</label>
            <input type="datetime-local" name="date_lost" id="editDateLost">
            <label for="editImage">Image:</label>
            <input type="file" name="image" id="editImage" accept="image/*">
            <button type="submit">Save</button>
        </form>
    </div>
</div>


    <!-- Delete Confirmation -->
    <div id="deleteConfirmation" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this item?</p>
            <button id="confirmDelete">Yes</button>
            <button id="cancelDelete">No</button>
        </div>
    </div>

    <script>
    // Toggle menu script
    let menuList = document.getElementById("menuList");
    menuList.style.maxHeight = "0px";

    function toggleMenu() {
        if(menuList.style.maxHeight === "0px") {
            menuList.style.maxHeight = "300px";
        } else {
            menuList.style.maxHeight = "0px";
        }
    }

    // View, Edit, and Delete functionality
    const viewModal = document.getElementById("viewModal");
    const editModal = document.getElementById("editModal");
    const addItemModal = document.getElementById("addItemModal");
    const deleteConfirmation = document.getElementById("deleteConfirmation");
    const closeButtons = document.querySelectorAll(".close");

    closeButtons.forEach(button => {
        button.addEventListener("click", () => {
            viewModal.style.display = "none";
            editModal.style.display = "none";
            addItemModal.style.display = "none";
            deleteConfirmation.style.display = "none";
        });
    });

    window.onclick = function(event) {
        if (event.target === viewModal || event.target === editModal || event.target === addItemModal || event.target === deleteConfirmation) {
            viewModal.style.display = "none";
            editModal.style.display = "none";
            addItemModal.style.display = "none";
            deleteConfirmation.style.display = "none";
        }
    }

    // Add item functionality
    document.getElementById("btnAddLostItem").onclick = function() {
        addItemModal.style.display = "block";
    };

    // View item details
    document.querySelectorAll(".btn-view").forEach(button => {
        button.addEventListener("click", (e) => {
            const id = e.target.dataset.id;
            fetch(`view_item.php?id=${id}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById("itemDetails").innerHTML = data;
                    viewModal.style.display = "block";
                });
        });
    });

    // Edit item details
    document.querySelectorAll(".btn-edit").forEach(button => {
        button.addEventListener("click", (e) => {
            const id = e.target.dataset.id;
            fetch(`get_item.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById("editId").value = data.id;
                    document.getElementById("editItemName").value = data.item_name;
                    document.getElementById("editDescription").value = data.description;
                    document.getElementById("editLocation").value = data.location;
                    document.getElementById("editDateLost").value = data.date_lost.replace(' ', 'T');
                    editModal.style.display = "block";
                });
        });
    });

    // Delete item
    document.querySelectorAll(".btn-delete").forEach(button => {
        button.addEventListener("click", (e) => {
            const id = e.target.dataset.id;
            deleteConfirmation.style.display = "block";
            document.getElementById("confirmDelete").onclick = function() {
                fetch(`delete_item.php?id=${id}`)
                    .then(response => {
                        if (response.ok) {
                            location.reload();
                        }
                    });
            };
            document.getElementById("cancelDelete").onclick = function() {
                deleteConfirmation.style.display = "none";
            };
        });
    });
</script>

</body>
</html>

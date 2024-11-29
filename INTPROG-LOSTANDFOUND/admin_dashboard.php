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

// Get the count of lost, found, and retrieved items
$lost_count = $conn->query("SELECT COUNT(*) AS count FROM lost_items")->fetch_assoc()['count'];
$found_count = $conn->query("SELECT COUNT(*) AS count FROM found_items")->fetch_assoc()['count'];
$retrieved_count = $conn->query("SELECT COUNT(*) AS count FROM retrieved_items")->fetch_assoc()['count'];

// Get the 5 newest users
$new_users = $conn->query("SELECT name, email, date_created FROM users ORDER BY date_created DESC LIMIT 5");

if ($conn->error) {
    die("Query failed: " . $conn->error);
}

if (isset($_POST['logout'])) {
    // Destroy the session to log the user out
    session_unset();
    session_destroy();
    // Redirect to login page after logout
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
            background: linear-gradient(40deg, rgba(255,204,0,1) 0%, rgba(6,59,58,1) 0%, rgba(11,142,88,1) 100%, rgba(255,204,0,1) 100%);
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

        /* Heading and welcome message */
        .admin-dashboard h1 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #333;
        }

        .stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .stat-item {
            background: #f0f0f0;
            padding: 20px;
            border-radius: 8px;
            width: 30%;
            text-align: center;
        }

        .stat-item h2 {
            font-size: 22px;
            margin-bottom: 10px;
            color: #666;
        }

        .stat-item p {
            font-size: 24px;
            color: #333;
        }

        .btn-view {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            background: #0b8e58;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-view:hover {
            background: #065b3a;
        }

        .table-section {
            margin-top: 30px;
        }

        .table-section h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        table {
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

            .stats {
                flex-direction: column;
            }

            .stat-item {
                width: 100%;
                margin-bottom: 20px;
            }
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
        <h1>Admin Dashboard</h1>

        <div class="stats">
            <div class="stat-item">
                <h2>Lost Items</h2>
                <p><?php echo $lost_count; ?></p>
                <a href="amlost.php" class="btn-view">View</a>
            </div>
            <div class="stat-item">
                <h2>Found Items</h2>
                <p><?php echo $found_count; ?></p>
                <a href="amfound.php" class="btn-view">View</a>
            </div>
            <div class="stat-item">
                <h2>Retrieved Items</h2>
                <p><?php echo $retrieved_count; ?></p>
                <a href="amretrieved.php" class="btn-view">View</a>
            </div>
        </div>

    <script>
        let menuList = document.getElementById("menuList");
        menuList.style.maxHeight = "0px";

        function toggleMenu(){
            if(menuList.style.maxHeight == "0px")
            {
                menuList.style.maxHeight = "300px";
            }
            else{
                menuList.style.maxHeight = "0px";
            }
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>

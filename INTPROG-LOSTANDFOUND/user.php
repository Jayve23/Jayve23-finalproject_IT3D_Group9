<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Logout logic
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
    <title>Lost and Found</title>
    <link rel="stylesheet" href="user.css">    
</head>
<body>
    <nav>
        <div class="logo">
            <h1>Lost and Found</h1>
        </div>
        <ul id="menuList">
            <li><a href="">Home</a></li>
            <li><a href="">Report</a></li>
            <li><a href="">Notification</a></li>
            <li><a href="">Message</a></li>
            <form method="POST" action="user.php">
                <button type="submit" name="logout">Logout</button>
            </form>
        </ul>
        <div class="menu-icon">
            <i class="fa-solid fa-bars" onclick="toggleMenu()"></i>
        </div>
    </nav>



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
    <script src="https://kit.fontawesome.com/f8e1a90484.js" crossorigin="anonymous"></script>
</body>
</html>

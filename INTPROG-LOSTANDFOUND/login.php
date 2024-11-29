<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "lost_and_found");

// Check for connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Registration Handling
if (isset($_POST['register'])) {
    // Sanitize user inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);

    // Check if passwords match
    if ($password === $cpassword) {
        // Check if the email is already registered
        $sql_check = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql_check);

        if ($result->num_rows > 0) {
            $_SESSION['error'] = "Email is already registered.";
        } else {
            // Insert new user into the database
            $sql_insert = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
            if ($conn->query($sql_insert) === TRUE) {
                $_SESSION['message'] = "Registration successful! Please log in.";
            } else {
                $_SESSION['error'] = "Error: " . $conn->error;
            }
        }
    } else {
        $_SESSION['error'] = "Passwords do not match.";
    }
}

// Login Handling
if (isset($_POST['login'])) {
    // Sanitize user inputs
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to check if user exists
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch user data
        $row = $result->fetch_assoc();

        // Set session variables
        $_SESSION['id'] = $row['id'];
        $_SESSION['email'] = $row['email'];

        // Check if the user is an admin
        if ($_SESSION['email'] == "admin@gmail.com") {
            // Redirect to admin dashboard
            header("Location: admin_dashboard.php");
            exit();
        } else {
            // Redirect to user home page
            header("Location: user.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Invalid email or password.";
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login & Register</title>
</head>
<body>
    <div class="container" id="container">
        <!-- Registration Form -->
        <div class="form-container sign-up">
            <form method="POST">
                <h1>REGISTER</h1>
                <span>Use your Institutional Email for Registration</span><br><br>
                <input type="text" name="name" placeholder="Fullname" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="cpassword" placeholder="Confirm Password" required><br>
                <button type="submit" name="register">Register</button>
            </form>
        </div>

        <!-- Login Form -->
        <div class="form-container sign-in">
            <form method="POST">
                <h1>SIGN IN</h1>
                <span>Use your Email and Password</span><br><br>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <a href="#">Forget Your Password?</a>
                <button type="submit" name="login">Log-In</button>
            </form>
        </div>

        <!-- Toggle Container -->
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Log in to track lost items or view found objects within the Lost and Found system.</p>
                    <button class="hidden" id="login">Log-in</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Welcome to Lost and Found System</h1>
                    <p>Register now!</p>
                    <button class="hidden" id="register">Register</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    // Display any error or success messages
    if (isset($_SESSION['error'])) {
        echo "<script>alert('" . $_SESSION['error'] . "');</script>";
        unset($_SESSION['error']);
    }

    if (isset($_SESSION['message'])) {
        echo "<script>alert('" . $_SESSION['message'] . "');</script>";
        unset($_SESSION['message']);
    }
    ?>

    <script src="script.js"></script>
</body>
</html>

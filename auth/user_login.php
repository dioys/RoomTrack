<?php
require_once __DIR__ . '/../includes/db_connection.php';

// Start session for storing user data
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $name     = $_GET['name'];
    $password = $_GET['password'];
    
    $conn = getDBConnection();
    
    // Fetch user from database by name
    $stmt = $conn->prepare("SELECT user_id, name, password FROM users WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $user_name, $stored_password);
        $stmt->fetch();
        
        // Verify the entered password with the stored hashed password
        if (password_verify($password, $stored_password)) {
            // Store user data in session
            $_SESSION["user_id"] = $user_id;
            $_SESSION["name"] = $user_name;
            header("Location: welcome.php");  // Redirect to welcome page
            exit();
        } else {
            $error = "Invalid name or password.";
        }
    } else {
        $error = "Invalid name or password.";
    }
    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Form</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.8/css/all.min.css" />
</head>
<body>
    <div class="wrapper">
        <div class="title"><span>Login Form</span></div>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="row">
                <i class="fas fa-user"></i>
                <input type="text" name="name" placeholder="Name" required />
            </div>
            <div class="row">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required />
            </div>
            
            <div class="row button">
                <input type="submit" value="Login"/>
            </div>
            <div class="signup-link">Not a member? <a href="register.php">Register Now</a></div>
        </form>
    </div>
</body>
</html>

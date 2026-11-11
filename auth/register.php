<?php
require __DIR__ . '/../includes/db_connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 'Admin') {
                header("Location: ../admin/admin_panel.php");
            } else {
                header("Location: ../pages/rooms.php");
            }
            exit();
        } else {
            $error = "Invalid credentials.";
        }
    } else {
        $error = "No user found with this email.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Background setup */
        body {
            background-image: url('../assets/images/index.png');
            background-size: 1600px 770px;
            background-position: center;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #000000;
            font-family: Arial, sans-serif;
        }

        /* Positioning the login form */
        .index {
            position: absolute;
            left: 350px;
            top: 40%;
            transform: translateY(-50%);
            text-align: center;
            display: flex;
            flex-direction: column;
            gap: 60px;
        }

        /* Make form transparent */
        .form-container {
            background: rgba(5, 16, 148, 0.8); /* 80% opacity */
            backdrop-filter: blur(10px); /* blur the background behind */
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            width: 100%;
            max-width: 400px;
        }

        /* Glowing buttons */
        .glow-button {
            background-color: #fbfb00;
            color: black;
            padding: 0.5rem;
            width: 100%;
            border-radius: 0.5rem;
            text-align: center;
            transition: all 0.4s ease;
            display: inline-block;
        }

        .glow-button:hover {
            background-color: #ffee00;
            box-shadow: 0 0 15px #0C023E, 0 0 25px #0C023E, 0 0 35px #0C023E;
            transform: translateY(-3px);
        }
    </style>
</head>
<body>
    <div class="index">
        <div class="form-container">
            <h2 class="text-2xl font-bold mb-6 text-center text-[#f8fdff]">Login to Your Account</h2>
            
            <form method="POST" class="space-y-4">
                <input 
                    type="email" 
                    name="email" 
                    placeholder="Email Address" 
                    required 
                    class="w-full px-4 py-2 border border-[#CEF3FD] rounded-lg bg-[#CEF3FD] text-[#2E4156] focus:outline-none focus:ring-2 focus:ring-[#2E4156]"
                >
                <input 
                    type="password" 
                    name="password" 
                    placeholder="Password" 
                    required 
                    class="w-full px-4 py-2 border border-[#CEF3FD] rounded-lg bg-[#CEF3FD] text-[#2E4156] focus:outline-none focus:ring-2 focus:ring-[#2E4156]"
                >
                <button 
                    type="submit" 
                    class="glow-button"
                >
                    Login
                </button>
            </form>

            <?php if (isset($error)): ?>
                <p class="text-red-500 text-sm mt-4 text-center"><?= htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <div class="mt-6 text-center">
                <!-- Back to Home as a glowing button -->
                <a 
                    href="../index.php" 
                    class="glow-button"
                >
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</body>
</html>

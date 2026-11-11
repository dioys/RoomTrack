<?php
require __DIR__ . '/../includes/db_connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $role     = $_POST['role'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "Email already taken. Please choose another one.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $hashed_password, $role);
        
        if ($stmt->execute()) {
            $success = "Registration successful! You can now log in.";
        } else {
            $error = "Error occurred during registration. Please try again.";
        }
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
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

        /* Positioning the form */
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

        /* Transparent form container */
        .form-container {
            background: rgba(5, 16, 148, 0.8); /* 80% opacity */
            backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            width: 100%;
            max-width: 400px;
        }

        /* Glowing buttons */
        .glow-button {
            background-color: #1S2D42;
            color: white;
            padding: 0.5rem;
            width: 100%;
            border-radius: 0.5rem;
            text-align: center;
            transition: all 0.4s ease;
            display: inline-block;
        }

        .glow-button:hover {
            background-color: #0C023E;
            box-shadow: 0 0 15px #0C023E, 0 0 25px #0C023E, 0 0 35px #0C023E;
            transform: translateY(-3px);
        }
    </style>
</head>
<body>
    <div class="index">
        <div class="form-container">
            <h2 class="text-2xl font-bold mb-6 text-center text-[#f8fdff]">Create an Account</h2>
            
            <form method="POST" class="space-y-4">
                <input 
                    type="text" 
                    name="name" 
                    placeholder="Full Name" 
                    required 
                    class="w-full px-4 py-2 border border-[#F8FDFF] rounded-lg bg-[#F8FDFF] text-[#1D1D1D] focus:outline-none focus:ring-2 focus:ring-[#2E4156]"
                >
                <input 
                    type="email" 
                    name="email" 
                    placeholder="Email Address" 
                    required 
                    class="w-full px-4 py-2 border border-[#F8FDFF] rounded-lg bg-[#F8FDFF] text-[#1D1D1D] focus:outline-none focus:ring-2 focus:ring-[#2E4156]"
                >
                <input 
                    type="password" 
                    name="password" 
                    placeholder="Password" 
                    required 
                    class="w-full px-4 py-2 border border-[#F8FDFF] rounded-lg bg-[#F8FDFF] text-[#1D1D1D] focus:outline-none focus:ring-2 focus:ring-[#2E4156]"
                >
                <select 
                    name="role" 
                    required 
                    class="w-full px-4 py-2 border border-[#F8FDFF] rounded-lg bg-[#F8FDFF] text-[#1D1D1D] focus:outline-none focus:ring-2 focus:ring-[#2E4156]"
                >
                    <option value="">Select Role</option>
                    <option value="Student">Student</option>
                    <option value="Teacher">Teacher</option>
                    <option value="Admin">Admin</option>
                </select>

                <button type="submit" class="glow-button">
                    Register
                </button>
            </form>

            <?php if (isset($error)): ?>
                <p class="text-red-500 text-sm mt-4 text-center"><?= htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <?php if (isset($success)): ?>
                <p class="text-green-400 text-sm mt-4 text-center"><?= htmlspecialchars($success); ?></p>
            <?php endif; ?>

            <div class="mt-6 text-center">
                <!-- Back to Home glowing button -->
                <a href="../index.php" class="glow-button">
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</body>
</html>

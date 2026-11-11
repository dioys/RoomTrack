<?php
require __DIR__ . '/../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname     = $_POST['fullname'];
    $email        = $_POST['email'];
    $address      = $_POST['address'];
    $phone_number = $_POST['phone_number'];
    

    $stmt = $conn->prepare("INSERT INTO visitors (fullname, email, address, phone_number) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fullname, $email, $address, $phone_number);

    if ($stmt->execute()) {
        header("Location: ../visitor/visitors_page.php");
        exit();
    } else {
        $error = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Visitor Registration</title>
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

        
        .form-container {
            background: rgba(5, 16, 148, 0.8);
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
            <h2 class="text-2xl font-bold mb-6 text-center text-[#f8fdff]">Visitor Registration</h2>

            <form method="POST" class="space-y-4">
                <input 
                    type="text" 
                    name="fullname" 
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
                    type="text" 
                    name="address" 
                    placeholder="Address" 
                    required 
                    class="w-full px-4 py-2 border border-[#F8FDFF] rounded-lg bg-[#F8FDFF] text-[#1D1D1D] focus:outline-none focus:ring-2 focus:ring-[#2E4156]"
                >
                <input 
                    type="number" 
                    name="phone_number" 
                    placeholder="Phone Number" 
                    required 
                    class="w-full px-4 py-2 border border-[#F8FDFF] rounded-lg bg-[#F8FDFF] text-[#1D1D1D] focus:outline-none focus:ring-2 focus:ring-[#2E4156]"
                >

                <button 
                    type="submit" 
                    class="glow-button"
                >
                    Register
                </button>
            </form>

            <?php if (isset($error)): ?>
                <p class="text-red-500 text-sm mt-4 text-center"><?= htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <div class="mt-6 text-center">
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

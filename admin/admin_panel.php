<?php
session_start(); // Start the session to ensure the user is logged in

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin') {
    header("Location: ../auth/register.php"); // Redirect to login page if not Admin
    exit();
}

require __DIR__ . '/../includes/db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('../assets/images/bg.png') no-repeat center center fixed;
            background-size: cover;
            color: #1d1d1d;
            padding: 60px 20px;
        }

        .admin-panel {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 15px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h2 {
            font-size: 36px;
            color: #2E4156;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            color: #333;
            margin-bottom: 30px;
        }

        .admin-panel button {
            background-color: #ffee00;
            color: black;
            border: none;
            padding: 12px 24px;
            margin: 10px 0;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            width: 100%;
            transition: 0.3s ease;
        }

        .admin-panel button:hover {
            background-color: #fbfb00;
            box-shadow: 0 0 10px #2C3E50;
        }

        .admin-panel a {
            display: inline-block;
            margin-top: 25px;
            font-size: 18px;
            color: black;
            background-color: #ffee00;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            transition: 0.3s;
        }

        .admin-panel a:hover {
            background-color: #fbfb00;
            box-shadow: 0 0 10px #888;
        }
    </style>
</head>
<body>

    <div class="admin-panel">
        <h2>Welcome to the Admin Panel</h2>
        

        <button onclick="window.location.href='dashboard.php'">Manage Users</button>
        <button onclick="window.location.href='vistitors_dash.php'">Manage Visitors</button>
        <button onclick="window.location.href='approve_bookings.php'">Approve Room Bookings</button>
        <button onclick="window.location.href='add_room.php'">Add Rooms</button>

        <a href="../index.php">Logout</a>
    </div>

</body>
</html>

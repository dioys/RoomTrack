<?php
include __DIR__ . '/../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_name = $_POST['room_name'];
    $type = $_POST['type'];
    $capacity = $_POST['capacity'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("INSERT INTO rooms (room_name, type, capacity, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $room_name, $type, $capacity, $status);

    if ($stmt->execute()) {
        echo "Room added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Room</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('../assets/images/bg.png') no-repeat center center fixed;
            background-size: cover;
            color: #1d1d1d;
        }
        h2 {
            text-align: center;
            color: #ffffff;
            font-size: 32px;
            margin-top: 60px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        label {
            font-size: 1rem;
            color: #1d1d1d;
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="number"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
            color: #2E4156;
        }
        button[type="submit"] {
            background-color: #ffee00;
            color: black;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            width: 100%;
        }
        button[type="submit"]:hover {
            background-color: #fbfb00;
            box-shadow: 0 0 5px #2C3E50;
        }
        a {
            text-decoration: none;
            color: #2E4156;
            display: inline-block;
            margin-top: 15px;
            font-size: 1rem;
        }
        a:hover {
            color: #1d1d1d;
        }
    </style>
</head>
<body>
    <h2>Add New Room</h2>
    <div class="container">
        <form method="post">
            <label>Room Name:</label>
            <input type="text" name="room_name" required><br>

            <label>Type:</label>
            <select name="type">
                <option value="Classroom">Classroom</option>
                <option value="Office">Office</option>
                <option value="Lab">Lab</option>
                <option value="Auditorium">Auditorium</option>
            </select><br>

            <label>Capacity:</label>
            <input type="number" name="capacity" required><br>

            <label>Status:</label>
            <select name="status">
                <option value="Vacant">Vacant</option>
                <option value="Occupied">Occupied</option>
            </select><br>

            <button type="submit">Add Room</button>
        </form>
        <a href="admin_panel.php">Back to Admin Panel</a>
    </div>
</body>
</html>

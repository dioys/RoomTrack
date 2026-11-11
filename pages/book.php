<?php
include __DIR__ . '/../includes/db_connection.php';
session_start();

// Simulate or retrieve user session
$user_id = $_SESSION['user_id'] ?? 1;

// Temporary user info for testing/demo purposes
$name = 'temp_user_' . $user_id;
$email = 'temp' . $user_id . '@example.com';
$password = password_hash('default_password', PASSWORD_DEFAULT);
$role = 'student';
$timee = date('Y-m-d H:i:s');

// Ensure user exists
$check_user = $conn->prepare("SELECT user_id FROM users WHERE user_id = ?");
$check_user->bind_param("i", $user_id);
$check_user->execute();
$result = $check_user->get_result();

if ($result->num_rows === 0) {
    $insert_user = $conn->prepare("INSERT INTO users (user_id, name, email, password, role, timee) VALUES (?, ?, ?, ?, ?, ?)");
    $insert_user->bind_param("isssss", $user_id, $name, $email, $password, $role, $timee);
    if (!$insert_user->execute()) {
        die("User insert error: " . $insert_user->error);
    }
}

// Handle booking
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_name = $_POST['room_name'];
    $date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $status = 1;

    $start_datetime = date('Y-m-d H:i:s', strtotime("$date $start_time"));
    $end_datetime = date('Y-m-d H:i:s', strtotime("$date $end_time"));

    // Get room_id based on room_name
    $stmt_room = $conn->prepare("SELECT room_id FROM rooms WHERE room_name = ?");
    $stmt_room->bind_param("s", $room_name);
    $stmt_room->execute();
    $result_room = $stmt_room->get_result();

    if ($result_room->num_rows === 0) {
        die("Invalid room selected.");
    }

    $room = $result_room->fetch_assoc();
    $room_id = $room['room_id'];

    // Insert into schedules
    $stmt1 = $conn->prepare("INSERT INTO schedules (room_id, start_time, end_time, date, reserved_by) VALUES (?, ?, ?, ?, ?)");
    $stmt1->bind_param("issss", $room_id, $start_datetime, $end_datetime, $date, $user_id);
    if (!$stmt1->execute()) {
        die("Schedule insert error: " . $stmt1->error);
    }

    $schedule_id = $stmt1->insert_id;

    // Insert into bookings
    $stmt2 = $conn->prepare("INSERT INTO bookings (user_id, room_id, schedule_id, status, start_time, end_time, date) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt2->bind_param("iiiisss", $user_id, $room_id, $schedule_id, $status, $start_datetime, $end_datetime, $date);
    if (!$stmt2->execute()) {
        die("Booking insert error: " . $stmt2->error);
    }

    // Update room status
    $update_room = $conn->prepare("UPDATE rooms SET status = 'Occupied' WHERE room_id = ?");
    $update_room->bind_param("i", $room_id);
    $update_room->execute();

    header("Location: rooms.php");
    exit;
}

// Fetch vacant room names for dropdown
$rooms_result = $conn->query("SELECT room_name FROM rooms WHERE status = 'Vacant'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book a Room</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('../assets/images/bg.png') no-repeat center center fixed;
            background-size: cover;
            color: #1d1d1d;
            padding: 60px 20px;
            text-align: center;
        }

        h2 {
            color: #fefdff;
            margin-bottom: 30px;
            font-size: 36px;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
            background-color: rgba(255,255,255,0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }

        label {
            display: block;
            margin-top: 15px;
            text-align: left;
            font-weight: bold;
        }

        input[type="date"],
        input[type="time"],
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        button[type="submit"] {
            margin-top: 25px;
            padding: 12px 24px;
            background-color: #ffee00;
            color: black;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #fbfb00;
            box-shadow: 0 0 10px #2C3E50;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #ffee00;
            color: black;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }

        .back-link:hover {
            background-color: #fbfb00;
            box-shadow: 0 0 10px #888;
        }
    </style>
</head>
<body>
    <h2>Book a Room</h2>
    <form method="POST">
        <label>Room Name:</label>
        <select name="room_name" required>
            <option value="">-- Select a Room --</option>
            <?php while ($room = $rooms_result->fetch_assoc()): ?>
                <option value="<?= htmlspecialchars($room['room_name']) ?>"><?= htmlspecialchars($room['room_name']) ?></option>
            <?php endwhile; ?>
        </select>

        <label>Date:</label>
        <input type="date" name="date" required>

        <label>Start Time:</label>
        <input type="time" name="start_time" required>

        <label>End Time:</label>
        <input type="time" name="end_time" required>

        <button type="submit">Book Now</button>
    </form>

    <a class="back-link" href="vacant_rooms.php">Back</a>
</body>
</html>

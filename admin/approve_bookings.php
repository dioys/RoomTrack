<?php
session_start();

// Only allow Admin users
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin') {
    header("Location: ../auth/register.php");
    exit();
}

require __DIR__ . '/../includes/db_connection.php';

// 1. Automatically update rooms to 'Vacant' if their approved booking's end_time has passed
$now = date('Y-m-d H:i:s');
$sql_expired = "SELECT room_id FROM bookings WHERE end_time < ? AND status = 'Approved'";
$stmt_expired = $conn->prepare($sql_expired);
$stmt_expired->bind_param("s", $now);
$stmt_expired->execute();
$result_expired = $stmt_expired->get_result();

while ($row = $result_expired->fetch_assoc()) {
    $room_id = $row['room_id'];
    $update_room = $conn->prepare("UPDATE rooms SET status = 'Vacant' WHERE room_id = ?");
    $update_room->bind_param("i", $room_id);
    $update_room->execute();
}

// 2. Handle approval or rejection
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['status'], $_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE bookings SET status = ? WHERE booking_id = ?");
    $stmt->bind_param("si", $status, $booking_id);

    if ($stmt->execute()) {
        if ($status === 'Approved') {
            $roomStmt = $conn->prepare("SELECT room_id FROM bookings WHERE booking_id = ?");
            $roomStmt->bind_param("i", $booking_id);
            $roomStmt->execute();
            $roomResult = $roomStmt->get_result();

            if ($roomRow = $roomResult->fetch_assoc()) {
                $room_id = $roomRow['room_id'];
                $checkStatus = $conn->prepare("SELECT status FROM rooms WHERE room_id = ?");
                $checkStatus->bind_param("i", $room_id);
                $checkStatus->execute();
                $statusResult = $checkStatus->get_result();

                if ($statusRow = $statusResult->fetch_assoc()) {
                    if ($statusRow['status'] !== 'Occupied') {
                        $updateRoom = $conn->prepare("UPDATE rooms SET status = 'Occupied' WHERE room_id = ?");
                        $updateRoom->bind_param("i", $room_id);
                        $updateRoom->execute();
                    }
                }
            }
        }

        header("Location: approve_bookings.php");
        exit();
    } else {
        echo "Error updating booking: " . $conn->error;
    }
}

// 3. Get all pending bookings along with room names
$sql = "SELECT b.booking_id, b.user_id, b.room_id, b.start_time, b.end_time, r.room_name
        FROM bookings b
        JOIN rooms r ON b.room_id = r.room_id
        WHERE b.status = 'Pending'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Approve Room Bookings</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('../assets/images/bg.png') no-repeat center center fixed;
            background-size: cover;
            padding: 60px 20px;
            color: #1d1d1d;
        }

        .admin-panel {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 15px;
            max-width: 900px;
            margin: 0 auto;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h2 {
            font-size: 32px;
            color: #2E4156;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 16px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
            background-color: white;
        }

        th {
            background-color: #ffee00;
        }

        tr:nth-child(even) td {
            background-color: #f9f9f9;
        }

        button {
            background-color: #ffee00;
            color: black;
            border: none;
            padding: 8px 16px;
            margin: 4px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }

        button:hover {
            background-color: #fbfb00;
            box-shadow: 0 0 5px #2C3E50;
        }

        .back-button {
            display: inline-block;
            margin-top: 30px;
            background-color: #ffee00;
            color: black;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
        }

        .back-button:hover {
            background-color: #fbfb00;
            box-shadow: 0 0 10px #888;
        }

        .actions form {
            display: inline;
        }
    </style>
</head>
<body>

    <div class="admin-panel">
        <h2>Pending Room Bookings</h2>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Booking ID</th>
                    <th>User ID</th>
                    <th>Room Name</th> <!-- Changed to Room Name -->
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Actions</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['booking_id']) ?></td>
                        <td><?= htmlspecialchars($row['user_id']) ?></td>
                        <td><?= htmlspecialchars($row['room_name']) ?></td> <!-- Display Room Name -->
                        <td><?= htmlspecialchars($row['start_time']) ?></td>
                        <td><?= htmlspecialchars($row['end_time']) ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="booking_id" value="<?= $row['booking_id'] ?>">
                                <button type="submit" name="status" value="Approved">Approve</button>
                            </form>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="booking_id" value="<?= $row['booking_id'] ?>">
                                <button type="submit" name="status" value="Rejected">Reject</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No pending bookings found.</p>
        <?php endif; ?>

        <a href="admin_panel.php" class="back-button">Back</a>
    </div>

</body>
</html>

<?php
include __DIR__ . '/../includes/db_connection.php';

$searchQuery = '';
if (isset($_POST['searchQuery'])) {
    $searchQuery = '%' . $_POST['searchQuery'] . '%';
}

$sql = "SELECT * FROM rooms WHERE status = 'Occupied'";

if (!empty($searchQuery)) {
    $sql .= " AND (room_name LIKE ? OR type LIKE ? OR capacity LIKE ?)";
}

$stmt = $conn->prepare($sql);

if (!empty($searchQuery)) {
    $stmt->bind_param("sss", $searchQuery, $searchQuery, $searchQuery);
}

$stmt->execute();
$occupiedRooms = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Occupied Rooms</title>
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
            margin-bottom: 20px;
            font-size: 40px;
        }

        table {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
            background-color: rgba(255, 255, 255, 0.8);
        }

        th {
            background: #ffee00;
            color: black;
        }

        tr:nth-child(even) td {
            background-color: rgba(249, 249, 249, 0.8);
        }

        .back-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #ffee00;
            color: black;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }

        .back-button:hover {
            background-color: #fbfb00;
            box-shadow: 0 0 10px #666;
        }

        .search-bar {
            margin: 20px auto;
        }

        .search-bar input {
            padding: 8px;
            width: 300px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        .search-bar button {
            padding: 8px 20px;
            margin-left: 10px;
            background-color: #ffee00;
            color: black;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            transition: 0.3s;
        }

        .search-bar button:hover {
            background-color: #fbfb00;
            box-shadow: 0 0 10px #1A252F;
        }
    </style>
</head>
<body>

    <h2>Occupied Rooms</h2>

    <div class="search-bar">
        <form method="POST" action="">
            <input type="text" name="searchQuery" placeholder="Search by room number, type, or capacity" value="<?= htmlspecialchars($_POST['searchQuery'] ?? '') ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <?php if (!empty($occupiedRooms)): ?>
        <table>
            <tr>
                <th>Room ID</th>
                <th>Room Number</th>
                <th>Type</th>
                <th>Capacity</th>
                <th>Status</th>
            </tr>
            <?php foreach ($occupiedRooms as $room): ?>
                <tr>
                    <td><?= $room['room_id'] ?></td>
                    <td><?= htmlspecialchars($room['room_name']) ?></td>
                    <td><?= htmlspecialchars($room['type']) ?></td>
                    <td><?= $room['capacity'] ?></td>
                    <td><?= $room['status'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No occupied rooms available at the moment.</p>
    <?php endif; ?>

    <a href="rooms.php" class="back-button">Back</a>

</body>
</html>

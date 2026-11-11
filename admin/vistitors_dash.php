<!DOCTYPE html>
<html lang="en">
<head>
    <title>Visitors Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('../assets/images/bg.png') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #ffffff;
            font-size: 2.5rem;
            margin-bottom: 20px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background-color: #F9F9F9;
            border-radius: 6px;
            overflow: hidden;
        }
        th, td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #CBD5E0;
            color: #2E4156;
        }
        th {
            background-color: #2E4156;
            color: #fff;
            font-size: 1rem;
        }
        tr:hover {
            background-color: #f0f0f0;
        }
        .back-button {
            text-align: center;
            margin-top: 25px;
        }
        .back-button a {
            background-color: #ffee00;
            color: #1a1a1a;
            padding: 10px 22px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
            transition: background-color 0.3s ease;
        }
        .back-button a:hover {
            background-color: #fcd700;
        }
        .action-buttons a {
            margin-right: 10px;
            font-weight: 600;
            text-decoration: none;
        }
        .action-buttons .text-blue-500 {
            color: #007BFF;
        }
        .action-buttons .text-blue-500:hover {
            text-decoration: underline;
        }
        .action-buttons .text-red-500 {
            color: #DC2626;
        }
        .action-buttons .text-red-500:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Manage Visitors</h2>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                    <th>Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                include __DIR__ . '/../includes/db_connection.php';

                $stmt = $conn->prepare("SELECT * FROM visitors");
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['visitor_id']); ?></td>
                            <td><?= htmlspecialchars($row['fullname']); ?></td>
                            <td><?= htmlspecialchars($row['email']); ?></td>
                            <td><?= htmlspecialchars($row['address']); ?></td>
                            <td><?= htmlspecialchars($row['phone_number']); ?></td>
                            <td><?= htmlspecialchars($row['timee']); ?></td>
                            <td class="action-buttons">
                                <a href="update_visitor.php?id=<?= $row['visitor_id']; ?>" class="text-blue-500">Update</a>
                                <a href="delete_visitor.php?id=<?= $row['visitor_id']; ?>" class="text-red-500" onclick="return confirm('Are you sure you want to delete this visitor?')">Delete</a>
                            </td>
                        </tr>
                    <?php }
                } else {
                    echo "<tr><td colspan='7' style='text-align: center; color: #555;'>No visitors found</td></tr>";
                }

                $stmt->close();
                ?>
            </tbody>
        </table>

        <div class="back-button">
            <a href="admin_panel.php"> Back</a>
        </div>
    </div>
</body>
</html>

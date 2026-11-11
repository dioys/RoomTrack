<!DOCTYPE html>
<html lang="en">
<head>
    <title>Users List</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: url('../assets/images/bg.png') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-start p-8 bg-opacity-90 backdrop-blur">

    <h2 class="text-4xl font-bold mb-6 text-[#ffffff] drop-shadow">Users Dashboard</h2>

    <div class="w-full max-w-6xl bg-white bg-opacity-90 backdrop-blur-md p-8 rounded-xl shadow-2xl">
        <table class="min-w-full rounded-lg overflow-hidden shadow">
            <thead class="bg-[#2E4156] text-white text-lg">
                <tr>
                    <th class="py-3 px-6 text-left">ID</th>
                    <th class="py-3 px-6 text-left">Name</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-left">Role</th>
                    <th class="py-3 px-6 text-left">Time</th>
                    <th class="py-3 px-6 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-gray-50">
                <?php 
                include __DIR__ . '/../includes/db_connection.php';
                $stmt = $conn->prepare("SELECT * FROM users");
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) { ?>
                        <tr class="border-b hover:bg-gray-200 transition duration-200">
                            <td class="py-2 px-6"><?= htmlspecialchars($row['user_id']); ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['name']); ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['email']); ?></td>
                            <td class="py-2 px-6 capitalize"><?= htmlspecialchars($row['role']); ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['timee']); ?></td>
                            <td class="py-2 px-6 flex gap-4">
                                <a href="update_user.php?id=<?= $row['user_id']; ?>" class="text-blue-600 font-medium hover:underline">Update</a>
                                <a href="delete_user.php?id=<?= $row['user_id']; ?>" class="text-red-600 font-medium hover:underline" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                            </td>
                        </tr>
                    <?php }
                } else {
                    echo "<tr><td colspan='6' class='py-4 px-6 text-center text-gray-500'>No users found</td></tr>";
                }

                $stmt->close();
                ?>
            </tbody>
        </table>

        <div class="mt-8 text-center">
            <a href="admin_panel.php" class="inline-block bg-[#ffee00] text-black px-6 py-2 rounded-md font-semibold shadow hover:bg-yellow-300 transition">Back</a>
        </div>
    </div>

</body>
</html>

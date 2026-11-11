<?php
include __DIR__ . '/../includes/db_connection.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Get user data from database
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        echo "User not found.";
        exit;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, role = ? WHERE user_id = ?");
    $stmt->bind_param("sssi", $name, $email, $role, $user_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php"); // Redirect to the users list page
        exit;
    } else {
        echo "Error updating user.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#D4D8DD] min-h-screen flex flex-col items-center p-8">

    <h2 class="text-3xl font-bold mb-6 text-[#1S2D42]">Update User</h2>

    <div class="w-full max-w-5xl bg-[#C0C8CA] p-8 rounded-lg shadow-lg">
        <form method="POST">
            <div class="mb-4">
                <label for="name" class="block text-[#2E4156]">Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($user['name']); ?>" required class="w-full p-2 mt-2 border border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-[#2E4156]">Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required class="w-full p-2 mt-2 border border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="role" class="block text-[#2E4156]">Role</label>
                <input type="text" name="role" value="<?= htmlspecialchars($user['role']); ?>" required class="w-full p-2 mt-2 border border-gray-300 rounded-md">
            </div>
            <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-md">Update User</button>
        </form>
    </div>

</body>
</html>

<?php
include __DIR__ . '/../includes/db_connection.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php"); // Redirect to the users list page
        exit;
    } else {
        echo "Error deleting user.";
    }

    $stmt->close();
}
?>

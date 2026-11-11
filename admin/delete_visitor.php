<?php
include __DIR__ . '/../includes/db_connection.php';

if (isset($_GET['id'])) {
    $visitor_id = $_GET['id'];

    // Prepare and execute delete query
    $stmt = $conn->prepare("DELETE FROM visitors WHERE visitor_id = ?");
    $stmt->bind_param("i", $visitor_id);

    if ($stmt->execute()) {
        header("Location: vistitors_dash.php"); 
        exit;
    } else {
        echo "Error deleting visitor.";
    }

    $stmt->close();
}
?>

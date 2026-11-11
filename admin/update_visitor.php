<?php
include __DIR__ . '/../includes/db_connection.php';

if (isset($_GET['id'])) {
    $visitor_id = $_GET['id'];

    // Get visitor data from database
    $stmt = $conn->prepare("SELECT * FROM visitors WHERE visitor_id = ?");
    $stmt->bind_param("i", $visitor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $visitor = $result->fetch_assoc();

    if (!$visitor) {
        echo "Visitor not found.";
        exit;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone_number = $_POST['phone_number'];

    $stmt = $conn->prepare("UPDATE visitors SET fullname = ?, email = ?, address = ?, phone_number = ? WHERE visitor_id = ?");
    $stmt->bind_param("ssssi", $fullname, $email, $address, $phone_number, $visitor_id);

    if ($stmt->execute()) {
        header("Location: vistitors_dash.php"); // Redirect to the visitors list page
        exit;
    } else {
        echo "Error updating visitor.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Visitor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #D4D8DD;
            color: #1S2D42;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 20px auto;
            background-color: #C0C8CA;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        input[type="text"], input[type="email"], input[type="tel"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #AAB7B7;
            border-radius: 4px;
        }
        .back-button {
            text-align: center;
            margin-top: 20px;
        }
        .back-button a {
            background-color: #1S2D42;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
        }
        .back-button a:hover {
            background-color: #2E4156;
        }
    </style>
</head>
<body>

    <h2>Update Visitor</h2>

    <div class="container">
        <form method="POST">
            <label for="fullname">Full Name</label>
            <input type="text" id="fullname" name="fullname" value="<?= htmlspecialchars($visitor['fullname']); ?>" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($visitor['email']); ?>" required>

            <label for="address">Address</label>
            <input type="text" id="address" name="address" value="<?= htmlspecialchars($visitor['address']); ?>" required>

            <label for="phone_number">Phone Number</label>
            <input type="tel" id="phone_number" name="phone_number" value="<?= htmlspecialchars($visitor['phone_number']); ?>" required>

            <button type="submit">Update Visitor</button>
        </form>
    </div>

</body>
</html>

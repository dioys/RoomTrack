<!DOCTYPE html>
<html>
<head>
    <title>Book Room</title>
</head>
<body>
    <h2>Book a Room</h2>
    <form method="POST" action="book.php">
        <label for="room_id">Room ID:</label>
        <input type="number" name="room_id" required><br><br>

        <label for="date">Date:</label>
        <input type="date" name="date" required><br><br>

        <label for="start_time">Start Time:</label>
        <input type="time" name="start_time" required><br><br>

        <label for="end_time">End Time:</label>
        <input type="time" name="end_time" required><br><br>

        <button type="submit">Book</button>
    </form>
</body>
</html>

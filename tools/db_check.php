<?php
// Quick check that the database connection works and lists its tables.
require __DIR__ . '/../includes/db_connection.php';

$result = $conn->query("SELECT DATABASE() AS db");
$row = $result->fetch_assoc();
echo "Connected to database: <b>" . htmlspecialchars($row['db']) . "</b><br><br>";

$result = $conn->query("SHOW TABLES");
echo "<h3>Tables:</h3>";
while ($row = $result->fetch_row()) {
    echo htmlspecialchars($row[0]) . "<br>";
}

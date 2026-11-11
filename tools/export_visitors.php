<?php
// Exports the visitors table to data.csv (next to this file).
// Open http://localhost/<project>/tools/export_visitors.php to run it.
require __DIR__ . '/../includes/db_connection.php';

$fp = fopen(__DIR__ . "/data.csv", "w");

$result = $conn->query("SELECT * FROM visitors");
$headers = [];
foreach ($result->fetch_fields() as $field) {
    $headers[] = $field->name;
}
fputcsv($fp, $headers);

while ($row = $result->fetch_assoc()) {
    fputcsv($fp, $row);
}

fclose($fp);
$conn->close();

echo "Exported successfully!";

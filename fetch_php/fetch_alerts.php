<?php
require_once '../php/db_connection.php';

// Validate and sanitize the 'type' parameter
$type = $_GET['type'] ?? 'current';
$type = ($type === 'current') ? 'current' : 'past'; // Ensure 'type' is either 'current' or 'past'

// Prepare SQL query using parameterized statements to prevent SQL injection
if ($type === 'current') {
    $sql = "SELECT a.alert_id AS id, a.alert_message AS description, s.location AS location, a.alert_time AS date
            FROM alerts a
            JOIN sensor_data d ON a.data_id = d.data_id
            JOIN sensor_station s ON d.station_id = s.station_id
            WHERE a.alert_time >= NOW() - INTERVAL 1 DAY 
            ORDER BY a.alert_time DESC";
} else {
    $sql = "SELECT a.alert_id AS id, a.alert_message AS description, s.location AS location, a.alert_time AS date
            FROM alerts a
            JOIN sensor_data d ON a.data_id = d.data_id
            JOIN sensor_station s ON d.station_id = s.station_id
            WHERE a.alert_time < NOW() - INTERVAL 1 DAY 
            ORDER BY a.alert_time DESC";
}

// Execute the query using prepared statements
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Database query preparation failed');
}

$stmt->execute();
$result = $stmt->get_result();

$alerts = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Sanitize output data if needed (e.g., htmlspecialchars)
        $row['description'] = htmlspecialchars($row['description']);
        $row['location'] = htmlspecialchars($row['location']);
        $alerts[] = $row;
    }
}

// Set proper Content-Type header and encode data as JSON
header('Content-Type: application/json');
echo json_encode($alerts);

$stmt->close();
$conn->close();
?>

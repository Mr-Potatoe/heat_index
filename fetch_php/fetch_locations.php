<?php
require_once '../php/db_connection.php';

// Query to fetch locations with latitude, longitude, temperature, humidity, latest heat index, and timestamp
$sql = "
    SELECT ss.station_id, ss.location, ss.latitude, ss.longitude, sd.heat_index, sd.temperature, sd.humidity, sd.timestamp
    FROM sensor_station ss
    JOIN (
        SELECT station_id, MAX(timestamp) AS latest_time
        FROM sensor_data
        GROUP BY station_id
    ) latest_data ON ss.station_id = latest_data.station_id
    JOIN sensor_data sd ON latest_data.station_id = sd.station_id AND latest_data.latest_time = sd.timestamp
    ORDER BY ss.location
";

$result = $conn->query($sql);

// Check if results were returned
if ($result->num_rows > 0) {
    $locations = array();
    while ($row = $result->fetch_assoc()) {
        $locations[] = $row;
    }
    // Output JSON encoded data
    header('Content-Type: application/json');
    echo json_encode($locations);
} else {
    echo json_encode([]);
}

$conn->close();
?>

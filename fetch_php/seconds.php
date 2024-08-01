<?php
// Set appropriate headers for SSE
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

require_once '../php/db_connection.php';
date_default_timezone_set('Asia/Manila');
$isStreaming = true;

// Function to fetch latest sensor data
function fetchLatestSensorData() {
    global $conn;

    // Prepare the SQL query to fetch latest data
    $sql = "SELECT ss.location, sd.timestamp, sd.temperature, sd.humidity, sd.heat_index
            FROM sensor_station ss
            JOIN sensor_data sd ON ss.station_id = sd.station_id
            WHERE sd.timestamp >= NOW() - INTERVAL 1 DAY
            ORDER BY ss.location, sd.timestamp DESC";

    $result = $conn->query($sql);

    if ($result === FALSE) {
        die(json_encode(['error' => 'Database query failed']));
    }

    $sensorData = [];
    while ($row = $result->fetch_assoc()) {
        $sensorData[] = [
            'location' => $row['location'],
            'timestamp' => $row['timestamp'],
            'temperature' => (float) $row['temperature'],
            'humidity' => (float) $row['humidity'],
            'heat_index' => (float) $row['heat_index'],
        ];
    }

    return $sensorData;
}

// Function to send SSE data
function sendSseData($data) {
    echo "data: " . json_encode($data) . "\n\n";
    ob_flush();
    flush();
}

// Set up SSE stream
while ($isStreaming) {
    // Fetch latest data
    $sensorData = fetchLatestSensorData();

    // Only send updates if there are new data
    if ($sensorData) {
        sendSseData($sensorData);
    }

    // Sleep for a short interval before checking again
    sleep(1); // Adjust interval as needed
}
?>

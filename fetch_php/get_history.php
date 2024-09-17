<?php
require_once '../php/db_connection.php';

// Function to fetch sensor data for all stations
function fetchAllSensorData($conn) {
    $sql = "
        SELECT ss.station_id, ss.location, sd.temperature, sd.humidity, sd.heat_index, sd.timestamp
        FROM sensor_station ss
        JOIN sensor_data sd ON ss.station_id = sd.station_id
        ORDER BY ss.station_id, sd.timestamp DESC
    ";

    $result = $conn->query($sql);

    $data = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $station_id = $row['station_id'];
            if (!isset($data[$station_id])) {
                $data[$station_id] = [
                    'location' => $row['location'],
                    'data' => []
                ];
            }
            $data[$station_id]['data'][] = [
                'temperature' => $row['temperature'],
                'humidity' => $row['humidity'],
                'heat_index' => $row['heat_index'],
                'timestamp' => $row['timestamp']
            ];
        }
    }

    $conn->close();

    return $data;
}

// Fetch all sensor data
$data = fetchAllSensorData($conn);

// Output JSON encoded data
header('Content-Type: application/json');
echo json_encode($data);
?>

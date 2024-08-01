<?php
require_once '../php/db_connection.php';

// Query to fetch the latest sensor data entries for each location
$query = "
    SELECT ss.location, sd.temperature, sd.humidity, sd.heat_index, sd.timestamp, ss.station_id
    FROM (
        SELECT *, ROW_NUMBER() OVER (PARTITION BY station_id ORDER BY timestamp DESC) AS row_num
        FROM sensor_data
    ) sd
    JOIN sensor_station ss ON sd.station_id = ss.station_id
    WHERE row_num <= 1
    ORDER BY ss.location ASC, sd.timestamp DESC
";

$data_result = $conn->query($query);
$rows = [];

if ($data_result->num_rows > 0) {
    while ($row = $data_result->fetch_assoc()) {
        $rows[] = $row;
    }
} else {
    echo json_encode([]);
    exit;
}

echo json_encode($rows);

$conn->close();
?>

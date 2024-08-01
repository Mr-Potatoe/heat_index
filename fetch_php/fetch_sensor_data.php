<?php
require_once '../php/db_connection.php' ;

try {
    // Prepare the SQL query to fetch locations with highest heat index for each hour in the past 24 hours
    $sql = "SELECT location, timestamp, temperature, humidity, heat_index
            FROM (
                SELECT ss.location, sd.timestamp, sd.temperature, sd.humidity, sd.heat_index,
                       ROW_NUMBER() OVER (PARTITION BY ss.location, DATE_FORMAT(sd.timestamp, '%Y-%m-%d %H') ORDER BY sd.heat_index DESC) as rn
                FROM sensor_station ss
                JOIN sensor_data sd ON ss.station_id = sd.station_id
                WHERE sd.timestamp >= NOW() - INTERVAL 1 DAY
            ) AS subquery
            WHERE rn = 1
            ORDER BY location, timestamp";

    // Execute the query
    $result = $conn->query($sql);

    // Check if results were returned
    if ($result === FALSE) {
        throw new Exception('Database query failed: ' . $conn->error);
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

    // Output the JSON encoded data
    echo json_encode($sensorData);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
} finally {
    // Close the database connection
    $conn->close();
}
?>

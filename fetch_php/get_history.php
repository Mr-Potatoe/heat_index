<?php
require_once '../php/db_connection.php';

// Function to fetch sensor data for a given station
function fetchSensorData($conn, $station_id) {
    $sql = "SELECT temperature, humidity, heat_index, timestamp 
            FROM sensor_data
            WHERE station_id = ?
            ORDER BY timestamp DESC"; 

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        return []; // Return an empty array or handle error as needed
    }

    $stmt->bind_param("i", $station_id);

    if (!$stmt->execute()) {
        return []; // Return an empty array or handle error as needed
    }

    $result = $stmt->get_result();

    $data = array();

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $stmt->close();

    return $data;
}

// Get station_id for BSIS Building and Farmers's Hall
$station_id_bsis = 1;
$station_id_farmers_hall = 2;

// Fetch data for BSIS Building (station_id = 1)
$data_bsis = fetchSensorData($conn, $station_id_bsis);

// Fetch data for Farmers's Hall (station_id = 2)
$data_farmers_hall = fetchSensorData($conn, $station_id_farmers_hall);

$conn->close();

// Combine data into a single array to send as JSON response
$response = [
    'bsis_building' => $data_bsis,
    'farmers_hall' => $data_farmers_hall
];

header('Content-Type: application/json');
echo json_encode($response);
?>

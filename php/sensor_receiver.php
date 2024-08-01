<?php
require_once 'db_connection.php';

// Set the default timezone to Philippine time
date_default_timezone_set('Asia/Manila');

// Function to generate alerts based on heat index
function generate_alert($station_id, $data_id, $heat_index) {
    global $conn;

    $alert_type = '';
    $alert_message = '';

    // Define thresholds for different heat index levels
    if ($heat_index >= 54) {
        $alert_type = 'Extreme Danger';
        $alert_message = 'Heat index exceeds 54°C. Extreme danger, heat stroke highly likely.';
    } elseif ($heat_index >= 41) {
        $alert_type = 'Danger';
        $alert_message = 'Heat index is between 41°C and 54°C. Danger, heat cramps and heat exhaustion are likely, heat stroke is possible.';
    } elseif ($heat_index >= 32) {
        $alert_type = 'Extreme Caution';
        $alert_message = 'Heat index is between 32°C and 41°C. Extreme caution, heat cramps and heat exhaustion are possible.';
    } elseif ($heat_index >= 27) {
        $alert_type = 'Caution';
        $alert_message = 'Heat index is between 27°C and 32°C. Caution, fatigue is possible with prolonged exposure and activity.';
    }

    // If an alert type is set, insert it into the alerts table
    if ($alert_type) {
        $stmt_alert = $conn->prepare("INSERT INTO alerts (station_id, data_id, alert_type, alert_message) VALUES (?, ?, ?, ?)");
        $stmt_alert->bind_param("iiss", $station_id, $data_id, $alert_type, $alert_message);

        if ($stmt_alert->execute()) {
            echo "Alert generated and stored successfully for station ID $station_id<br>";
        } else {
            echo "Error: " . $stmt_alert->error;
        }

        $stmt_alert->close();
    }
}

// Check if data is received via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the data from POST request
    $temperature = $_POST['temperature'];
    $humidity = $_POST['humidity'];
    $heat_index = $_POST['heat_index'];
    $station_id = $_POST['station_id']; // Adjust to get station_id dynamically from POST
    $timestamp = date("Y-m-d H:i:s");

    // Prepare SQL statement to insert sensor data including the heat index
    $stmt_sensor_data = $conn->prepare("INSERT INTO sensor_data (station_id, timestamp, temperature, humidity, heat_index) VALUES (?, ?, ?, ?, ?)");
    $stmt_sensor_data->bind_param("isddd", $station_id, $timestamp, $temperature, $humidity, $heat_index);

    if ($stmt_sensor_data->execute()) {
        $data_id = $conn->insert_id; // Get the last inserted ID
        // Generate alerts based on the heat index
        generate_alert($station_id, $data_id, $heat_index);

        echo "Heat index calculated and stored successfully for station ID $station_id<br>";
    } else {
        echo "Error: " . $stmt_sensor_data->error;
    }

    $stmt_sensor_data->close();
}

$conn->close();
?>

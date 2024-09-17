<?php
require_once 'db_connection.php';

// Set the default time zone to Asia/Manila
date_default_timezone_set('Asia/Manila');

// Function to generate random float numbers
function random_float($min, $max) {
    return ($min + lcg_value() * (abs($max - $min)));
}

// Function to calculate heat index using PAGASA formula
function calculate_heat_index($temperature, $humidity) {
    // Constants for PAGASA heat index formula
    $c1 = -0.000000002308120;
    $c2 = 0.000102172;
    $c3 = 0.0004022;
    $c4 = -0.000197482;
    $c5 = -0.000002535;
    $c6 = -0.0008371;
    $c7 = 0.000159048;
    $c8 = 0.0003441;
    $c9 = -0.000001211;

    // Convert temperature to Celsius if it's in Fahrenheit
    if ($temperature > 80) {
        $temperature = ($temperature - 32) / 1.8;
    }

    // Calculate heat index
    $heat_index = $c1 +
                  $c2 * $temperature +
                  $c3 * $humidity +
                  $c4 * $temperature * $humidity +
                  $c5 * pow($temperature, 2) +
                  $c6 * pow($humidity, 2) +
                  $c7 * pow($temperature, 2) * $humidity +
                  $c8 * $temperature * pow($humidity, 2) +
                  $c9 * pow($temperature, 2) * pow($humidity, 2);

    return round($heat_index, 2); // Round to 2 decimal places
}

// Simulate sensor data for each station
$stations = array(
    array('station_id' => 1, 'location' => 'BSIS Building', 'latitude' => 7.9469980, 'longitude' => 123.5875620),
    array('station_id' => 2, 'location' => 'Farmers\'s Hall', 'latitude' => 7.9471770, 'longitude' => 123.5879210)
);

foreach ($stations as $station) {
    $station_id = $station['station_id'];
    $location = $station['location'];
    $latitude = $station['latitude'];
    $longitude = $station['longitude'];

    // Generate random data
    $temperature = random_float(25.0, 40.0); // Generate random temperature between 25.0°C and 40.0°C
    $humidity = random_float(50.0, 80.0); // Generate random humidity between 50.0% and 80.0%

    // Calculate heat index
    $heat_index = calculate_heat_index($temperature, $humidity);

    // Prepare the data to send via POST
    $postData = http_build_query(array(
        'temperature' => $temperature,
        'humidity' => $humidity,
        'heat_index' => $heat_index,
        'station_id' => $station_id
    ));

    // Set the POST options
    $opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postData
        )
    );

    // Create a context stream with the options
    $context = stream_context_create($opts);

    // Send the POST request to sensor_receiver.php
    $response = @file_get_contents('http://localhost/heat_index/php/sensor_receiver.php', false, $context);

    // Check if request was successful
    if ($response !== false) {
        echo "Data sent successfully to sensor_receiver.php for station ID $station_id<br>";
    } else {
        $error = error_get_last();
        echo "Error sending data to sensor_receiver.php for station ID $station_id: " . $error['message'] . "<br>";
    }
}
?>

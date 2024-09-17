# Heat Index Monitoring System

## Summary

### 1. **Project Overview**
   - We are developing a Heat Index Monitoring System to track environmental conditions using various sensor stations.

### 2. **Updated Sensor Stations**
   - A new list of sensor stations has been defined with specific locations and coordinates.

### 3. **Data Simulation Script**
   - **Purpose**: Simulate sensor data and send it to the server.
   - **Script Details**:
     - **Temperature** and **Humidity** values are generated randomly.
     - **Heat Index** is calculated using the PAGASA formula.
     - Data is sent to `sensor_receiver.php` via POST requests.
     - The script runs in a loop, sending data to all stations every 60 seconds.

### 4. **PHP Script**
   - Updated script to include the new sensor stations and handle data simulation.

---

```php
<?php
require_once 'db_connection.php';
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

// Updated list of sensor stations
$stations = array(
    array('station_id' => 1, 'location' => 'BSIS Building', 'latitude' => 7.9469980, 'longitude' => 123.5875620),
    array('station_id' => 2, 'location' => 'Farmers\'s Hall', 'latitude' => 7.9471770, 'longitude' => 123.5879210),
    array('station_id' => 3, 'location' => 'First location near guardhouse', 'latitude' => 7.9473004, 'longitude' => 123.5876167),
    array('station_id' => 4, 'location' => 'Second location near main building right side', 'latitude' => 7.9480162, 'longitude' => 123.5881823),
    array('station_id' => 5, 'location' => '3rd location behind main hall', 'latitude' => 7.9476420, 'longitude' => 123.5881160),
    array('station_id' => 6, 'location' => '4th location near Akasya tree (left)', 'latitude' => 7.9482380, 'longitude' => 123.5885240),
    array('station_id' => 7, 'location' => '5th location near Akasya tree (right)', 'latitude' => 7.9481550, 'longitude' => 123.5886940),
    array('station_id' => 8, 'location' => '6th location front yard Oasis', 'latitude' => 7.9480310, 'longitude' => 123.5889620),
    array('station_id' => 9, 'location' => '7th location behind Crim building', 'latitude' => 7.9476180, 'longitude' => 123.5883540),
    array('station_id' => 10, 'location' => '8th location Agri place', 'latitude' => 7.9472520, 'longitude' => 123.5882730),
    array('station_id' => 11, 'location' => '9th location Agri place behind Farmers Hall', 'latitude' => 7.9469680, 'longitude' => 123.5881530),
    array('station_id' => 12, 'location' => '10th location near ROTC office', 'latitude' => 7.9462340, 'longitude' => 123.5871250),
    array('station_id' => 13, 'location' => '11th location Pundol basketball court', 'latitude' => 7.9456080, 'longitude' => 123.5876410),
    array('station_id' => 14, 'location' => '12th location near ROTC office', 'latitude' => 7.9461940, 'longitude' => 123.5869550)
);

while (true) {
    foreach ($stations as $station) {
        $station_id = $station['station_id'];
        $location = $station['location'];
        $latitude = $station['latitude'];
        $longitude = $station['longitude'];

        // Generate random data
        $temperature = random_float(30.0, 35.0); // Generate random temperature between 30.0°C and 35.0°C
        $humidity = random_float(40.0, 60.0); // Generate random humidity between 40.0% and 60.0%

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
    // Wait for 60 seconds before the next iteration
    sleep(60);
}
?>
```
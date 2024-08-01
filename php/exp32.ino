#include <WiFi.h>
#include <HTTPClient.h>
#include <DHT.h>

// Replace these with your WiFi network credentials
const char* ssid = "your_SSID";
const char* password = "your_PASSWORD";

// Replace this with your server URL
const char* serverUrl = "http://localhost/heat_w8_db/php/sensor_reciever.php";

// Define DHT sensor type and pin
#define DHTTYPE DHT22
#define DHTPIN  4 // GPIO pin where the DHT22 is connected

DHT dht(DHTPIN, DHTTYPE);

void setup() {
  Serial.begin(115200);
  dht.begin();

  // Connect to WiFi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.println("Connected to WiFi");
}

void loop() {
  // Read temperature and humidity from the DHT22 sensor
  float temperature = dht.readTemperature();
  float humidity = dht.readHumidity();

  // Check if any reads failed and exit early (to try again)
  if (isnan(temperature) || isnan(humidity)) {
    Serial.println("Failed to read from DHT sensor!");
    return;
  }

  // Calculate the heat index
  float heatIndex = computeHeatIndex(temperature, humidity, false); // false indicates Celsius

  // Print the read values to the Serial Monitor
  Serial.print("Temperature: ");
  Serial.print(temperature);
  Serial.print(" °C ");
  Serial.print("Humidity: ");
  Serial.print(humidity);
  Serial.print(" % ");
  Serial.print("Heat Index: ");
  Serial.print(heatIndex);
  Serial.println(" °C");

  // Send data to the server
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin(serverUrl);

    // Specify content-type header
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    // Prepare the data to be sent in the POST request
    String httpRequestData = "temperature=" + String(temperature)
                           + "&humidity=" + String(humidity)
                           + "&heat_index=" + String(heatIndex);

    // Send HTTP POST request
    int httpResponseCode = http.POST(httpRequestData);

    // Print the response to the Serial Monitor
    if (httpResponseCode > 0) {
      String response = http.getString();
      Serial.println(httpResponseCode);
      Serial.println(response);
    } else {
      Serial.print("Error on sending POST: ");
      Serial.println(httpResponseCode);
    }

    // Close the connection
    http.end();
  } else {
    Serial.println("WiFi Disconnected");
  }

  // Wait 10 minutes before sending the next data
  delay(600000);
}

// Function to compute the heat index
float computeHeatIndex(float temperature, float humidity, bool isFahrenheit) {
  if (!isFahrenheit) {
    temperature = temperature * 1.8 + 32; // Convert to Fahrenheit
  }

  float hi = 0.5 * (temperature + 61.0 + ((temperature - 68.0) * 1.2) + (humidity * 0.094));

  if (hi > 79) {
    hi = -42.379 +
          2.04901523 * temperature +
         10.14333127 * humidity +
         -0.22475541 * temperature * humidity +
         -0.00683783 * pow(temperature, 2) +
         -0.05481717 * pow(humidity, 2) +
          0.00122874 * pow(temperature, 2) * humidity +
          0.00085282 * temperature * pow(humidity, 2) +
         -0.00000199 * pow(temperature, 2) * pow(humidity, 2);

    if ((humidity < 13) && (temperature >= 80.0) && (temperature <= 112.0)) {
      hi -= ((13.0 - humidity) * 0.25) * sqrt((17.0 - abs(temperature - 95.0)) * 0.05882);
    } else if ((humidity > 85.0) && (temperature >= 80.0) && (temperature <= 87.0)) {
      hi += ((humidity - 85.0) * 0.1) * ((87.0 - temperature) * 0.2);
    }
  }

  return (isFahrenheit) ? hi : (hi - 32) * 0.55555;
}

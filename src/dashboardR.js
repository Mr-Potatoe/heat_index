
 
    const updateInterval = 300000; // Interval time in milliseconds

    function fetchLatestData() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '../fetch_php/fetch_locations.php', true);

        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    const data = JSON.parse(xhr.responseText);
                    if (Array.isArray(data)) {
                        data.forEach(sensorData => {
                            updateSensorData(sensorData.station_id, sensorData.humidity, sensorData.temperature, sensorData.heat_index, sensorData.timestamp);
                        });
                    } else {
                        console.error('Invalid data format received:', xhr.responseText);
                    }
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                }
            } else {
                console.error('Request failed. Status:', xhr.status, xhr.statusText);
            }
        };

        xhr.onerror = function() {
            console.error('Network error occurred');
        };

        xhr.send();
    }

    function updateSensorData(stationId, humidity, temperature, heatIndex, timestamp) {
        const elements = {
            humidity: document.getElementById(`current-humidity-${stationId}`),
            temperature: document.getElementById(`current-temperature-${stationId}`),
            heatIndex: document.getElementById(`heat-index-${stationId}`),
            timestamp: document.getElementById(`timestamp-${stationId}`)
        };

        if (elements.humidity) elements.humidity.textContent = humidity !== null ? `${humidity}%` : 'N/A';
        if (elements.temperature) elements.temperature.textContent = temperature !== null ? `${temperature}°C` : 'N/A';
        if (elements.heatIndex) elements.heatIndex.textContent = heatIndex !== null ? `${heatIndex}°C` : 'N/A';
        if (elements.timestamp) elements.timestamp.textContent = timestamp !== null ? `Last updated: ${timestamp}` : 'N/A';
    }

    // Fetch the latest data when the page loads and set an interval to fetch it periodically
    fetchLatestData();
    setInterval(fetchLatestData, updateInterval); // Fetch data every second
    
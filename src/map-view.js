document.addEventListener('DOMContentLoaded', () => {
    const mapSection = document.getElementById('map-view');

    const MapModule = (() => {
        let mapInitialized = false;
        let markerLayer;
        const updateInterval = 300000; // Update interval in milliseconds
        const markers = new Map(); // Use a Map to store marker instances by their coordinates or some unique ID

        function initializeMap() {
            if (!mapInitialized) {
                // Initialize the map only once
                const map = L.map('map', {
                    center: [7.947207, 123.587943],
                    zoom: 18,
                    maxZoom: 19,
                    zoomControl: true // Enable zoom control
                });

                // Add OpenStreetMap tiles
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors',
                    maxZoom: 19 // Set to desired zoom level
                }).addTo(map);

                L.control.scale().addTo(map); // Add scale control to the map

                markerLayer = L.layerGroup().addTo(map); // Layer group for markers

                // Custom legend control
                const legend = L.control({ position: 'topright' });

                legend.onAdd = function () {
                    const div = L.DomUtil.create('div', 'legend');
                    div.innerHTML = `
                        <div class="bg-white dark:bg-gray-800 p-4 rounded shadow-md">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Legend</h3>
                            <div class="flex items-center mb-2">
                                <span class="legend-circle mr-2 h-4 w-4 rounded-full bg-gray-500"></span>
                                <span class="font-semibold">Not Hazardous</span> (< 27°C)
                            </div>
                            <div class="flex items-center mb-2">
                                <span class="legend-circle mr-2 h-4 w-4 rounded-full bg-yellow-200"></span>
                                <span class="font-semibold">Caution</span> (27 - 32°C)
                            </div>
                            <div class="flex items-center mb-2">
                                <span class="legend-circle mr-2 h-4 w-4 rounded-full bg-yellow-500"></span>
                                <span class="font-semibold">Extreme Caution</span> (33 - 41°C)
                            </div>
                            <div class="flex items-center mb-2">
                                <span class="legend-circle mr-2 h-4 w-4 rounded-full bg-red-500"></span>
                                <span class="font-semibold">Danger</span> (42 - 51°C)
                            </div>
                            <div class="flex items-center">
                                <span class="legend-circle mr-2 h-4 w-4 rounded-full bg-red-700"></span>
                                <span class="font-semibold">Extreme Danger</span> (≥ 52°C)
                            </div>
                        </div>
                    `;
                    return div;
                };

                legend.addTo(map); // Add legend to the map

                mapInitialized = true;

                // Start updating markers with real-time data
                updateMarkers(); // Initial call
                setInterval(updateMarkers, updateInterval); // Regular updates
            }
        }

        function fetchMarkers(callback) {
            // Replace with your AJAX call to fetch marker data
            const xhr = new XMLHttpRequest();
            xhr.open('GET', '../fetch_php/fetch_locations.php', true);

            xhr.onload = function () {
                if (xhr.status === 200) {
                    try {
                        const locations = JSON.parse(xhr.responseText);
                        callback(null, locations);
                    } catch (error) {
                        callback('Error parsing JSON: ' + error);
                    }
                } else {
                    callback('Request failed. Status: ' + xhr.status);
                }
            };

            xhr.onerror = function () {
                callback('Network error occurred');
            };

            xhr.send();
        }

        function updateMarkers() {
            fetchMarkers((error, locations) => {
                if (error) {
                    console.error(error);
                    return;
                }

                locations.forEach(location => {
                    const { latitude, longitude, heat_index, location: locName, temperature, humidity, timestamp } = location;
                    const markerId = `${latitude}-${longitude}`;

                    // Determine marker color based on PAGASA heat index thresholds
                    let color;
                    if (heat_index < 27) {
                        color = 'gray'; // Safe
                    } else if (heat_index >= 27 && heat_index <= 32) {
                        color = 'yellow'; // Caution
                    } else if (heat_index > 32 && heat_index <= 41) {
                        color = 'orange'; // Extreme Caution
                    } else if (heat_index > 41 && heat_index <= 51) {
                        color = 'red'; // Danger
                    } else {
                        color = 'darkred'; // Extreme Danger
                    }

                    if (markers.has(markerId)) {
                        // Marker exists, update its popup content
                        const marker = markers.get(markerId);
                        const popupContent = createPopupContent(locName, heat_index, temperature, humidity, timestamp);
                        marker.setStyle({ color: color });
                        marker.getPopup().setContent(popupContent);

                    } else {
                        // Create new marker
                        const markerOptions = {
                            color: color,
                            radius: 8,
                            fillOpacity: 0.8
                        };

                        const marker = L.circleMarker([latitude, longitude], markerOptions);

                        // Create custom popup content
                        const popupContent = createPopupContent(locName, heat_index, temperature, humidity, timestamp);

                        // Bind popup to marker with custom content and options
                        marker.bindPopup(popupContent, {
                            closeButton: true, // Enable close button
                            autoClose: false, // Keep popup open until manually closed
                            closeOnClick: false // Keep popup open on map click
                        });

                        // Store marker instance in map with its unique identifier
                        markers.set(markerId, marker);

                        // Add marker to layer group
                        markerLayer.addLayer(marker);

                        // Show popup on hover and keep it open
                        marker.on('mouseover', function (e) {
                            this.openPopup();
                        });
                        marker.on('click', function (e) {
                            this.openPopup();
                        });
                    }
                });
            });
        }

        // Function to create custom popup content with improved UX/UI
        function createPopupContent(locName, heat_index, temperature, humidity, timestamp) {
            // Format the timestamp to a human-readable format
            const formattedTime = new Date(timestamp).toLocaleString();

            // Determine status and recommendation based on PAGASA heat index thresholds
            let status, statusColor, recommendation;
            if (heat_index < 27) {
                status = 'Not Hazardous';
                statusColor = 'bg-gray-500';
                recommendation = 'The heat index is low. It\'s a good time to engage in outdoor activities. However, always stay hydrated.';
            } else if (heat_index >= 27 && heat_index <= 32) {
                status = 'Caution';
                statusColor = 'bg-yellow-200';
                recommendation = 'It\'s getting warm. Stay hydrated and avoid strenuous activities during peak heat hours.';
            } else if (heat_index > 32 && heat_index <= 41) {
                status = 'Extreme Caution';
                statusColor = 'bg-yellow-500';
                recommendation = 'Extreme caution is advised. Limit outdoor activities, and take frequent breaks in cool areas.';
            } else if (heat_index > 41 && heat_index <= 51) {
                status = 'Danger';
                statusColor = 'bg-red-500';
                recommendation = 'Dangerous heat conditions. Minimize outdoor exposure and ensure you stay well-hydrated.';
            } else {
                status = 'Extreme Danger';
                statusColor = 'bg-red-700';
                recommendation = 'Extreme danger. Stay indoors and avoid any outdoor activities. Stay hydrated and cool.';
            }

            return `
                <div class="max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg p-4 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-300 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-3">
                        <h2 class="text-lg sm:text-xl font-bold text-gray-800 dark:text-gray-100">${locName}</h2>
                        <div class="flex items-center mt-2 sm:mt-0">
                            <div class="status-indicator ${statusColor} text-xs text-white font-semibold px-2 py-1 rounded-full">
                                ${status}
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center mb-2">
                            <i class="fas fa-temperature-high text-red-600 mr-2"></i>
                            <div class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                <span>Heat Index:</span>
                                <span class="ml-2 text-lg font-semibold text-red-600">${heat_index}°C</span>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center mb-2">
                            <i class="fas fa-thermometer-half text-blue-600 mr-2"></i>
                            <div class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                <span>Temperature:</span>
                                <span class="ml-2 text-lg font-semibold text-blue-600">${temperature}°C</span>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center mb-2">
                            <i class="fas fa-tint text-teal-600 mr-2"></i>
                            <div class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                <span>Humidity:</span>
                                <span class="ml-2 text-lg font-semibold text-teal-600">${humidity}%</span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Last updated: ${formattedTime}</span>
                    </div>
                    <div class="mt-4 border-t border-gray-300 dark:border-gray-700 pt-2">
                        <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-100 mb-1">Recommendations:</h3>
                        <p class="text-sm text-gray-700 dark:text-gray-300">${recommendation}</p>
                    </div>
                </div>
            `;
        }

        return {
            initialize: initializeMap
        };
    })();

    // Initialize the map when the map section is clicked or becomes visible
    mapSection.addEventListener('click', MapModule.initialize);

    // Optionally use an IntersectionObserver to detect visibility
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                MapModule.initialize();
                observer.unobserve(entry.target);
            }
        });
    });

    observer.observe(mapSection);
});

<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: ../index.php');
    exit();
}
require_once 'db_connection.php';
?>
<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Explore real-time heat index data for our school campus with an interactive map. Monitor temperature and humidity levels across different buildings for a safer and more comfortable environment.">
    <title>Heat Index Map</title>
    <link rel="preconnect" href="https://ka-f.fontawesome.com" crossorigin="anonymous">
    <link rel="preload" href="../public/assets/school-logo.png" as="image" type="image/png">
    <link rel="stylesheet" href="../dist/css/stylesx.css">
    <link rel="stylesheet" href="../dist/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.1/tailwind.min.css" integrity="sha512-biy/TXdue7ElI4oop0vK1o0JVMwDtG2AeA1VEqJU3Z6LqZMMi6KTbc2ND1MC557MijurEJSPDVHV3WgwBgF1Pw==" crossorigin="anonymous" referrerpolicy="no-referrer" />   
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" as="style">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" crossorigin="anonymous">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="icon" href="../public/assets/school-logo.png" type="image/png">
    
</head>
<style>
     body {
      font-family: system-ui, sans-serif;
      color: #111;
    }
     .text-2xl { font-size: 1.5rem; }
    .font-bold { font-weight: 700; }
    .text-gray-900 { color: #1a202c; }
    .dark .text-white { color: #fff; }
    .mb-2 { margin-bottom: 0.5rem; }
    .sm\:mb-0 { margin-bottom: 0; }

    .carousel-item img {
            width: 100%;
            height: auto;
        }
</style>
<body>
<!-- header section -->
<header class="bg-gray-900 border-b-4 shadow-md flex justify-between items-center p-4 text-white" style="border-color: #4f46e5;">
  <div class="flex items-center">
    <img src="../public/assets/school-logo.png" alt="School Logo" loading="lazy" class="w-12 h-12 mr-4" width="48" height="48">
    <h1 class="text-2xl sm:text-lg font-bold text-gray-100 dark:text-white mb-2 mr-8 sm:mb-0">
      ZDSPGC Heat Index Map
    </h1>
  </div>
  <div class="flex items-center space-x-4">
    <button id="menu-toggle" class="sm:hidden flex items-center px-3 py-2 border rounded text-gray-200 border-gray-400 hover:text-white hover:border-white focus:outline-none">
      <i class="fas fa-bars"></i>
    </button>
    <nav id="menu" class="hidden sm:flex space-x-4">
      <a href="#dashboard" onclick="showSection('dashboard')" class="nav-link hover:bg-indigo-600 dark:hover:bg-indigo-500 px-3 py-2 rounded-md text-sm font-medium transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110" aria-label="Dashboard">Dashboard</a>
      <a href="#map-view" onclick="showSection('map-view')" class="nav-link hover:bg-indigo-600 dark:hover:bg-indigo-500 px-3 py-2 rounded-md text-sm font-medium transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110" aria-label="Map View">Map View</a>
      <a href="#sensors" onclick="showSection('sensors')" class="nav-link hover:bg-indigo-600 dark:hover:bg-indigo-500 px-3 py-2 rounded-md text-sm font-medium transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110" aria-label="Sensors">Sensors</a>
      <a href="#alerts" onclick="showSection('alerts')" class="nav-link hover:bg-indigo-600 dark:hover:bg-indigo-500 px-3 py-2 rounded-md text-sm font-medium transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110" aria-label="Alerts">Alerts</a>
      <a href="#history" onclick="showSection('history')" class="nav-link hover:bg-indigo-600 dark:hover:bg-indigo-500 px-3 py-2 rounded-md text-sm font-medium transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110" aria-label="History">History</a>
    </nav>
    <button id="dark-mode-toggle" class="p-2 px-4 rounded focus:outline-none transition-transform transform hover:scale-105" title="Toggle Dark Mode">
      <i id="dark-mode-icon" class="fas fa-moon text-gray-100 dark:text-gray-200"></i>
    </button>
    <button id="logoutButton" class="bg-red-500 text-white hover:bg-red-700 px-4 py-2 rounded flex items-center justify-center space-x-2 transition-transform transform hover:scale-105" title="Logout">
      <i class="fas fa-power-off text-lg"></i>
    </button>
  </div>
  <!-- Modal dialog for logout confirmation -->
  <div id="logoutModal" class="hidden fixed z-20 inset-0 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 transition-opacity" aria-hidden="true">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
      </div>
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
      <div class="inline-block align-bottom bg-gray-100 dark:bg-gray-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
        <div class="bg-gray-100 dark:bg-gray-900 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-700 sm:mx-0 sm:h-10 sm:w-10">
              <i class="fas fa-times text-red-600"></i>
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
              <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-300">Logout Confirmation</h3>
              <div class="mt-2">
                <p class="text-sm text-gray-500 dark:text-gray-300">Are you sure you want to logout?</p>
              </div>
            </div>
          </div>
        </div>
        <div class="bg-gray-100 dark:bg-gray-900 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button id="confirmLogout" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-500 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">Logout</button>
          <button id="cancelLogout" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancel</button>
        </div>
      </div>
    </div>
  </div>
  <!-- logout modal script -->
  <script>
    const logoutButton = document.getElementById('logoutButton');
    const logoutModal = document.getElementById('logoutModal');
    const confirmLogout = document.getElementById('confirmLogout');
    const cancelLogout = document.getElementById('cancelLogout');

    logoutButton.addEventListener('click', function() {
      logoutModal.classList.remove('hidden');
    });

    cancelLogout.addEventListener('click', function() {
      logoutModal.classList.add('hidden');
    });

    confirmLogout.addEventListener('click', function() {
      window.location.href = 'logout.php';
    });
  </script>
</header>
<!-- Sidebar -->
<div id="sidebar" class="fixed inset-0 bg-gray-800 bg-opacity-90 z-50 transform -translate-x-full transition-transform duration-300 ease-in-out sm:hidden">
  <div class="flex justify-between items-center p-4 border-b border-gray-700">
    <div class="text-lg font-bold text-white">ZDSPGC Heat Index Map</div>
    <button id="sidebar-close" class="text-white focus:outline-none" aria-label="Close Sidebar">
      <i class="fas fa-times h-6 w-6"></i> <!-- Font Awesome close icon -->
    </button>
  </div>
  <nav class="mt-8">
    <a href="#dashboard" onclick="showSection('dashboard'); closeSidebar();" class="block text-white px-4 py-2 hover:bg-gray-700 focus:outline-none focus:bg-gray-600 transition duration-200 ease-in-out">Dashboard</a>
    <a href="#map-view" onclick="showSection('map-view'); closeSidebar();" class="block text-white px-4 py-2 hover:bg-gray-700 focus:outline-none focus:bg-gray-600 transition duration-200 ease-in-out">Map View</a>
    <a href="#sensors" onclick="showSection('sensors'); closeSidebar();" class="block text-white px-4 py-2 hover:bg-gray-700 focus:outline-none focus:bg-gray-600 transition duration-200 ease-in-out">Sensors</a>
    <a href="#alerts" onclick="showSection('alerts'); closeSidebar();" class="block text-white px-4 py-2 hover:bg-gray-700 focus:outline-none focus:bg-gray-600 transition duration-200 ease-in-out">Alerts</a>
    <a href="#history" onclick="showSection('history'); closeSidebar();" class="block text-white px-4 py-2 hover:bg-gray-700 focus:outline-none focus:bg-gray-600 transition duration-200 ease-in-out">History</a>
    <!-- <a href="#settings" onclick="showSection('settings'); closeSidebar();" class="block text-white px-4 py-2 hover:bg-gray-700 focus:outline-none focus:bg-gray-600 transition duration-200 ease-in-out">Settings</a> -->
  </nav>
</div>
<!-- div for main content -->
<div class="flex flex-col  min-h-screen bg-white dark:bg-gray-900 text-black dark:text-white transition duration-300"> 
<!-- main content -->
<main class="flex-1  p-6 transition duration-300 ">
<!-- dashboard section -->
<section id="dashboard" class="p-6 bg-gray-100 dark:bg-gray-800 transition duration-300 rounded-lg shadow-md mb-6" data-aos="fade-up">
    <div class="content-header mb-4 flex justify-between items-center">
        <h1 class="text-lg font-bold text-gray-900 dark:text-white mb-2 sm:mb-0">Overview of Current Conditions</h1>
        <div class="relative">
            <!-- Quick Actions Dropdown -->
            <button id="quick-actions-btn" aria-haspopup="true" aria-expanded="false" class="bg-blue-700 hover:bg-blue-800 text-white py-2 px-4 rounded flex items-center transition duration-300 focus:outline-none">
                Quick Actions
                <i class="fas fa-caret-down ml-2"></i>
            </button>
            <!-- Dropdown menu -->
            <div id="quick-actions-dropdown" class="quick-actions-dropdown bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded shadow-md p-4 hidden absolute right-0 mt-2 z-50 w-48">
                <ul>
                    <li>
                        <a href="#alerts" onclick="showSection('alerts')" class="quick-action-item flex items-center py-2 px-4 text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded transition duration-200">
                            <i class="fas fa-bell mr-2 text-gray-700 dark:text-gray-300"></i>
                            View Alerts
                        </a>
                    </li>
                    <li>
                        <a href="#sensors" onclick="showSection('sensors')" class="quick-action-item flex items-center py-2 px-4 text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded transition duration-200">
                            <i class="fas fa-microchip mr-2 text-gray-700 dark:text-gray-300"></i>
                            View Sensors
                        </a>
                    </li>
                    <li>
                        <a href="#history" onclick="showSection('history')" class="quick-action-item flex items-center py-2 px-4 text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded transition duration-200">
                            <i class="fas fa-history mr-2 text-gray-700 dark:text-gray-300"></i>
                            View History
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
        <i class="fas fa-info-circle mr-2 text-blue-500 dark:text-blue-300" title="Note"></i>
        Data updates every 5 minutes for better performance.
    </p>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- BSIS Building Conditions -->
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 relative">
            <!-- Current Data -->
            <div class="absolute top-0 right-0 bg-white dark:bg-gray-900 z-10 rounded-lg p-2 shadow-lg max-w-xs sm:max-w-md text-xs sm:text-sm">
                <button id="accordion-button" class="flex items-center justify-between w-full text-left p-2 dark:bg-gray-800 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-700 focus:outline-none transition duration-200" style="background-color: #4f46e5;">
                    <span class="text-sm font-bold text-gray-100 dark:text-gray-200 mr-1">Current Data</span>
                    <i id="accordion-icon" class="fas fa-chevron-up text-gray-100 dark:text-gray-200"></i>
                </button>
                <div id="accordion-content" class="mt-2">
                    <div class="flex flex-col sm:flex-row items-center gap-2">
                        <!-- Humidity -->
                        <div class="flex flex-col items-center">
                            <i class="fas fa-tint text-sm" style="color: #17A2B8;"></i>
                            <p class="text-xs text-gray-700 dark:text-gray-300">Humidity</p>
                            <p id="current-humidity-1" class="text-sm font-semibold text-gray-900 dark:text-gray-100">Loading...</p>
                        </div>
                        <!-- Temperature -->
                        <div class="flex flex-col items-center">
                            <i class="fas fa-thermometer-half text-sm text-blue-700"></i>
                            <p class="text-xs text-gray-700 dark:text-gray-300">Temperature</p>
                            <p id="current-temperature-1" class="text-sm font-semibold text-gray-900 dark:text-gray-100">Loading...</p>
                        </div>
                        <!-- Heat Index -->
                        <div class="flex flex-col items-center">
                            <i class="fas fa-temperature-high text-sm text-red-700"></i>
                            <p class="text-xs text-gray-700 dark:text-gray-300">Heat Index</p>
                            <p id="heat-index-1" class="text-sm font-semibold text-gray-900 dark:text-gray-100">Loading...</p>
                        </div>
                    </div>
                    <p id="timestamp-1" class="text-xs text-gray-600 dark:text-gray-400 mt-2">Last updated: Loading...</p>
                </div>
            </div>
           <!-- Chart for BSIS Building -->
           <div class="p-4 relative">
                <!-- Loader -->
                <div id="chart-loader-1" class="chart-loader absolute inset-0 flex items-center justify-center bg-white dark:bg-gray-900 z-20">
                    <div class="loader"></div>
                </div>
                <div id="conditionsChart" class="h-96 text-gray-800 dark:text-gray-200"></div>
            </div>
            <div class="bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg p-4 text-gray-800 dark:text-gray-200 mb-4 mx-4 flex items-start space-x-2">
    <i class="fas fa-info-circle text-yellow-500 dark:text-yellow-400 mr-2 text-lg"></i>
    <div>
        <span class="font-semibold text-gray-900 dark:text-gray-100">Note:</span>
        <p class="mt-1 text-sm">This chart displays the highest heat index recorded each hour over the past 24 hours.</p>
    </div>
</div>
        </div>
        <!-- Farmers Hall Conditions -->
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 relative">
            <!-- Current Data -->
            <div class="absolute top-0 right-0 bg-white dark:bg-gray-900 z-10 rounded-lg p-2 shadow-lg max-w-xs sm:max-w-md text-xs sm:text-sm">
                <button id="accordion-button-2" class="flex items-center justify-between w-full text-left p-2  dark:bg-gray-800 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-700 focus:outline-none transition duration-200" style="background-color: #4f46e5;">
                    <span class="text-sm font-bold text-gray-100 dark:text-gray-200 mr-1">Current Data</span>
                    <i id="accordion-icon-2" class="fas fa-chevron-up text-gray-100 dark:text-gray-200"></i>
                </button>
                <div id="accordion-content-2" class="mt-2">
                    <div class="flex flex-col sm:flex-row items-center gap-2">
                        <!-- Humidity -->
                        <div class="flex flex-col items-center">
                            <i class="fas fa-tint text-sm" style="color: #17A2B8;"></i>
                            <p class="text-xs text-gray-700 dark:text-gray-300">Humidity</p>
                            <p id="current-humidity-2" class="text-sm font-semibold text-gray-900 dark:text-gray-100">Loading...</p>
                        </div>
                        <!-- Temperature -->
                        <div class="flex flex-col items-center">
                            <i class="fas fa-thermometer-half text-sm text-blue-700"></i>
                            <p class="text-xs text-gray-700 dark:text-gray-300">Temperature</p>
                            <p id="current-temperature-2" class="text-sm font-semibold text-gray-900 dark:text-gray-100">Loading...</p>
                        </div>
                        <!-- Heat Index -->
                        <div class="flex flex-col items-center">
                            <i class="fas fa-temperature-high text-sm text-red-700"></i>
                            <p class="text-xs text-gray-700 dark:text-gray-300">Heat Index</p>
                            <p id="heat-index-2" class="text-sm font-semibold text-gray-900 dark:text-gray-100">Loading...</p>
                        </div>
                    </div>
                    <p id="timestamp-2" class="text-xs text-gray-600 dark:text-gray-400 mt-2">Last updated: Loading...</p>
                </div>
            </div>
            <!-- Chart for Farmers Hall -->
            <div class="p-4 relative">
                <!-- Loader -->
                <div id="chart-loader-2" class="chart-loader absolute inset-0 flex items-center justify-center bg-white dark:bg-gray-900 z-20">
                    <div class="loader"></div>
                </div>
                <div id="conditionsChart2" class="h-96 text-gray-800 dark:text-gray-200"></div>
            </div>
            <div class="bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg p-4 text-gray-800 dark:text-gray-200 mb-4 mx-4 flex items-start space-x-2">
    <i class="fas fa-info-circle text-yellow-500 dark:text-yellow-400 mr-2 text-lg"></i>
    <div>
        <span class="font-semibold text-gray-900 dark:text-gray-100">Note:</span>
        <p class="mt-1 text-sm">This chart displays the highest heat index recorded each hour over the past 24 hours.</p>
    </div>
</div>

        </div>
    </div>
</section>
<!-- Map View Section -->
<section id="map-view" class="p-6 z-10 bg-gray-100 dark:bg-gray-800 transition duration-300 rounded-lg shadow-md mb-6 relative">
    <h1 class="text-2xl p-2 font-bold text-gray-800 dark:text-white">
        <i class="fas fa-map mr-2"></i>Map View
    </h1>
    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
        <i class="fas fa-info-circle mr-2 text-blue-500 dark:text-blue-300" title="Note"></i>
        Data updates every 5 minutes for better performance.
    </p>
    <div id="map" class="w-full h-96 min-h-full md:h-72 lg:h-96 bg-gray-300 dark:bg-gray-700 rounded-lg shadow-inner"></div>
    <!-- Disclaimer -->
    <div class="mt-4 p-3 bg-gray-100 dark:bg-gray-900 shadow-lg rounded-lg">
        <div class="flex items-center mb-2">
            <i class="fas fa-exclamation-circle text-red-500 dark:text-red-300 mr-2 text-lg"></i>
            <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-100">Disclaimer</h4>
        </div>
        <p class="text-xs text-gray-800 dark:text-gray-200">
            The information provided on this page is for general informational purposes only. While we strive to ensure the accuracy and timeliness of the data, we make no warranties or guarantees about its completeness, reliability, or suitability for any purpose. The data is subject to change without notice. For official and more detailed information, please refer to relevant authorities.
        </p>
    </div>
</section>
<!-- Sensors Section -->
<section id="sensors" class="p-6 bg-gray-100 dark:bg-gray-800 transition duration-300 rounded-lg shadow-md mb-6">
    <div class="overflow-x-auto">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">
            <i class="fas fa-microchip mr-2"></i>Sensor Status
        </h2>
        <!-- Note about data update interval -->
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
        <i class="fas fa-info-circle mr-2 text-blue-500 dark:text-blue-300" title="Note"></i>
          Sensor data updates every 5 minutes for better performance.
        </p>
        <table class="min-w-full bg-white dark:bg-gray-700 rounded-lg overflow-hidden">
            <thead class="bg-gray-300 dark:bg-gray-900 text-gray-500 dark:text-gray-200 uppercase">
                <tr>
                    <th class="px-4 py-2 text-center">Location</th>
                    <th class="px-4 py-2 text-center">Status</th>
                    <th class="px-4 py-2 text-center">Description</th>
                    <th class="px-4 py-2 text-center">Sensor ID</th>
                    <th class="px-4 py-2 text-center">Temperature (°C)</th>
                    <th class="px-4 py-2 text-center">Humidity (%)</th>
                    <th class="px-4 py-2 text-center">Heat Index (°C)</th>
                    <th class="px-4 py-2 text-center">Date</th>
                </tr>
            </thead>
            <tbody id="sensor-data-tbody" class="divide-y divide-gray-300 dark:divide-gray-800">
                <!-- Data will be dynamically inserted here -->
            </tbody>
        </table>
    </div>
    <script>
        // Function to fetch and update sensor data
        function fetchAndUpdateSensorData() {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', '../fetch_php/fetch_sensors_updates.php', true);

            xhr.onload = function () {
                if (xhr.status === 200) {
                    const data = JSON.parse(xhr.responseText);
                    const tbody = document.getElementById('sensor-data-tbody');
                    tbody.innerHTML = ''; // Clear any existing rows

                    if (data.length > 0) {
                        data.forEach(row => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td class='px-6 py-4 text-center dark:text-gray-200 whitespace-nowrap'>${row.location}</td>
                                <td class='px-6 py-4 text-center dark:text-gray-200 whitespace-nowrap'>Active</td>
                                <td class='px-6 py-4 text-center dark:text-gray-200 whitespace-nowrap'>High Heat Index</td>
                                <td class='px-6 py-4 text-center dark:text-gray-200 whitespace-nowrap'>${row.station_id}</td>
                                <td class='px-6 py-4 text-center dark:text-gray-200 whitespace-nowrap'>${row.temperature}</td>
                                <td class='px-6 py-4 text-center dark:text-gray-200 whitespace-nowrap'>${row.humidity}</td>
                                <td class='px-6 py-4 text-center dark:text-gray-200 whitespace-nowrap'>${row.heat_index}</td>
                                <td class='px-6 py-4 text-center dark:text-gray-200 whitespace-nowrap'>${row.timestamp}</td>
                            `;
                            tbody.appendChild(tr);
                        });
                    } else {
                        const tr = document.createElement('tr');
                        tr.innerHTML = "<td colspan='8' class='px-6 py-4 whitespace-nowrap text-center text-gray-500 dark:text-gray-200'>No data available</td>";
                        tbody.appendChild(tr);
                    }
                } else {
                    console.error('Failed to fetch data. Status:', xhr.status);
                }
            };

            xhr.onerror = function () {
                console.error('Network error occurred.');
            };

            xhr.send();
        }

        // Fetch data initially on page load
        document.addEventListener('DOMContentLoaded', function () {
            fetchAndUpdateSensorData();
        });

        // Update data every 5 minutes (300000 milliseconds)
        setInterval(fetchAndUpdateSensorData, 300000); // 300000 milliseconds = 5 minutes
    </script>
</section>
<!-- alerts section -->
<section id="alerts" class="p-6 bg-gray-100 dark:bg-gray-800 transition duration-300 rounded-lg shadow-lg mb-6">
    <!-- Content Header with Title and Toggle Buttons -->
    <div class="content-header mb-4 flex justify-between items-center bg-gray-200 dark:bg-gray-900 p-4 rounded-t-lg">
        <div class="flex items-center">
            <i class="fas fa-bell text-gray-800 dark:text-white mr-2 text-xl font-bold"></i>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Alerts</h1>
        </div>
        <div class="flex items-center">
            <button id="show-current-alerts" data-type="current" class="alert-toggle-button bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded transition-transform transform hover:scale-105 mr-2 active">Current Alerts</button>
            <button id="show-alert-history" data-type="history" class="alert-toggle-button bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded transition-transform transform hover:scale-105">Alert History</button>
        </div>
    </div>
   <!-- Note about data update interval -->
   <p class="text-sm text-gray-700 dark:text-gray-300 mb-4 flex items-center">
        <i class="fas fa-info-circle mr-2 text-blue-500 dark:text-blue-300" title="Note"></i>
        <span>Alert data updates every 5 minutes for better performance.</span>
    </p>
    <!-- Current Alerts Section -->
    <div id="current-alerts-section" class="alert-section shadow-lg rounded-lg p-4">
        <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-2">Current Alerts</h2>
        <div class="table-container overflow-x-auto">
            <table class="min-w-full bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden shadow-sm divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-300 dark:bg-gray-900">
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-200 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-200 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-200 uppercase tracking-wider">Location</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-200 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody id="current-alerts-table">
                    <!-- Rows will be dynamically added based on the current page -->
                </tbody>
            </table>
        </div>
        <!-- Pagination Buttons for Current Alerts -->
        <div class="flex justify-end mt-4 ">
            <button id="prevPageCurrent" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded transition-transform transform hover:scale-105 mr-2" disabled>Prev</button>
            <button id="nextPageCurrent" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded transition-transform transform hover:scale-105">Next</button>
        </div>
    </div>
    <!-- Alert History Section (Initially Hidden) -->
    <div id="alert-history-section" class="hidden alert-section">
        <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-2">Alert History</h2>
        <div class="table-container overflow-x-auto">
            <table class="min-w-full bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden shadow-sm divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-300 dark:bg-gray-900">
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-200 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-200 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-200 uppercase tracking-wider">Location</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-200 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody id="alert-history-table">
                    <!-- Rows will be dynamically added based on the current page -->
                </tbody>
            </table>
        </div>
        <!-- Pagination Buttons for Alert History -->
        <div class="flex justify-end mt-4">
            <button id="prevPageHistory" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded transition-transform transform hover:scale-105 mr-2" disabled>Prev</button>
            <button id="nextPageHistory" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded transition-transform transform hover:scale-105">Next</button>
        </div>
    </div>
</section>
<!-- History Section -->
<section id="history" class="p-6 bg-gray-100 dark:bg-gray-800 transition duration-300 text-gray-800 dark:text-white rounded-lg shadow-md mb-6">
    <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white flex items-center">
        <i class="fas fa-history mr-2"></i>History
    </h1>
    <!-- Note about data update interval -->
    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 flex items-center">
        <i class="fas fa-info-circle mr-2 text-blue-500 dark:text-blue-300" title="Note"></i>
        Historical data updates every 5 minutes for better performance.
    </p>
    <div id="history-content" class="grid grid-cols-1 gap-6">
        <!-- Sensor Data Table Container -->
        <div id="history-sensor-data" class="space-y-6">
            <!-- Dynamic tables will be inserted here -->
        </div>
    </div>
    <div id="pagination-controls" class="flex justify-center mt-6">
        <!-- Pagination controls will be inserted here -->
    </div>
</section>
<!-- settings section -->
<!-- <section id="settings" class="p-6 bg-gray-100 dark:bg-gray-800 transition duration-300 rounded-lg shadow-md mb-6">
  <div class="content-header mb-6">
    <h1 class="text-4xl font-extrabold text-gray-800 dark:text-white">Settings</h1>
  </div>
  <div class="mb-6">
    <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-300 mb-4">System Settings</h2>
    <form>
      <div class="mb-4">
        <label for="refresh-rate" class="block text-lg font-medium text-gray-800 dark:text-gray-300">Data Refresh Rate (seconds)</label>
        <input type="number" id="refresh-rate" name="refresh-rate" min="1" value="60" class="mt-2 block w-full py-2 px-3 border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-base">
      </div>
      <div class="mb-4">
        <label for="sensor-calibration" class="block text-lg font-medium text-gray-800 dark:text-gray-300">Sensor Calibration</label>
        <input type="text" id="sensor-calibration" name="sensor-calibration" class="mt-2 block w-full py-2 px-3 border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-base">
      </div>
      <button type="button" onclick="saveSystemSettings()" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">Save Settings</button>
    </form>
  </div>
</section> -->
</main>
<!-- Footer -->
<footer class="bg-gray-900 text-white border-t dark:border-gray-600 py-5">
  <div class="container mx-auto px-6 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
    <!-- Date and Time Section -->
    <div class="flex items-center space-x-4">
      <div class="bg-gray-800 dark:bg-gray-700 shadow-lg p-4 rounded-lg flex items-center space-x-3">
        <i class="fas fa-calendar-day text-gray-400 dark:text-gray-300"></i> <!-- Calendar Icon -->
        <div id="date-time" class="text-lg">Date and Time</div>
      </div>
    </div>
    <!-- Copyright Section -->
    <div class="text-center md:text-right text-gray-400">
      <p class="text-sm">&copy; 2024 ZDSPGC Heat Index Map. All rights reserved.</p>
    </div>
  </div>
</footer>
</div>
 <!-- external scripts -->
<script src="../src/main.js"></script>
<script src="https://kit.fontawesome.com/4328885b3b.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts@latest/dist/apexcharts.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/simple-statistics/7.7.2/simple-statistics.min.js" defer></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin="" defer></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
      duration: 1000, // global duration for animations
      once: false // whether animation should happen only once - while scrolling down
    });
</script>
<script src="../src/dashboardR.js"></script>
<script src="../src/DashBoardChart.js"></script>
<script src="../src/accordation.js"></script>
<script src="../src/loader.js"></script>
<script src="../src/map-view.js"></script>
<script src="../src/alerts.js"></script>
<script src="../src/history_table.js"></script>
</body>
</html>
document.addEventListener('DOMContentLoaded', function() {
    const itemsPerPage = 5; // Number of items per page

    async function fetchSensorData() {
        try {
            const response = await fetch('../fetch_php/get_history.php');
            const data = await response.json();
            renderTables(data);
        } catch (error) {
            console.error('Error fetching sensor data:', error);
        }
    }

    function renderTables(data) {
        const container = document.getElementById('history-sensor-data');
        container.innerHTML = ''; // Clear previous content

        Object.entries(data).forEach(([stationId, stationData]) => {
            const location = stationData.location; // Get location for each station
            const tableContainer = document.createElement('div');
            tableContainer.classList.add('bg-white', 'dark:bg-gray-900', 'border', 'border-gray-200', 'dark:border-gray-700', 'rounded-md', 'shadow-md', 'mb-4', 'p-4');

            const locationHeader = document.createElement('h2');
            locationHeader.classList.add('text-xl', 'font-semibold', 'mb-2', 'text-gray-800', 'dark:text-white');
            locationHeader.textContent = `Location: ${location}`;
            tableContainer.appendChild(locationHeader);

            const table = document.createElement('table');
            table.classList.add('w-full', 'table-auto', 'overflow-x-auto');

            const thead = document.createElement('thead');
            thead.classList.add('bg-gray-50', 'dark:bg-gray-800');
            const headerRow = document.createElement('tr');
            headerRow.innerHTML = `
                <th class="p-3 text-center border-b">Temperature</th>
                <th class="p-3 text-center border-b">Humidity</th>
                <th class="p-3 text-center border-b">Heat Index</th>
                <th class="p-3 text-center border-b">Timestamp</th>
            `;
            thead.appendChild(headerRow);
            table.appendChild(thead);

            const tbody = document.createElement('tbody');
            table.appendChild(tbody);

            const paginationControls = document.createElement('div');
            paginationControls.classList.add('flex', 'justify-center', 'mt-4');

            let currentPage = 1;
            const totalPages = Math.ceil(stationData.data.length / itemsPerPage);

            function renderPage(page) {
                tbody.innerHTML = ''; // Clear previous content

                const startIndex = (page - 1) * itemsPerPage;
                const endIndex = Math.min(startIndex + itemsPerPage, stationData.data.length);

                for (let i = startIndex; i < endIndex; i++) {
                    const entry = stationData.data[i];
                    const row = document.createElement('tr');
                    row.classList.add('hover:bg-gray-100', 'dark:hover:bg-gray-700');
                    row.innerHTML = `
                        <td class="p-3 border-b text-center">${entry.temperature} °C</td>
                        <td class="p-3 border-b text-center">${entry.humidity} %</td>
                        <td class="p-3 border-b text-center">${entry.heat_index} °C</td>
                        <td class="p-3 border-b text-center">${new Date(entry.timestamp).toLocaleString()}</td>
                    `;
                    tbody.appendChild(row);
                }

                // Render pagination controls
                paginationControls.innerHTML = ''; // Clear previous controls

                const createPageButton = (page, text) => {
                    const button = document.createElement('button');
                    button.textContent = text;
                    button.classList.add('px-4', 'py-2', 'border', 'border-gray-300', 'bg-white', 'dark:bg-gray-700', 'text-gray-800', 'dark:text-white', 'rounded-md', 'mx-1', 'hover:bg-gray-200', 'dark:hover:bg-gray-600');
                    button.addEventListener('click', () => {
                        currentPage = page;
                        renderPage(currentPage);
                    });
                    return button;
                };

                // Limit page buttons to 3
                const maxButtons = 3;
                const startButton = Math.max(1, currentPage - Math.floor(maxButtons / 2));
                const endButton = Math.min(totalPages, startButton + maxButtons - 1);

                if (currentPage > 1) {
                    paginationControls.appendChild(createPageButton(currentPage - 1, 'Previous'));
                }

                for (let i = startButton; i <= endButton; i++) {
                    paginationControls.appendChild(createPageButton(i, i));
                }

                if (currentPage < totalPages) {
                    paginationControls.appendChild(createPageButton(currentPage + 1, 'Next'));
                }
            }

            // Initial render of the first page
            renderPage(currentPage);
            tableContainer.appendChild(table);
            tableContainer.appendChild(paginationControls);
            container.appendChild(tableContainer);
        });
    }

    // Fetch sensor data when the page loads
    fetchSensorData();
});

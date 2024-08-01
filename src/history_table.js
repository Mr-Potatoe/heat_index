
// Function to populate table rows with pagination support
function populateTableBody(data, tbody, currentPage, itemsPerPage) {
    tbody.innerHTML = ''; // Clear existing rows

    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const paginatedData = data.slice(startIndex, endIndex);

    paginatedData.forEach((entry, index) => {
        const tr = document.createElement('tr');
        tr.classList.add(index % 2 === 0 ? 'bg-white' : 'bg-gray-50'); // Alternating row colors
        tr.classList.add(index % 2 === 0 ? 'dark:bg-gray-700' : 'dark:bg-gray-800'); // Text color based on row color
       tr.innerHTML = `
            <td class="px-5 py-3 border-b border-gray-200 text-center text-sm">${entry.temperature}</td>
            <td class="px-5 py-3 border-b border-gray-200 text-center text-sm">${entry.humidity}</td>
            <td class="px-5 py-3 border-b border-gray-200 text-center text-sm">${entry.heat_index}</td>
            <td class="px-5 py-3 border-b border-gray-200 text-center text-sm">${entry.timestamp}</td>
        `;
        tbody.appendChild(tr);
    });
}
// Function to create pagination controls with Font Awesome icons and tooltips
function createPaginationControls(totalItems, currentPage, itemsPerPage, containerId, data, tbody) {
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    const maxVisibleButtons = 3; // Adjust the number of visible page buttons as needed

    // Clear existing pagination controls
    const paginationContainer = document.getElementById(containerId);
    paginationContainer.innerHTML = '';

   // Function to create individual page button with tooltip
    function createPageButton(pageNum, tooltipText) {
        const pageButton = document.createElement('button');
        pageButton.textContent = pageNum;
        pageButton.classList.add('px-3', 'py-1', 'bg-blue-200', 'text-gray-800', 'rounded','transition-transform', 'mx-1'); // Add transition class
        pageButton.setAttribute('title', tooltipText); // Tooltip text

        // Apply transform on hover
        pageButton.classList.add('transform', 'hover:scale-105');

        if (pageNum === currentPage) {
            pageButton.classList.add('bg-blue-500', 'text-white');
        } else {
            pageButton.addEventListener('click', () => {
                populateTableBody(data, tbody, pageNum, itemsPerPage);
                createPaginationControls(totalItems, pageNum, itemsPerPage, containerId, data, tbody);
            });
        }
        paginationContainer.appendChild(pageButton);
    }


    // First Button
    const firstButton = document.createElement('button');
    firstButton.innerHTML = '<i class="fas fa-angle-double-left"></i>';
    firstButton.classList.add('px-3', 'py-1', 'bg-blue-500', 'text-white', 'rounded', 'mr-2', 'transition-transform'); // Add transition class
    firstButton.setAttribute('title', 'First'); // Tooltip for first button

    // Apply transform on hover
    firstButton.classList.add('transform', 'hover:scale-105');

    firstButton.disabled = currentPage === 1;
    firstButton.addEventListener('click', () => {
        populateTableBody(data, tbody, 1, itemsPerPage);
        createPaginationControls(totalItems, 1, itemsPerPage, containerId, data, tbody);
    });
    paginationContainer.appendChild(firstButton);

    // Previous Button
    const prevButton = document.createElement('button');
    prevButton.innerHTML = '<i class="fas fa-angle-left"></i>';
    prevButton.classList.add('px-3', 'py-1', 'bg-blue-500', 'text-white', 'rounded', 'mr-2', 'transition-transform'); // Add transition class
    prevButton.setAttribute('title', 'Previous'); // Tooltip for previous button

    // Apply transform on hover
    prevButton.classList.add('transform', 'hover:scale-105');

    prevButton.disabled = currentPage === 1;
    prevButton.addEventListener('click', () => {
        if (currentPage > 1) {
            populateTableBody(data, tbody, currentPage - 1, itemsPerPage);
            createPaginationControls(totalItems, currentPage - 1, itemsPerPage, containerId, data, tbody);
        }
    });
    paginationContainer.appendChild(prevButton);


    // Calculate range of page buttons around the current page
    let startPage = Math.max(1, currentPage - Math.floor(maxVisibleButtons / 2));
    let endPage = Math.min(totalPages, startPage + maxVisibleButtons - 1);

    if (endPage - startPage + 1 < maxVisibleButtons) {
        startPage = Math.max(1, endPage - maxVisibleButtons + 1);
    }

    // Display page buttons
    for (let pageNum = startPage; pageNum <= endPage; pageNum++) {
        createPageButton(pageNum, `Page ${pageNum}`); // Tooltip text for page buttons
    }

    // Next Button
    const nextButton = document.createElement('button');
    nextButton.innerHTML = '<i class="fas fa-angle-right"></i>';
    nextButton.classList.add('px-3', 'py-1', 'bg-blue-500', 'text-white', 'rounded', 'ml-2', 'transition-transform'); // Add transition class
    nextButton.setAttribute('title', 'Next'); // Tooltip for next button

    // Apply transform on hover
    nextButton.classList.add('transform', 'hover:scale-105');

    nextButton.disabled = currentPage === totalPages;
    nextButton.addEventListener('click', () => {
        if (currentPage < totalPages) {
            populateTableBody(data, tbody, currentPage + 1, itemsPerPage);
            createPaginationControls(totalItems, currentPage + 1, itemsPerPage, containerId, data, tbody);
        }
    });
    paginationContainer.appendChild(nextButton);

    // Last Button
    const lastButton = document.createElement('button');
    lastButton.innerHTML = '<i class="fas fa-angle-double-right"></i>';
    lastButton.classList.add('px-3', 'py-1', 'bg-blue-500', 'text-white', 'rounded', 'ml-2', 'transition-transform'); // Add transition class
    lastButton.setAttribute('title', 'Last'); // Tooltip for last button

    // Apply transform on hover
    lastButton.classList.add('transform', 'hover:scale-105');

    lastButton.disabled = currentPage === totalPages;
    lastButton.addEventListener('click', () => {
        populateTableBody(data, tbody, totalPages, itemsPerPage);
        createPaginationControls(totalItems, totalPages, itemsPerPage, containerId, data, tbody);
    });
    paginationContainer.appendChild(lastButton);
}

// Function to filter data based on custom date range
function filterDataByDateRange(data, startDate, endDate) {
    const filteredData = data.filter(entry => {
        const entryTimestamp = new Date(entry.timestamp).getTime();
        const startTimestamp = new Date(startDate).getTime();
        const endTimestamp = new Date(endDate).getTime();
        return entryTimestamp >= startTimestamp && entryTimestamp <= endTimestamp;
    });
    return filteredData;
}

// Function to fetch and populate data
function fetchDataAndPopulateTables() {
    fetch('../fetch_php/get_history.php')
        .then(response => response.json())
        .then(data => {
            const tbodyBsis = document.querySelector('#tbodyBsis');
            const tbodyFarmersHall = document.querySelector('#tbodyFarmersHall');
            const itemsPerPage = 10; // Adjust as needed

            // Populate BSIS Building table with initial data
            populateTableBody(data.bsis_building, tbodyBsis, 1, itemsPerPage);
            // Create pagination controls for BSIS Building
            createPaginationControls(data.bsis_building.length, 1, itemsPerPage, 'paginationBsis', data.bsis_building, tbodyBsis);

            // Populate Farmers's Hall table with initial data
            populateTableBody(data.farmers_hall, tbodyFarmersHall, 1, itemsPerPage);
            // Create pagination controls for Farmers's Hall
            createPaginationControls(data.farmers_hall.length, 1, itemsPerPage, 'paginationFarmersHall', data.farmers_hall, tbodyFarmersHall);

            // Add event listener to apply filter button for BSIS Building
            document.getElementById('filterBsisButton').addEventListener('click', function() {
                const startDate = document.getElementById('startDateBsis').value;
                const endDate = document.getElementById('endDateBsis').value;
                if (startDate && endDate) {
                    const filteredData = filterDataByDateRange(data.bsis_building, startDate, endDate);
                    populateTableBody(filteredData, tbodyBsis, 1, itemsPerPage);
                    createPaginationControls(filteredData.length, 1, itemsPerPage, 'paginationBsis', filteredData, tbodyBsis);
                } else {
                    alert('Please select both start and end dates.');
                }
            });

            // Add event listener to apply filter button for Farmers's Hall
            document.getElementById('filterFarmersHallButton').addEventListener('click', function() {
                const startDate = document.getElementById('startDateFarmersHall').value;
                const endDate = document.getElementById('endDateFarmersHall').value;
                if (startDate && endDate) {
                    const filteredData = filterDataByDateRange(data.farmers_hall, startDate, endDate);
                    populateTableBody(filteredData, tbodyFarmersHall, 1, itemsPerPage);
                    createPaginationControls(filteredData.length, 1, itemsPerPage, 'paginationFarmersHall', filteredData, tbodyFarmersHall);
                } else {
                    alert('Please select both start and end dates.');
                }
            });
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}

// Fetch data and populate tables on page load
fetchDataAndPopulateTables();

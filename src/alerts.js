document.addEventListener('DOMContentLoaded', () => {
  const currentSection = document.getElementById('current-alerts-section');
  const historySection = document.getElementById('alert-history-section');
  const alertToggleButtons = document.querySelectorAll('.alert-toggle-button');

  let currentType = 'current';

  alertToggleButtons.forEach(button => {
    button.addEventListener('click', () => {
      const type = button.getAttribute('data-type');
      currentType = type;

      alertToggleButtons.forEach(btn => btn.classList.remove('active'));
      button.classList.add('active');

      if (type === 'current') {
        currentSection.classList.remove('hidden');
        historySection.classList.add('hidden');
      } else {
        currentSection.classList.add('hidden');
        historySection.classList.remove('hidden');
      }

      fetchAlerts(type);
    });
  });

  fetchAlerts('current');
  setInterval(() => fetchAlerts(currentType), 300000); // Fetch alerts every 30 seconds

  async function fetchAlerts(type) {
    try {
      const response = await fetch(`../fetch_php/fetch_alerts.php?type=${type}`);
      const data = await response.json();
      displayAlerts(data, type);
    } catch (error) {
      console.error('Error fetching alerts:', error);
    }
  }

  function displayAlerts(data, type) {
    const tableBody = document.getElementById(type === 'current' ? 'current-alerts-table' : 'alert-history-table');
    const itemsPerPage = 5;
    let currentPage = 1;

    const displayPage = (page) => {
      tableBody.innerHTML = '';
      const startIndex = (page - 1) * itemsPerPage;
      const endIndex = startIndex + itemsPerPage;
      const pageData = data.slice(startIndex, endIndex);

      pageData.forEach(alert => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td class="px-6 py-4 text-center">${alert.id}</td>
          <td class="px-6 py-4 text-center">${alert.description}</td>
          <td class="px-6 py-4 text-center">${alert.location}</td>
          <td class="px-6 py-4 text-center">${alert.date}</td>
        `;
        tableBody.appendChild(row);
      });

      document.getElementById(`prevPage${capitalize(type)}`).disabled = currentPage === 1;
      document.getElementById(`nextPage${capitalize(type)}`).disabled = endIndex >= data.length;
    };

    displayPage(currentPage);

    document.getElementById(`prevPage${capitalize(type)}`).addEventListener('click', () => {
      if (currentPage > 1) {
        currentPage--;
        displayPage(currentPage);
      }
    });

    document.getElementById(`nextPage${capitalize(type)}`).addEventListener('click', () => {
      if (currentPage * itemsPerPage < data.length) {
        currentPage++;
        displayPage(currentPage);
      }
    });
  }

  function capitalize(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
  }
});

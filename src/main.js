// src\main.js

document.addEventListener('DOMContentLoaded', function() {
  // Toggle dashboard dropdown visibility
  const quickActionsBtn = document.getElementById('quick-actions-btn');
  const quickActionsDropdown = document.querySelector('.quick-actions-dropdown');

  quickActionsBtn.addEventListener('click', function() {
      quickActionsDropdown.classList.toggle('hidden');
  });

  // Close the dropdown if user clicks outside of it
  document.addEventListener('click', function(event) {
      if (!quickActionsBtn.contains(event.target) && !quickActionsDropdown.contains(event.target)) {
          quickActionsDropdown.classList.add('hidden');
      }
  });

  // Dark mode functionality
  const darkModeToggle = document.getElementById('dark-mode-toggle');
  const darkModeClass = 'dark';
  const body = document.body;

  // Load dark mode preference from local storage
  if (localStorage.getItem('darkMode') === 'enabled') {
    enableDarkMode();
  }

  darkModeToggle.addEventListener('click', () => {
    if (body.classList.contains(darkModeClass)) {
      disableDarkMode();
    } else {
      enableDarkMode();
    }
  });

  function enableDarkMode() {
    body.classList.add(darkModeClass);
    localStorage.setItem('darkMode', 'enabled');
    darkModeToggle.innerHTML = '<i class="fas fa-sun"></i>'; // Change to sun icon
  }

  function disableDarkMode() {
    body.classList.remove(darkModeClass);
    localStorage.setItem('darkMode', 'disabled');
    darkModeToggle.innerHTML = '<i class="fas fa-moon"></i>'; // Change to moon icon
  }

  // Update date and time
  function updateDateTime() {
    const dateTimeElement = document.getElementById('date-time');
    const now = new Date();
    const formattedDateTime = now.toLocaleString();
    dateTimeElement.textContent = formattedDateTime;
  }
  // Update the date and time every second
  setInterval(updateDateTime, 1000);
  // Initial call to display the date and time immediately
  updateDateTime();
  
  // Sidebar functionality
  const menuToggle = document.getElementById('menu-toggle');
  const sidebar = document.getElementById('sidebar');
  const sidebarClose = document.getElementById('sidebar-close');

  menuToggle.addEventListener('click', function() {
      sidebar.classList.toggle('-translate-x-full');
  });

  sidebarClose.addEventListener('click', function() {
      sidebar.classList.add('-translate-x-full');
  });

  // Close sidebar when clicking outside
  document.addEventListener('click', function(event) {
      if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
          sidebar.classList.add('-translate-x-full');
      }
  });

  // Initial call to show default section
  showSection('dashboard'); // Replace 'dashboard' with your default section id
});

// Navbar functionality
// Function to handle section navigation and update active state
function showSection(sectionId) {
  // Remove 'active' class from all nav links
  document.querySelectorAll('.nav-link').forEach(nav => nav.classList.remove('active'));

  // Add 'active' class to the clicked nav link
  const activeNavLink = document.querySelector(`.nav-link[href="#${sectionId}"]`);
  if (activeNavLink) {
    activeNavLink.classList.add('active');
  }

  // Hide all sections
  document.querySelectorAll('main section').forEach(section => {
    section.style.display = 'none';
  });

  // Show the target section
  const target = document.getElementById(sectionId);
  if (target) {
    target.style.display = 'block';
  }
}

// Add event listeners for nav links
document.addEventListener('DOMContentLoaded', function() {
  const navLinks = document.querySelectorAll('.nav-link');
  navLinks.forEach(navLink => {
    navLink.addEventListener('click', function(event) {
      event.preventDefault();
      const sectionId = this.getAttribute('href').substring(1);
      showSection(sectionId);
    });
  });
});

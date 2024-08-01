function showLoader(chartId) {
    document.getElementById(`chart-loader-${chartId}`).style.display = 'flex';
}

function hideLoader(chartId) {
    document.getElementById(`chart-loader-${chartId}`).style.display = 'none';
}

// Example usage: Call showLoader when starting to load the chart and hideLoader when the chart is fully loaded

// Show loader
showLoader(1); // For BSIS Building
showLoader(2); // For Farmers Hall

// Hide loader (simulate chart loading completion)
setTimeout(() => {
    hideLoader(1); // For BSIS Building
    hideLoader(2); // For Farmers Hall
}, 2000); // Simulate a 2-second loading time


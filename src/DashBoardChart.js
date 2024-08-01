// Function to get status based on heat index
function getStatus(heatIndex) {
    if (heatIndex < 27) return 'Not Hazardous';
    if (heatIndex < 32) return 'Caution';
    if (heatIndex < 41) return 'Extreme Caution';
    if (heatIndex < 54) return 'Danger';
    return 'Extreme Danger';
}

// Function to get current theme
function getCurrentTheme() {
    const themeSection = document.querySelectorAll('section')[0];
    return themeSection.classList.contains('dark') ? 'dark' : 'light';
}

// Function to generate chart options
function generateChartOptions(seriesData, regressionSeries, forecastSeries, title) {
    const theme = getCurrentTheme();
    
    return {
        chart: {
            height: "100%",
            type: "line",
            toolbar: { show: false },
            animations: { enabled: false },
            zoom: { enabled: true },
            panning: { enabled: true }
        },
        
        tooltip: {
            enabled: true,
            shared: true,
            intersect: false,
            followCursor: true,
            x: {
                show: true,
                formatter: value => {
                    const date = new Date(value);
                    return `${date.toLocaleDateString('en-US')} ${date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}`;
                }
            },
            y: {
                formatter: value => `${Math.round(value)}°C (${getStatus(value)})`
            },
            style: {
                fontSize: '14px',
                fontFamily: 'Inter, sans-serif',
                colors: theme === 'dark' ? '#eee' : '#333'
            }
        },
        
        fill: {
            type: "gradient",
            gradient: {
                opacityFrom: 0.4,
                opacityTo: 0.1,
                shade: theme === 'dark' ? '#DC3545' : '#FF6347',
                gradientToColors: [theme === 'dark' ? '#DC3545' : '#FF6347'],
                stops: [0, 100]
            }
        },
        
        dataLabels: { enabled: false },
        stroke: { width: 2 },
        grid: {
            show: false,
            borderColor: theme === 'dark' ? '#444' : '#e3e3e3',
            strokeDashArray: 4,
            padding: { left: 2, right: 20, top: 4, bottom: 0 }
        },
        markers: { size: 6, hover: { sizeOffset: 6 } },
        xaxis: {
            type: 'datetime',
            labels: {
                show: true,
                formatter: value => {
                    const date = new Date(value);
                    return `${date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}`;
                },
                style: {
                    colors: theme === 'dark' ? '#bbb' : '#888',
                    fontSize: '12px'
                }
            },
            axisBorder: { show: true, color: theme === 'dark' ? '#666' : '#d3d3d3' },
            axisTicks: { show: true, color: theme === 'dark' ? '#666' : '#d3d3d3' }
        },
        yaxis: {
            title: { text: 'Heat Index (°C)', style: { color: theme === 'dark' ? '#bbb' : '#555' } },
            labels: {
                formatter: value => `${Math.round(value)}°C`,
                style: { colors: theme === 'dark' ? '#bbb' : '#888', fontSize: '12px' }
            }
        },
        
        title: {
            text: title,
            align: 'left',
            margin: 20,
            offsetX: 0,
            offsetY: -10,
            style: { fontSize: '18px', color: theme === 'dark' ? '#eee' : '#333' }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'left',
            floating: true,
            offsetY: -20,
            labels: { colors: theme === 'dark' ? '#eee' : '#333', fontSize: '12px' }
        },
        
        series: [
            ...seriesData,
            { name: 'Regression Line', data: regressionSeries, color: theme === 'dark' ? "#007bff" : "#0056b3" },
            { name: 'Forecast', data: forecastSeries, color: theme === 'dark' ? "#28a745" : "#1e7e34", dashArray: 4 }
        ]
    };
}

// Function to calculate linear regression
function calculateRegression(data) {
    const points = data.map(item => [item.timestamp, item.heat_index]);
    const regression = ss.linearRegression(points);
    const regressionLine = ss.linearRegressionLine(regression);
    return data.map(item => ({ x: item.timestamp, y: regressionLine(item.timestamp) }));
}

// Function to forecast future values
function forecastFutureValues(data, numHours) {
    const latestTimestamp = data[data.length - 1].timestamp;
    const points = data.map(item => [item.timestamp, item.heat_index]);
    const regression = ss.linearRegression(points);
    const regressionLine = ss.linearRegressionLine(regression);

    return Array.from({ length: numHours }, (_, i) => ({
        x: latestTimestamp + ((i + 1) * 3600000),
        y: regressionLine(latestTimestamp + ((i + 1) * 3600000))
    }));
}

// Function to fetch sensor data and create ApexCharts
async function fetchAndRenderCharts() {
    try {
        const response = await fetch('../fetch_php/fetch_sensor_data.php'); // Replace with actual path
        const data = await response.json();

        const formattedData = data.map(item => ({
            ...item,
            timestamp: new Date(item.timestamp).getTime()
        }));

        const bsisData = formattedData.filter(item => item.location === 'BSIS Building');
        const farmersData = formattedData.filter(item => item.location === 'Farmers\'s Hall');

        const bsisSeries = [
            { name: 'Heat Index', data: bsisData.map(item => ({ x: item.timestamp, y: item.heat_index })), color: "#DC3545" }
        ];
        const bsisRegressionSeries = calculateRegression(bsisData);
        const bsisForecastSeries = forecastFutureValues(bsisData, 2);

        const farmersSeries = [
            { name: 'Heat Index', data: farmersData.map(item => ({ x: item.timestamp, y: item.heat_index })), color: "#DC3545" }
        ];
        const farmersRegressionSeries = calculateRegression(farmersData);
        const farmersForecastSeries = forecastFutureValues(farmersData, 2);

        // Render charts only when necessary to avoid blocking
        if (document.querySelector("#conditionsChart") && document.querySelector("#conditionsChart2")) {
            const chart1 = new ApexCharts(document.querySelector("#conditionsChart"), generateChartOptions(bsisSeries, bsisRegressionSeries, bsisForecastSeries, 'BSIS Building Heat Index'));
            const chart2 = new ApexCharts(document.querySelector("#conditionsChart2"), generateChartOptions(farmersSeries, farmersRegressionSeries, farmersForecastSeries, 'Farmers Hall Heat Index'));

            chart1.render();
            chart2.render();
        }
    } catch (error) {
        console.error('Error fetching or rendering charts:', error);
    }
}

// Defer the fetch and render operation until the DOM is fully loaded
document.addEventListener('DOMContentLoaded', () => {
    // Defer to avoid blocking rendering
    setTimeout(fetchAndRenderCharts, 0);
});

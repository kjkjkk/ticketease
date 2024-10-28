let districtChart;

function getDistrictTicketsData() {
    const month = $("#districtMonth").val(); // Fetch selected month

    $.ajax({
        url: "/district-tickets-data",
        method: "GET",
        dataType: "json",
        data: {
            month: month, // Send month to backend
        },
        success: function (data) {
            const labels = data.map((item) => {
                // Truncate district name to 8 characters
                return item.district_name.length > 8
                    ? item.district_name.substring(0, 8) + "..."
                    : item.district_name;
            });
            const fullDistrictNames = data.map((item) => item.district_name); // Store full district names
            const counts = data.map((item) => item.tickets);

            const ctx = document
                .getElementById("districtChart")
                .getContext("2d");

            if (districtChart) {
                districtChart.destroy(); // Destroy previous chart instance if it exists
            }

            districtChart = new Chart(ctx, {
                type: "line",
                data: {
                    labels: labels, // Truncated labels
                    datasets: [
                        {
                            label: "Number of Tickets",
                            data: counts,
                            fill: true,
                            backgroundColor: (context) => {
                                const chart = context.chart;
                                const { ctx, chartArea } = chart;

                                if (!chartArea) {
                                    // This avoids errors if the chart has not been fully rendered yet
                                    return null;
                                }

                                const gradient = ctx.createLinearGradient(
                                    0,
                                    chartArea.top,
                                    0,
                                    chartArea.bottom
                                );
                                gradient.addColorStop(0, "#d63384"); 
                                gradient.addColorStop(1, "#f7b8d9"); // End color

                                return gradient;
                            },
                            borderColor: "#000", // Border color for line
                            borderWidth: 2,
                            pointBackgroundColor: "#d63384",
                            pointBorderColor: "#000",
                            pointHoverRadius: 5,
                            pointRadius: 4,
                            tension: 0.4,
                        },
                    ],
                },

                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true, // Y-axis starts at 0
                        },
                    },
                    interaction: {
                        mode: "index",
                        intersect: false,
                    },
                    plugins: {
                        tooltip: {
                            enabled: true,
                            mode: "index",
                            intersect: false,
                            callbacks: {
                                title: function (tooltipItems) {
                                    // Show the full district name on hover in the tooltip
                                    const index = tooltipItems[0].dataIndex;
                                    return fullDistrictNames[index];
                                },
                            },
                        },
                    },
                },
            });
        },
        error: function (error) {
            console.log(error);
        },
    });
}

// Trigger data fetch on page load and when month changes
$(function () {
    getDistrictTicketsData();
    $("#districtMonth").change(function () {
        getDistrictTicketsData();
    });
});

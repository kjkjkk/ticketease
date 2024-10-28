let ticketNatureChart;

function getTicketNatureTicketsData() {
    const month = $("#ticketNatureMonth").val();
    const technician_id = $("#technician_id").val(); // Get the selected technician_id

    $.ajax({
        url: "/ticket-nature-tickets-data",
        method: "GET",
        dataType: "json",
        data: {
            month: month,
            technician_id: technician_id, // Pass technician_id to the backend
        },

        success: function (data) {
            console.log(data);
            const labels = data.map((item) => item.ticket_nature_name);
            const counts = data.map((item) => item.tickets);

            const ctx = document
                .getElementById("ticketNatureChart")
                .getContext("2d");

            if (ticketNatureChart) {
                ticketNatureChart.destroy();
            }

            ticketNatureChart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: labels,
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
                                gradient.addColorStop(0, "#fd7e14");
                                gradient.addColorStop(1, "#fccca2"); // End color

                                return gradient;
                            },
                            borderColor: "#fd7e14", // Border color for line
                            borderWidth: 2,
                            tension: 0.4,
                            borderRadius: 10,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: "x",
                    scales: {
                        y: {
                            beginAtZero: true,
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

$(function () {
    getTicketNatureTicketsData();
    $("#ticketNatureMonth, #technician_id").change(function () {
        getTicketNatureTicketsData();
    });
});

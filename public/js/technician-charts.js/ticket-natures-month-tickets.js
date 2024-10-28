let ticketNatureByMonthChart;

function loadTicketsByNature() {
    const month = $("#ticketNatureMonth").val();

    $.ajax({
        url: "/technician-ticket-nature-per-month",
        method: "GET",
        data: {
            month: month,
        },
        success: function (response) {
            const ticketNatures = response.ticketNatures;
            const labels = ticketNatures.map((item) => item.ticket_nature_name);
            const data = ticketNatures.map((item) => item.tickets);
            const percentages = ticketNatures.map((item) => item.percentage);
            const totalTickets = response.totalTickets;

            // Update the total tickets in the HTML
            $("#totalTicketsCount").text(totalTickets);

            const ctx = document
                .getElementById("ticketsByNature")
                .getContext("2d");

            if (ticketNatureByMonthChart) {
                ticketNatureByMonthChart.destroy();
            }

            ticketNatureByMonthChart = new Chart(ctx, {
                type: "doughnut",
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: "Number of Tickets",
                            data: data,
                            backgroundColor: [
                                "#FFCE56",
                                "#FF6384",
                                "#36A2EB",
                                "#4BC0C0",
                                "#9966FF",
                                "#FF9F40",
                            ],
                            borderColor: ["#000"],
                            borderWidth: 2,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: "right",
                            labels: {
                                boxWidth: 12, // Adjust the width of the box (for square)
                                boxHeight: 12, // Adjust the height if needed (optional)
                                usePointStyle: true,
                                generateLabels: function (chart) {
                                    const datasets = chart.data.datasets;
                                    return datasets[0].data.map(function (
                                        data,
                                        i
                                    ) {
                                        return {
                                            text: `${chart.data.labels[i]} ${percentages[i]}%`,
                                            fillStyle:
                                                datasets[0].backgroundColor[i],
                                            hidden: false,
                                            index: i,
                                        };
                                    });
                                },
                            },
                        },
                        tooltip: {
                            callbacks: {
                                label: function (tooltipItem) {
                                    const label = tooltipItem.label || "";
                                    return `${label}: ${tooltipItem.raw} (${
                                        percentages[tooltipItem.dataIndex]
                                    }%)`;
                                },
                            },
                        },
                    },
                    elements: {
                        center: {
                            text: totalTickets,
                            color: "#FF6384", // Text color
                            fontStyle: "Arial", // Text style
                            sidePadding: 20, // Padding around text
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
    loadTicketsByNature();
    $("#ticketNatureMonth").change(function () {
        loadTicketsByNature();
    });
});

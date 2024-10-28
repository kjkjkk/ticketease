let pierChart;
function getPendingTicketsData() {
    $.ajax({
        url: "/technician-pending-ticekts-data",
        method: "GET",
        dataType: "json",
        success: function (data) {
            const labels = data.map((item) => "Status " + item.status_name);
            const counts = data.map((item) => item.count);

            const ctx = document
                .getElementById("pendingTicketsPieChart")
                .getContext("2d");

            if (pierChart) {
                pierChart.destroy();
            }

            pierChart = new Chart(ctx, {
                type: "pie",
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: "Ticket Counts",
                            data: counts,
                            backgroundColor: [
                                "#9966FF",
                                "#FFCE56",
                                "#FF6384",
                                "#36A2EB",
                                "#4BC0C0",
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
                },
            });
        },
        error: function (error) {
            console.log(error);
        },
    });
}

$(function () {
    getPendingTicketsData();
});

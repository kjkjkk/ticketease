let chart;
function getPendingTicketsData() {
    $.ajax({
        url: "/pending-tickets-data",
        method: "GET",
        dataType: "json",
        success: function (data) {
            const labels = data.map((item) => "Status " + item.status_name);
            const counts = data.map((item) => item.count);

            const ctx = document
                .getElementById("pendingTicketsPieChart")
                .getContext("2d");

            if (chart) {
                chart.destroy();
            }

            chart = new Chart(ctx, {
                type: "pie",
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: "Ticket Counts",
                            data: counts,
                            backgroundColor: [
                                "#ffc107",
                                "#198754",
                                "#6f42c1",
                                "#fd7e14",
                                "#d63384",
                                "#0d6efd",
                            ],
                            borderWidth: 2,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: "bottom",
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
    getPendingTicketsData();
});

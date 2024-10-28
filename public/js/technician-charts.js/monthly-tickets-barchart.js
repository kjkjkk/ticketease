let monthlyTickets;

function getDistrictTicketsData() {
    const year = $("#ticketsMonthly").val(); // Correctly get year from dropdown

    $.ajax({
        url: "/technician-monthly-tickets-data",
        method: "GET",
        dataType: "json",
        data: {
            year: year, // Pass correct year
        },
        success: function (data) {
            const labels = data.map((item) => item.month); // Use correct property name
            const counts = data.map((item) => item.tickets);

            const ctx = document
                .getElementById("monthlyTickets")
                .getContext("2d");

            if (monthlyTickets) {
                monthlyTickets.destroy(); // Destroy the old chart if it exists
            }

            monthlyTickets = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: "Number of Tickets",
                            data: counts,
                            backgroundColor: "rgba(124, 80, 216, .8)",
                            borderColor: "#000",
                            borderWidth: 2,
                            fill: true,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
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
    getDistrictTicketsData();
    $("#ticketsMonthly").change(function () {
        getDistrictTicketsData();
    });
});

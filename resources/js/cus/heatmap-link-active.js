$(document).ready(function () {
    $(".sidebar-link").each(function () {
        // Check if the link's ID matches the previous route
        if ($(this).attr("id") === "admin.heatmap") {
            // Add the active class to the matching link
            $(this).addClass("active");
        }
    });
});

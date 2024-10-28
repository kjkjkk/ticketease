import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/sass/app.scss',
                'resources/sass/_variables.scss',
                'resources/js/cus/template.js',
                'resources/js/cus/heatmap-link-active.js',
                'resources/js/cus/recycable.js',
                'resources/js/cus/ticketSubmissionForDevice.js',
                'public/css/styles.css',
                'public/js/dependencies/chart.js',
                'public/css/uicons-solid-straight.css',
                'public/css/toastr.min.css',
                'public/js/dependencies/jquery.min.js',
                'public/js/dependencies/moment.min.js',
                'public/js/dependencies/toastr.min.js',
                'public/js/dependencies/pusher.min.js',
                'public/js/technician-charts.js/monthly-tickets-barchart.js',
                'public/js/technician-charts.js/ticket-natures-month-tickets.js',
                'public/js/technician-charts.js/pending-tickets-piechart.js',
                'public/js/admin-charts/pending-tickets-piechart.js',
                'public/js/admin-charts/district-tickets-linechart.js',
                'public/js/admin-charts/ticket-nature-tickets-barchart.js',
                'public/js/technician-charts.js/pending-tickets-piechart.js'
            ],
            refresh: true,
        }),
    ],
});

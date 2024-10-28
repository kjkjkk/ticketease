import "./bootstrap";
// import Pusher from "pusher-js";
// import $ from "jquery";
// import moment from "moment";
// import "public/js/dependencies/jquery.min.js";
// import "public/js/dependencies/moment.min.js";
// import "public/js/dependencies/toastr.min.js";
// import "public/js/dependencies/pusher.min.js";
// import "public/js/dependencies/chart.js";
// import "public/css/toastr.min.css";
// import "public/css/uicons-solid-straight.cs";
// import "public/css/styles.css";

import { Tooltip, Popover } from "bootstrap";

document.addEventListener("DOMContentLoaded", function () {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new Tooltip(tooltipTriggerEl);
    });

    // Initialize popovers
    var popoverTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="popover"]')
    );
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new Popover(popoverTriggerEl);
    });
});

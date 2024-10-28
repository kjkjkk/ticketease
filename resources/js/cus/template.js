const sidebarToggle = document.querySelector("#sidebar-toggle");
const sidebar = document.querySelector("#sidebar");
const overlay = document.querySelector(".overlay");
const content = document.querySelector(".content");

sidebarToggle.addEventListener("click", function () {
    if (window.innerWidth <= 992) {
        sidebar.classList.toggle("show");
        if (sidebar.classList.contains("show")) {
            overlay.style.display = "block";
            content.classList.add("overlay-active");
        } else {
            overlay.style.display = "none";
            content.classList.remove("overlay-active");
        }
    } else {
        sidebar.classList.toggle("collapsed");
    }
});

overlay.addEventListener("click", function () {
    if (window.innerWidth <= 992) {
        sidebar.classList.remove("show");
        overlay.style.display = "none";
        content.classList.remove("overlay-active");
    }
});

// Prevent overlay click from affecting sidebar
sidebar.addEventListener("click", function (e) {
    if (window.innerWidth <= 992 && sidebar.classList.contains("show")) {
        e.stopPropagation();
    }
});

// Manage active state for sidebar links and dropdowns
document.querySelectorAll(".sidebar-dropdown").forEach((link) => {
    link.addEventListener("click", function () {
        // Toggle the active class on the clicked link
        this.classList.toggle("sidebar-dropdown-active");

        // If the clicked link is a dropdown item, toggle the parent dropdown's open state
        let parentDropdown = this.closest(".sidebar-dropdown");
        if (parentDropdown) {
            parentDropdown.classList.toggle("show");
            parentDropdown.previousElementSibling.classList.toggle("collapsed");
        }
    });
});

// sidebar toggle button animation
function toggleRotation() {
    const menuIcon = document.getElementById("menu-icon");
    menuIcon.classList.toggle("rotate");
}

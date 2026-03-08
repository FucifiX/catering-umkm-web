// public/assets/js/profile-dropdown.js
document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.getElementById("profileToggle");
    const dropdown = document.getElementById("profileDropdown");

    document.addEventListener("click", function (e) {
        if (toggle.contains(e.target)) {
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
        } else if (!dropdown.contains(e.target)) {
            dropdown.style.display = "none";
        }
    });
});

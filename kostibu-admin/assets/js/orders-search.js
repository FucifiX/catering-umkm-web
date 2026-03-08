document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("orderSearch");
    const rows = document.querySelectorAll(".table-data tbody tr");

    if (!searchInput) return;

    searchInput.addEventListener("input", function () {
        const keyword = this.value.toLowerCase();

        rows.forEach(row => {
            const content = row.textContent.toLowerCase();
            row.style.display = content.includes(keyword) ? "" : "none";
        });
    });
});

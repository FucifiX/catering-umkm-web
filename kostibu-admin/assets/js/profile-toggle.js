document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.getElementById("profileToggle");
    const dropdown = document.getElementById("profileDropdown");

    if (!toggleBtn || !dropdown) return;

    // Tampilkan/sembunyikan dropdown saat avatar diklik
    toggleBtn.addEventListener("click", function (e) {
        e.stopPropagation();
        dropdown.classList.toggle("show");
    });

    // Sembunyikan dropdown jika klik di luar
    document.addEventListener("click", function (e) {
        if (!dropdown.contains(e.target) && !toggleBtn.contains(e.target)) {
            dropdown.classList.remove("show");
        }
    });

    // Tutup dropdown jika tekan tombol ESC
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape" || e.key === "Esc") {
            dropdown.classList.remove("show");
        }
    });
});

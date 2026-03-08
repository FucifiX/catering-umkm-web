document.addEventListener("DOMContentLoaded", function () {
    const inputGambar = document.getElementById("gambar");
    const preview = document.getElementById("preview");

    if (inputGambar && preview) {
        inputGambar.addEventListener("change", function () {
            const file = this.files[0];

            if (file) {
                const fileSizeMB = file.size / 1024 / 1024;
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];

                if (fileSizeMB > 2) {
                    alert("Ukuran gambar maksimal 2MB.");
                    this.value = "";
                    preview.style.display = "none";
                    return;
                }

                if (!allowedTypes.includes(file.type)) {
                    alert("Hanya file JPG atau PNG yang diperbolehkan.");
                    this.value = "";
                    preview.style.display = "none";
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = "block";
                };
                reader.readAsDataURL(file);
            }
        });
    }
});

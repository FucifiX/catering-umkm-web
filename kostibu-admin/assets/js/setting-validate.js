// assets/js/setting-validate.js
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        const name = form.querySelector('input[name="name"]');
        const email = form.querySelector('input[name="email"]');

        if (!name.value.trim()) {
            alert("Nama tidak boleh kosong!");
            name.focus();
            e.preventDefault();
            return;
        }

        if (!email.value.trim()) {
            alert("Email wajib diisi!");
            email.focus();
            e.preventDefault();
            return;
        }

        const emailRegex = /^[^@]+@[^@]+\.[a-zA-Z]{2,}$/;
        if (!emailRegex.test(email.value)) {
            alert("Format email tidak valid!");
            email.focus();
            e.preventDefault();
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("searchInput");
    if (input) {
        input.addEventListener("input", function () {
            if (this.value.length > 2 || this.value.length === 0) {
                this.form.submit();
            }
        });
    }
});

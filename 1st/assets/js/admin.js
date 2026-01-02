document.addEventListener("DOMContentLoaded", () => {
    const switcher = document.getElementById("color_mode");

    // если тема сохранена
    if (localStorage.getItem("theme") === "dark") {
        document.body.classList.add("dark");
        switcher.checked = true;
    }

    switcher.addEventListener("change", () => {
        if (switcher.checked) {
            document.body.classList.add("dark");
            localStorage.setItem("theme", "dark");
        } else {
            document.body.classList.remove("dark");
            localStorage.setItem("theme", "light");
        }
    });
});
document.addEventListener("DOMContentLoaded", () => {
    const switcher = document.getElementById("color_mode");
    if (!switcher) return;

    if (localStorage.getItem("theme") === "dark") {
        document.body.classList.add("dark");
        switcher.checked = true;
    }

    switcher.addEventListener("change", () => {
        document.body.classList.toggle("dark", switcher.checked);
        localStorage.setItem(
            "theme",
            switcher.checked ? "dark" : "light"
        );
    });
});

document.addEventListener("DOMContentLoaded", () => {
    console.log("user.js loaded"); // проверка подключения

    const btn = document.getElementById("effect_toggle");

    if (!btn) {
        console.error("Кнопка #effect_toggle не найдена");
        return;
    }

    btn.addEventListener("click", () => {
        document.body.classList.toggle("effect-dark");
    });
});
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
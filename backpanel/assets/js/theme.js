document.addEventListener("DOMContentLoaded", () => {
    const root = document.documentElement;
    const toggleBtn = document.getElementById("theme-toggle");

    // 1. Initial State Sync
    const currentTheme = localStorage.getItem('theme') || 'dark';
    if (currentTheme === 'dark') {
        root.classList.add('dark');
    } else {
        root.classList.remove('dark');
    }

    // 2. Toggle Protocol
    if (toggleBtn) {
        toggleBtn.addEventListener("click", () => {
            root.classList.toggle("dark");
            const theme = root.classList.contains("dark") ? "dark" : "light";
            localStorage.setItem("theme", theme);
        });
    }
});
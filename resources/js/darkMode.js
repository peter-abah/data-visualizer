function init() {
    window.initTheme = true;

    let theme = localStorage.theme ?? getSystemPreferenceForTheme();

    updateThemeInHTML(theme);

    window.dispatchEvent(
        new CustomEvent("theme-change", { detail: { theme } })
    );
}

export function updateTheme(theme) {
    if (theme === "system") {
        localStorage.removeItem("theme");
        // Delete cookie
        document.cookie = "theme=; Max-Age=0; path=/";
        theme = getSystemPreferenceForTheme();
    } else {
        localStorage.theme = theme;
        // Save theme in cookie to persist theme change and prevent FOUC
        document.cookie = `theme=${theme}; max-age=31536000; path=/`;
    }

    updateThemeInHTML(theme);
    window.dispatchEvent(
        new CustomEvent("theme-change", { detail: { theme } })
    );
}

function updateThemeInHTML(theme) {
    document.documentElement.classList.remove("system");

    if (theme === "dark") {
        document.documentElement.classList.add("dark");
    } else {
        document.documentElement.classList.remove("dark");
    }
}

function getSystemPreferenceForTheme() {
    return window.matchMedia("(prefers-color-scheme: dark)").matches
        ? "dark"
        : "light";
}

document.addEventListener("DOMContentLoaded", function (event) {
    const themeButtons = [...document.getElementById("theme-btns").children];
    themeButtons.forEach((btn, i) => {
        btn.addEventListener("click", (e) => {
            updateTheme(btn.dataset.theme);
            btn.classList.add('hidden');
            themeButtons[(i + 1) % 3].classList.remove('hidden');
        });
    });
});

if (!window.initTheme) init();

import { useState, useEffect } from "react";

// Return theme of the site and updates when theme changes
function useTheme() {
    const [theme, setTheme] = useState(localStorage.theme);

    useEffect(() => {
        window.addEventListener("theme-change", ((e: CustomEvent) => {
            setTheme(e.detail.theme);
        }) as EventListener);
    }, []);

    return theme;
}

export default useTheme;

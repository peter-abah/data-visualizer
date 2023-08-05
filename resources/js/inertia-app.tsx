// Used for loading inertia
import "./bootstrap";

import { createInertiaApp } from "@inertiajs/react";
import { createRoot } from "react-dom/client";
import Alpine from "alpinejs";

window.Alpine = Alpine;
Alpine.start();

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.tsx", { eager: true });
        return pages[`./Pages/${name}.tsx`];
    },
    setup({ el, App, props }) {
        createRoot(el).render(<App {...props} />);
    },
});

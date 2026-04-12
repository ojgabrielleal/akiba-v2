import "./bootstrap";
import { createInertiaApp } from "@inertiajs/svelte";
import { mount } from "svelte";
import { registerSW } from 'virtual:pwa-register';

registerSW({ immediate: true });

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./pages/**/*.svelte", { eager: true });
        return pages[`./pages/${name}.svelte`];
    },
    setup({ el, App, props, plugin }) {
        // A aplicação será montada normalmente, o PWA será gerenciado pelo Vite.
        mount(App, { target: el, props });
    },
});

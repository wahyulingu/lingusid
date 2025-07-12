import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { ZiggyVue } from 'ziggy-js';
import { initializeTheme } from './Composables/useAppearance';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) => {
        const pages = import.meta.glob<DefineComponent>('./Pages/**/*.vue');
        let path = `./Pages/${name}.vue`;
        if (!pages[path]) {
            path = `./Pages/Dashboard/${name}.vue`;
        }
        if (!pages[path]) {
            path = `./Pages/Dashboard/web/${name}.vue`;
        }
        if (!pages[path]) {
            path = `./Pages/Dashboard/sid/${name}.vue`;
        }
        if (!pages[path]) {
            path = `./Pages/Public/${name}.vue`;
        }
        return pages[path]();
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on page load...
initializeTheme();

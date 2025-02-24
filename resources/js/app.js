import './bootstrap';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
// import Vue3Recaptcha from 'vue3-recaptcha-v2';
import { install } from 'vue3-recaptcha-v2'

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(install, {
                sitekey: '6LetEespAAAAAAHguVtfkzBNnyBaX43S0JHEIhTR',
                cnDomains: false,
              })
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

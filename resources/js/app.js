import './bootstrap';
import '../css/app.css';
import "vue-toastification/dist/index.css";

import {createApp, h} from 'vue';
import {createInertiaApp} from '@inertiajs/vue3';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import Toast from "vue-toastification";
import {createPinia} from 'pinia'
import {ZiggyVue} from '../../vendor/tightenco/ziggy';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
const pinia = createPinia()

const toast_options = {
    transition: "Vue-Toastification__bounce",
    maxToasts: 15,
    newestOnTop: true,
    position: "bottom-left",
    timeout: 5000,
    closeOnClick: true,
    pauseOnFocusLoss: false,
    pauseOnHover: true,
    draggable: true,
    draggablePercent: 0.6,
    showCloseButtonOnHover: true,
    hideProgressBar: false,
    closeButton: "button",
    icon: true,
    rtl: false
}

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({el, App, props, plugin}) {
        return createApp({render: () => h(App, props)})
            .use(plugin)
            .use(ZiggyVue)
            .use(Toast, toast_options)
            .use(pinia)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

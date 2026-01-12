import './bootstrap';
import '../css/app.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import { Modal } from 'bootstrap';


import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from 'ziggy-js';

createInertiaApp({
  resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    window.bootstrap = { Modal };

    return createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      // --- ย้ายมาตรงนี้ (ต้องอยู่ก่อน mount) ---
      .mount(el); // --- mount ต้องอยู่บรรทัดสุดท้าย ---
  },
});
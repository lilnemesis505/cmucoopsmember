import './bootstrap';
import '../css/app.css';
import 'bootstrap/dist/css/bootstrap.min.css'; // <--- 1. เพิ่มบรรทัดนี้ (โหลด CSS)
import { Modal } from 'bootstrap';             // <--- 2. (ถ้ายังไม่มี) เพิ่มบรรทัดนี้เพื่อให้ JS ทำงาน

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from 'ziggy-js';

createInertiaApp({
  resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    // ทำให้ Bootstrap ใช้งานได้ทั่วทั้งแอพ
    window.bootstrap = { Modal }; // <--- 3. เพิ่มบรรทัดนี้ (เพื่อให้ Home.vue เรียกใช้ได้ง่ายๆ)

    return createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .mount(el);
  },
});
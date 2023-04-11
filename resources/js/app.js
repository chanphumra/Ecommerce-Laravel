import './bootstrap';

import { createApp } from 'vue';
import app from './app.vue';
import router from './routes';

createApp(app).use(router).mount('#app');
import './bootstrap';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css';

window.Swal = Swal;

import { createApp } from 'vue';
import app from './app.vue';
import router from './routes';

createApp(app).use(router).mount('#app');

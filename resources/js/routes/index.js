import { createRouter, createWebHistory } from "vue-router";

import notFound from "../components/notFound.vue";
/*=============== import client route ================*/
import client from "../pages/public.vue";
import home from "../pages/home.vue";
/*=============== import admin route ================*/
import admin from '../admin/pages/admin.vue';
import dashboard from '../admin/pages/dashboard.vue';

const routes = [
    {
        path : '/',
        component : client, 
        children: [
            {
                path : '/',
                component : home, 
                name: 'home'
            }
        ]
    },
    {
        path : '/admin',
        component : admin, 
        children: [
            {
                path : '/admin',
                component : dashboard, 
                name: 'dashboard'
            },
            {
                path : '/admin/add_customer',
                component : dashboard, 
                name: 'add_customer'
            }
        ]
    },
    {
        path: '/:notFound(.*)*',
        component: notFound,
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes: routes
});

export default router;
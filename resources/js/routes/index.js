import { createRouter, createWebHistory } from "vue-router";

import notFound from "../components/notFound.vue";
/*=============== import client route ================*/
import client from "../pages/public.vue";
import home from "../pages/home.vue";
/*=============== import admin route ================*/
import admin from '../admin/pages/admin.vue';
import dashboard from '../admin/pages/dashboard.vue';
import addcategory from '../admin/pages/addcategory.vue';
import category from '../admin/pages/category.vue';
import editcategory from '../admin/pages/editcategory.vue';
import addproduct from '../admin/pages/addproduct.vue';
import product from '../admin/pages/product.vue';

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
                path : '/admin/add_category',
                component : addcategory, 
                name: 'add_category'
            },
            {
                path : '/admin/show_category',
                component : category, 
                name: 'show_category'
            },
            {
                path : '/admin/edit_category/:id',
                component : editcategory, 
                name: 'edit_category'
            },
            {
                path : '/admin/add_product',
                component : addproduct, 
                name: 'add_product'
            },
            {
                path : '/admin/show_product',
                component : product, 
                name: 'show_product'
            },
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
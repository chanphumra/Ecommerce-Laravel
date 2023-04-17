import { createRouter, createWebHistory } from "vue-router";

import notFound from "../components/notFound.vue";
/*=============== import client route ================*/
import client from "../pages/public.vue";
import home from "../pages/home.vue";
import cart from "../pages/cart.vue";
import productdetail from "../pages/productdetail.vue";
import shippinginfo from "../pages/shippinginfo.vue";
import checkout from "../pages/checkout.vue";
import clientRegister from "../auth/register.vue";
import verify from "../auth/verify.vue";
/*=============== import admin route ================*/
import admin from '../admin/pages/admin.vue';
import dashboard from '../admin/pages/dashboard.vue';
import addcategory from '../admin/pages/addcategory.vue';
import category from '../admin/pages/category.vue';
import editcategory from '../admin/pages/editcategory.vue';
import addproduct from '../admin/pages/addproduct.vue';
import product from '../admin/pages/product.vue';
import editproduct from '../admin/pages/editproduct.vue';

const routes = [
    {
        path : '/',
        component : client, 
        children: [
            {
                path : '/',
                component : home, 
                name: 'home'
            },
            {
                path : '/cart',
                component : cart, 
                name: 'cart'
            },
            {
                path : '/productdetail/:id',
                component : productdetail, 
                name: 'productdetail'
            },
            {
                path : '/shippinginfo',
                component : shippinginfo, 
                name: 'shippinginfo'
            },
            {
                path : '/checkout',
                component : checkout, 
                name: 'checkout',
                props: true
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
            {
                path : '/admin/edit_product/:id',
                component : editproduct, 
                name: 'edit_product'
            },
        ]
    },
    {
        path: '/register',
        component: clientRegister,
        name: 'clientRegister'
    },
    {
        path: '/verify/:email',
        component: verify,
        name: 'verify',
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
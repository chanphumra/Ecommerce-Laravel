import { createRouter, createWebHistory } from "vue-router";

import notFound from "../components/notFound.vue";
/*=============== import client route ================*/
import client from "../pages/public.vue";
import home from "../pages/home.vue";
import cart from "../pages/cart.vue";
import clientOrder from "../pages/order.vue";
import clientOrderDetail from "../pages/orderdetail.vue";
import products from "../pages/product.vue";
import productdetail from "../pages/productdetail.vue";
import productcategory from "../pages/productcategory.vue";
import aboutusClient from "../pages/aboutus.vue";
import shippinginfo from "../pages/shippinginfo.vue";
import checkout from "../pages/checkout.vue";
import contact from "../pages/contact.vue";
import clientRegister from "../auth/register.vue";
import clientLogin from "../auth/login.vue";
import verify from "../auth/verify.vue";
import verifyresetpassword from "../auth/verifyresetpassword.vue";
import resetPassword from '../auth/resetpassword.vue';
/*=============== import admin route ================*/
import admin from '../admin/pages/admin.vue';
import adminOrder from '../admin/pages/order.vue';
import adminOrderDetail from '../admin/pages/orderdatail.vue';
import adminLogin from '../admin/auth/login.vue';
import dashboard from '../admin/pages/dashboard.vue';
import addcategory from '../admin/pages/addcategory.vue';
import category from '../admin/pages/category.vue';
import editcategory from '../admin/pages/editcategory.vue';
import addproduct from '../admin/pages/addproduct.vue';
import product from '../admin/pages/product.vue';
import editproduct from '../admin/pages/editproduct.vue';
import addslideshow from '../admin/pages/addslideshow.vue';
import slideshow from '../admin/pages/slideshow.vue';
import editslideshow from '../admin/pages/editslideshow.vue';
import siteprofile from '../admin/pages/siteprofile.vue'
import footer from '../admin/pages/footer.vue'
import addaboutus from '../admin/pages/addaboutus.vue';
import aboutus from '../admin/pages/aboutus.vue';
import editaboutus from '../admin/pages/editaboutus.vue';


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
                path : '/contact',
                component : contact, 
                name: 'contact'
            },
            {
                path : '/cart',
                component : cart, 
                name: 'cart'
            },
            {
                path : '/order',
                component : clientOrder, 
                name: 'clientorder',
                meta: {
                    adminAuth: false,
                    userAuth: true,
                }
            },
            {
                path : '/orderdetail/:id',
                component : clientOrderDetail, 
                name: 'clientorderdetail',
                meta: {
                    adminAuth: false,
                    userAuth: true,
                }
            },
            {
                path : '/product',
                component : products, 
                name: 'product'
            },
            {
                path : '/productdetail/:id',
                component : productdetail, 
                name: 'productdetail'
            },
            {
                path : '/productcategory/:id',
                component : productcategory, 
                name: 'productcategory'
            },
            {
                path : '/about_us',
                component : aboutusClient, 
                name: 'about_us'
            },
            {
                path : '/shippinginfo',
                component : shippinginfo, 
                name: 'shippinginfo',
                meta: {
                    adminAuth: false,
                    userAuth: true,
                }
            },
            {
                path : '/checkout',
                component : checkout, 
                name: 'checkout',
                props: true,
                meta: {
                    adminAuth: false,
                    userAuth: true,
                }
            }
        ],
        meta: {
            adminAuth: false,
            userAuth:false,
        }
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
                path : '/admin/orders',
                component : adminOrder, 
                name: 'orders'
            },
            {
                path : '/admin/ordersdetail/:id',
                component : adminOrderDetail, 
                name: 'orderdetail'
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
            {
                path : '/admin/add_slideshow',
                component : addslideshow, 
                name: 'add_slideshow'
            },
            {
                path : '/admin/show_slideshow',
                component : slideshow, 
                name: 'show_slideshow'
            },
            {
                path : '/admin/edit_slideshow/:id',
                component : editslideshow, 
                name: 'edit_slideshow'
            },
            {
                path : '/admin/site_profile',
                component : siteprofile, 
                name: 'site_profile'
            },
            {
                path : '/admin/footer',
                component : footer, 
                name: 'footer'
            },
            {
                path : '/admin/add_aboutus',
                component : addaboutus, 
                name: 'add_aboutus'
            },
            {
                path : '/admin/show_aboutus',
                component : aboutus, 
                name: 'show_aboutus'
            },
            {
                path : '/admin/edit_aboutus/:id',
                component : editaboutus, 
                name: 'edit_aboutus'
            },
        ],
        meta: {
            adminAuth: true,
            userAuth: false,
        }
    },
    {
        path: "/admin/login",
        component: adminLogin,
        name: adminLogin,
        meta: {
            adminAuth: false,
            userAuth: false
        }
    },
    {
        path: '/register',
        component: clientRegister,
        name: 'clientRegister',
        meta: {
            adminAuth: false,
            userAuth: false
        }
    },
    {
        path: '/login',
        component: clientLogin,
        name: 'clientLogin',
        meta: {
            adminAuth: false,
            userAuth: false
        }
    },
    {
        path: '/verify/:email',
        component: verify,
        name: 'verify',
        meta: {
            adminAuth: false,
            userAuth: false
        }
    },
    {
        path: '/verifyresetpassword/:email/:password',
        component: verifyresetpassword,
        name: 'verifyresetpassword',
        meta: {
            adminAuth: false,
            userAuth: false
        }
    },
    {
        path: '/resetpassword',
        component: resetPassword,
        name: 'resetpassword',
        meta: {
            adminAuth: false,
            userAuth: false
        }
    },
    {
        path: '/:notFound(.*)*',
        component: notFound,
        meta: {
            adminAuth: false,
            userAuth: false
        }
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes: routes
});

router.beforeEach((to, from, next) => {
    /*========== adminAuth ==========*/
    if(to.meta.adminAuth) {
        if(!sessionStorage.getItem('adminToken'))
            next('/admin/login');
        else{
            next();
        }
    }
       
    /*========== userAuth ==========*/
    else{
        sessionStorage.removeItem("adminToken");
        if(to.meta.userAuth && !sessionStorage.getItem('token') && !localStorage.getItem('token')){
            sessionStorage.removeItem("adminToken");
            next('/login');
        }
        else{
            sessionStorage.removeItem("adminToken");
            next();
        }
    }
});

export default router;
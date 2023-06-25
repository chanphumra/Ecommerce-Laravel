<script setup>
import { computed, ref } from 'vue';
import { RouterLink, useRoute } from 'vue-router';

const props = defineProps(['openSide']);
const emit = defineEmits(['closeSide']);

/*=========== get route name ===========*/
const routeName = computed(() => {
    let name = useRoute().name;
    if(name == "edit_category") name = "show_category";
    if(name == "edit_product") name = "show_product";
    if(name == "edit_slideshow") name = "show_slideshow";
    if(name == "orderdetail") name = "orders";
    return name;
});

/*=========== init menu ===========*/
const menus = [
    {
        title: 'Dashboard',
        path: '/admin',
        page_name: 'dashboard',
        icon: "pie-chart.svg",
        hasSub: false
    },
    {
        title: 'Orders',
        path: '/admin/orders',
        page_name: 'orders',
        icon: "shopping-bag.svg",
        hasSub: false
    },
    {
        title: "Customers",
        children: [
            {
                title: 'Add Customer',
                path: '/admin/add_customer',
                page_name: 'add_customer',
            },
            {
                title: 'Customer',
                path: '/admin/show_customer',
                page_name: 'show_customer',
            }
        ],
        icon: "user.svg",
        hasSub: true
    },
    {
        title: "Categories",
        children: [
            {
                title: 'Add Category',
                path: '/admin/add_category',
                page_name: 'add_category',
            },
            {
                title: 'Category',
                path: '/admin/show_category',
                page_name: 'show_category',
            }
        ],
        icon: "box.svg",
        hasSub: true
    },
    {
        title: "Products",
        children: [
            {
                title: 'Add Product',
                path: '/admin/add_product',
                page_name: 'add_product',
            },
            {
                title: 'Product',
                path: '/admin/show_product',
                page_name: 'show_product',
            }
        ],
        icon: "shopping-cart.svg",
        hasSub: true
    },
    {
        title: "Slideshow",
        children: [
            {
                title: 'Add Slideshow',
                path: '/admin/add_slideshow',
                page_name: 'add_slideshow',
            },
            {
                title: 'Slideshow',
                path: '/admin/show_slideshow',
                page_name: 'show_slideshow',
            }
        ],
        icon: "monitor.svg",
        hasSub: true
    },
    {
        title: "Site Setting",
        children: [
            {
                title: 'Site Profile',
                path: '/admin/site_profile',
                page_name: 'site_profile',
            },
            {
                title: 'Footer',
                path: '/admin/footer',
                page_name: 'footer',
            },
            
        ],
        icon: "settings.svg",
        hasSub: true
    },
    {
        title: "About us",
        children: [
            {
                title: 'Add Developer',
                path: '/admin/add_aboutus',
                page_name: 'add_aboutus',
            },
            {
                title: 'Developers',
                path: '/admin/show_aboutus',
                page_name: 'show_aboutus',
            }
        ],
        icon: "monitor.svg",
        hasSub: true
    },
];

/*=========== init open sub meu ===========*/
let open = ref([false, false, false, false, false, false, false]);

function toggleMenu(index) {
    for (let i = 0; i < open.value.length; i++) {
        if (index != i) open.value[i] = false;
    }
    open.value[index] = !open.value[index];
}

function icons(icon) {
    return "/icons/" + icon;
};

function closeSidebar () {
    if(props.openSide){
        emit('closeSide', false);
    }
}

</script>

<template>
    <div
        class="overflow-hidden p-3 flex flex-col fixed z-10 left-0 w-full lg:w-[250px] bg-white lg:border-solid lg:border-gray-300 lg:border-r h-0 lg:h-[100%] lg:overflow-y-auto overflow-x-hidden transition-all "
        :class="openSide? 'h-[90%]': 'py-0 lg:p-3 h-0'"
        >
        <div v-for="(item, index) in menus" :key="index">
            <div v-if="item.hasSub">
                <div @click="toggleMenu(index)"
                    class="flex justify-between items-center cursor-pointer py-[6px] px-4 pr-1 rounded-md lg:hover:bg-hover_menu">
                    <div class='flex items-center'>
                        <h1 class='mr-2'><img class="w-4 h-4" :src="icons(item.icon)" alt=""></h1>
                        <p :class="item.children.some(p => p.page_name == routeName) && !open[index] ? 'text-primary' : ''"
                            class="text-ph font-semibold">{{ item.title }}</p>
                    </div>
                    <i :class="open[index] ? 'rotate-90' : 'rotate-0'"
                        class="mr-1 text-sm font-extrabold fa-solid fa-angle-right"></i>
                </div>
                <div class="" v-if="open[index]">
                    <div v-for="sub in item.children">
                        <RouterLink :to="'/admin/' + sub.page_name">
                            <div class="py-[6px] px-4 pr-1 cursor-pointer rounded-md lg:hover:bg-hover_menu" @click="closeSidebar">
                                <p :class="routeName == sub.page_name ? 'text-primary' : ''"
                                    class="text-ph font-semibold pl-12">{{ sub.title }}</p>
                            </div>
                        </RouterLink>
                    </div>
                </div>
            </div>
            <div v-else>
                <RouterLink :to="'/admin/' + (item.page_name == 'dashboard' ?'' : item.page_name)">
                    <div class='flex items-center py-[6px] px-4 rounded-md lg:hover:bg-hover_menu' @click="closeSidebar">
                        <h1 class='mr-2'><img class="w-4 h-4" :src="icons(item.icon)" alt=""></h1>
                        <p :class="routeName == item.page_name ? 'text-primary' : ''" class=" text-ph font-semibold">{{
                            item.title
                        }}
                        </p>
                    </div>
                </RouterLink>
            </div>
        </div>
    </div>
</template>

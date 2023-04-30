<script setup>
import { computed, onMounted, ref } from 'vue';
import { RouterLink, useRoute, useRouter } from 'vue-router';

const routerName = computed(() => {
    return useRoute().name;
});
const router = useRouter();
let openCategory = ref(false);
let openMenu = ref(false);
let categories = ref([]);

const menu = [
    {
        title: 'Home',
        path: '/',
        page_name: 'home',
    },
    {
        title: 'Product',
        path: '/product',
        page_name: 'product',
    },
    {
        title: 'Contact Us',
        path: '/contact',
        page_name: 'contact',
    },
    {
        title: 'About Us',
        path: '/about_us',
        page_name: 'about_us',
    }
]

onMounted(async () => {
    getCategory();
});

const getCategory = async () => {
    const respone = await axios.get('/api/category');
    categories = respone.data.result;
}

function productCategory(id) {
    openCategory.value = false;
    router.push(`/productcategory/${id}`);
}

</script>

<template>
    <div class='mycontainer relative flex justify-between items-center py-1 z-[40]'>
        <div class='relative cursor-pointer group'>
            <div class="flex items-center justify-between py-2 rounded">
                <div class="flex items-center" @click="() => { openCategory = !openCategory; openMenu = false; }">
                    <i class="fas fa-box font-bold mr-2 text-base text-gray-700"></i>
                    <h4 class='text-base font-semibold'>Categories</h4>
                </div>
            </div>
            <div v-if="openCategory"
                class="absolute overflow-y-auto border max-h-[calc(100vh-200px)] md:max-h-none w-[250px] md:w-[500px] lg:w-[750px] grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-1 border-gray-300 border-1 px-2 top-[125%] left-0 z-30 shadow-sm rounded-sm bg-white scroll-smooth scrollbar-thin scrollbar-track-gray-200 scrollbar-track-rounded-xl scrollbar-thumb-[#cfcfcf] scrollbar-thumb-rounded-xl">
                <div v-for="item in categories" @click="productCategory(item.id)"
                    class="flex items-center w-full gap-2 py-2 cursor-pointer overflow-hidden">
                    <img :src="item.image" alt="" class="w-6 h-6 object-cover">
                    <p>{{ item.name }}</p>
                </div>
            </div>
        </div>

        <div class='flex px-1'>
            <div class="flex flex-col lg:flex-row gap-[20px] right-[5%] top-[112%] absolute lg:static items-start lg:items-end justify-end rounded-lg overflow-hidden bg-white"
                :class="openMenu ? 'p-5 pr-[100px] lg:p-0' : 'h-0 p-0 lg:h-auto'">
                <RouterLink v-for="item in menu" :to="item.page_name == 'home' ? '/' : '/' + item.page_name">
                    <p :class="item.page_name == routerName ? 'text-primary' : ''"
                        class="cursor-pointer text-base font-semibold text-gray-700">{{ item.title }}</p>
                </RouterLink>
            </div>
            <button @click="() => { openMenu = !openMenu; openCategory = false; }">
                <i class="fa-solid fa-bars text-base lg:hidden"></i>
            </button>
        </div>
    </div>
</template>
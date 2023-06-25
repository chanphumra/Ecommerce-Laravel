<script setup>
import { onMounted, reactive, ref } from 'vue';
import navbar from './navbar.vue';
import { RouterLink, useRouter } from 'vue-router';
import Profile from '../setting/profile.js'
const router = useRouter();

let countCart = ref(0);
let login = ref(false);
let token = ref("");
let user = ref({});
let profile = ref({});

onMounted(async () => {
    profile.value = await Profile;
    if (localStorage.getItem('token') || sessionStorage.getItem('token')) {
        login.value = true;
        token.value = localStorage.getItem('token') || sessionStorage.getItem('token');
    }
    if (login) {
        const respone = await axios.get('/api/user', {
            headers: {
                'Authorization': `Bearer ${token.value}`,
                'Accept': 'application/json'
            }
        });
        user.value = respone.data;
    }
});

const logout = () => {
    sessionStorage.removeItem('token');
    localStorage.removeItem('token');
    axios.post('/api/auth/logout', {}, {
        headers: {
            'Authorization': `Bearer ${token.value}`,
            'Accept': 'application/json'
        }
    });
    router.push('/login');
}

setInterval(() => {
    let cart = JSON.parse(localStorage.getItem('carts')) || {
        products: [],
        subtotal: 0,
        discount_price: 0,
        total: 0
    };
    countCart.value = cart.products.length;
}, 0);

function yourOrder() {
    router.push('/order');
}
</script>

<template>
    <div class="bg-white border-b border-solid border-grey-500">
        <section
            class='search mycontainer bg-[#f6f9fc] flex flex-wrap md:flex-nowrap gap-4 md:gap-8 justify-between items-center m-auto py-2 z-50'>

            <RouterLink :to="'/'">
                <div class="flex items-center gap-4">
                    <div class="logo w-[40px]">
                        <img :src="profile.image" alt="" class='w-full h-[40px] object-cover' />
                    </div>
                    <p class='text-gray-700 font-semibold text-xl md:text-2xl'>{{profile.name}}</p>
                </div>
            </RouterLink>

            <div class="order-last relative md:order-none w-full md:w-[500px] flex items-center">
                <i class='fas fa-search absolute top-[50%] left-3 translate-y-[-50%] w-4 h-4 text-gray-500'></i>
                <input type="text" name="" id="" placeholder='Search product here...'
                    class='w-full rounded-full pl-10 border-gray-300 px-3 py-2 border-solid border focus:ring-primary sm:text-sm focus:border-primary' />
            </div>

            <div class="flex items-center">
                <RouterLink :to="'/cart'">
                    <div class="relative mr-3 cursor-pointer">
                        <i
                            class='fa-solid fa-cart-shopping w-10 h-10 md:w-[46px] md:h-[46px] bg-[#f3f5f9] rounded-full text-center leading-10 md:leading-[46px]'></i>
                        <span
                            class='absolute -top-1 right-0  w-4 h-4 md:w-5 md:h-5 leading-4 md:leading-5 rounded-full text-center bg-primary text-[13px] text-white'>{{
                                countCart }}</span>
                    </div>
                </RouterLink>
                <button v-if="login" class='relative group cursor-default  w-10 h-10 md:w-[46px] md:h-[46px]'>
                    <img :src="user.image"
                        class='fa fa-user w-10 h-10 md:w-[46px] md:h-[46px] bg-[#f3f5f9] rounded-full text-center leading-10 md:leading-[46px] cursor-pointer object-cover' />
                    <div
                        class="py-5 px-4 group-focus:block hidden absolute bg-white top-[57px] right-0 shadow-sm rounded z-50 w-[300px] border border-solid border-gray-300">
                        <img :src="user.image"
                            class='fa fa-user w-10 h-10 md:w-[46px] md:h-[46px] bg-[#f3f5f9] rounded-full text-center leading-10 md:leading-[46px] cursor-pointer object-cover' />
                        <p class='text-base font-semibold truncate'>{{ user.name }}</p>
                        <div class="flex gap-2 items-center mt-5 cursor-pointer hover:underline">
                            <i class="fas fa-user text-sm text-gray-700"></i>
                            <p class='text-sm font-semibold text-gray-800'>Profile</p>
                        </div>
                        <div class="flex gap-2 items-center mt-3 cursor-pointer hover:underline" @click="yourOrder()">
                            <i class="fas fa-shopping-bag text-sm text-gray-700"></i>
                            <p class='text-sm font-semibold text-gray-800'>Orders</p>
                        </div>
                        <div class="border-t border-solid border-gray-300 mt-7">
                            <div @click="logout()"
                                class="cursor-pointer flex gap-2 items-center justify-center bg-body border-solid border border-gray-300 rounded-md py-2 mt-3">
                                <MdLogout class='text-lg font-semibold' />
                                <p class='text-sm font-semibold'>Logout</p>
                            </div>
                        </div>

                    </div>
                </button>
                <RouterLink v-else :to="'/login'">
                    <i
                        class='fa fa-user w-10 h-10 md:w-[46px] md:h-[46px] bg-[#f3f5f9] rounded-full text-center leading-10 md:leading-[46px] cursor-pointer'></i>
                </RouterLink>
            </div>
        </section>
        <navbar />
    </div>
</template>
<script setup>
import { ref } from 'vue';
import navbar from './navbar.vue';
import { RouterLink } from 'vue-router';

let countCart = ref(0);
setInterval(() => {
    let cart = JSON.parse(localStorage.getItem('carts')) || {
        products: [],
        subtotal: 0,
        discount_price: 0,
        total: 0
    };
    countCart.value = cart.products.length;
}, 0);
</script>

<template>
    <div class="bg-white border-b border-solid border-grey-500">
        <section
            class='search mycontainer bg-[#f6f9fc] flex flex-wrap md:flex-nowrap gap-4 md:gap-8 justify-between items-center m-auto py-2 z-50'>

            <RouterLink :to="'/'">
                <div class="flex items-center gap-4">
                    <div class="logo w-[40px]">
                        <img src="/icons/vue.png" alt="" class='w-full h-[40px] object-cover' />
                    </div>
                    <p class='text-gray-700 font-semibold text-xl md:text-2xl'>Bazaar Shop</p>
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
                <i
                    class='fa fa-user w-10 h-10 md:w-[46px] md:h-[46px] bg-[#f3f5f9] rounded-full text-center leading-10 md:leading-[46px] cursor-pointer'></i>

            </div>
        </section>
        <navbar />
    </div>
</template>
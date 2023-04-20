<script setup>
import { onMounted, reactive, ref } from 'vue';
import { RouterLink, useRouter } from 'vue-router';

let form = ref({
    fullname: '',
    email: '',
    phone: '',
    address1: '',
    address2: '',
    province: '',
    country: ''
})

let router = useRouter();
let cart = reactive(JSON.parse(localStorage.getItem('carts')) || { products: [], subtotal: 0, discount_price: 0, total: 0 });

onMounted(() => {
    if (cart.products.length == 0) {
        Swal.fire({
            toast: true,
            position: 'top',
            showClass: {
                icon: 'animated heartBeat delay-1s'
            },
            icon: 'warning',
            text: 'Your cart is empty!',
            showConfirmButton: false,
            timer: 1000
        });
        router.replace('/');
        return;
    }
});

function checkout() {
    router.push('checkout?data=' + JSON.stringify(form.value));
}

</script>

<template>
    <div class='mycontainer min-h-[90vh]'>
        <h1 class='text-3xl font-bold text-black_500'>Check out</h1>
        <div class="flex flex-col gap-8 md:gap-[100px] md:flex-row mt-7">
            <div class="flex-[4]">
                <h1 class='text-2xl font-bold text-black_500'>Shopping Info</h1>

                <div class='mt-5'>
                    <p class='text-base font-semibold'>Full name</p>
                    <input v-model="form.fullname" type="text" name="" id="" placeholder='Full name'
                        class='w-full rounded-md mt-1 border-gray-300 px-3 py-2 border-solid border focus:ring-primary sm:text-sm focus:border-primary' />
                </div>

                <div class='mt-5'>
                    <div class="flex flex-col md:flex-row justify-between items-center gap-5">
                        <div class='w-full'>
                            <p class='text-base font-semibold'>Email</p>
                            <input v-model="form.email" type="email" name="" id="" placeholder='Email'
                                class='w-full rounded-md mt-1 border-gray-300 px-3 py-2 border-solid border focus:ring-primary sm:text-sm focus:border-primary' />
                        </div>
                        <div class='w-full'>
                            <p class='text-base font-semibold'>Phone</p>
                            <input v-model="form.phone" type="text" name="" id="" placeholder='+1234567890'
                                class='w-full rounded-md mt-1 border-gray-300 px-3 py-2 border-solid border focus:ring-primary sm:text-sm focus:border-primary' />
                        </div>
                    </div>
                </div>

                <div class='mt-5'>
                    <p class='text-base font-semibold'>Address line 1</p>
                    <input v-model="form.address1" type="text" name="" id="" placeholder='Address line 1'
                        class='w-full rounded-md mt-1 border-gray-300 px-3 py-2 border-solid border focus:ring-primary sm:text-sm focus:border-primary' />
                </div>

                <div class='mt-5'>
                    <p class='text-base font-semibold'>Address line 2</p>
                    <input v-model="form.address2" type="text" name="" id="" placeholder='Address line 2'
                        class='w-full rounded-md mt-1 border-gray-300 px-3 py-2 border-solid border focus:ring-primary sm:text-sm focus:border-primary' />
                </div>

                <div class='mt-5'>
                    <div class="flex flex-col md:flex-row justify-between items-center gap-5">
                        <div class='w-full'>
                            <p class='text-base font-semibold'>Province</p>
                            <input v-model="form.province" type="text" name="" id="" placeholder='Province'
                                class='w-full rounded-md mt-1 border-gray-300 px-3 py-2 border-solid border focus:ring-primary sm:text-sm focus:border-primary' />
                        </div>
                        <div class='w-full'>
                            <p class='text-base font-semibold'>Country</p>
                            <input v-model="form.country" type="text" name="" id="" placeholder='Country'
                                class='w-full rounded-md mt-1 border-gray-300 px-3 py-2 border-solid border focus:ring-primary sm:text-sm focus:border-primary' />
                        </div>
                    </div>
                </div>
                <button @click="checkout()"
                    class='hidden md:block px-7 py-2 mt-8 bg-primary text-white rounded-lg text-base cursor-pointer'>Next
                    step</button>
            </div>

            <div class="flex-[2]">
                <div class="border-solid border border-gray-300 rounded-lg p-4 bg-white mt-2 md:mt-0">
                    <div class="flex justify-between items-center mb-4">
                        <h1 class='text-2xl font-bold text-black_500'>Summary</h1>
                        <RouterLink :to="'/cart'"><span
                                class='text-sm font-semibold text-primary cursor-pointer hover:underline'>Edit cart</span>
                        </RouterLink>
                    </div>

                    <div class="flex flex-col gap-2 pb-5 mb-5 border-dashed border-b border-gray-300">

                        <div v-for="item in cart.products" class="flex justify-between items-center mb-2">
                            <div class='flex items-center gap-2'>
                                <img :src="item.image" alt="" class='w-[40px] h-[40px] object-cover rounded-md' />
                                <p class='w-[170px] truncate'>{{ item.name }}</p>
                            </div>
                            <span class='text-gray-600 text-sm font-semibold'>x{{ item.qty }}</span>
                            <span class='text-lg text-gray-800'>${{ item.sale_price }}</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mt-1">
                        <p class='text-base text-gray-900'>Items subtotal:</p>
                        <span class='text-lg text-gray-800'>${{ cart.subtotal }}</span>
                    </div>
                    <div class="flex justify-between items-center mt-1">
                        <p class='text-base text-gray-900'>Discount:</p>
                        <span class='text-lg text-red-500'>-${{ cart.discount_price.toFixed(2) }}</span>
                    </div>
                    <div class="flex justify-between items-center mt-1">
                        <p class='text-base text-gray-900'>Tax:</p>
                        <span class='text-lg text-gray-800'>$0</span>
                    </div>
                    <div class="flex justify-between items-center mt-1">
                        <p class='text-base text-gray-900'>Subtotal:</p>
                        <span class='text-lg text-gray-800'>${{ cart.subtotal }}</span>
                    </div>
                    <div class="flex justify-between items-center mt-4 border-t pt-4 border-gray-300 border-dashed">
                        <p class='text-xl text-gray-800 font-semibold'>Total:</p>
                        <span class='text-xl text-gray-800 font-semibold'>${{ cart.total }}</span>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button @click="checkout()"
                        class='md:hidden px-7 py-2 mt-8 bg-primary text-white rounded-lg text-base cursor-pointer'>Next
                        step</button>
                </div>
            </div>
        </div>
    </div>
</template>
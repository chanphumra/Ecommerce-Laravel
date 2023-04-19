<script setup>
import { reactive } from 'vue';
import { RouterLink, useRouter } from 'vue-router';

const router = useRouter();
const header = ['PRODUCTS', 'PRICE', 'QUANTITY', 'TOTAL'];
let cart = reactive(JSON.parse(localStorage.getItem('carts')) || { products: [], subtotal: 0, discount_price: 0, total: 0 });

function minus(index) {
    const product = cart.products[index];
    if (product.qty == 1) return
    product.qty = product.qty - 1;
    cart.subtotal -= product.sale_price;
    cart.discount_price -= product.sale_price * product.discount / 100;
    cart.total = (cart.subtotal - cart.discount_price);
    localStorage.setItem('carts', JSON.stringify(cart));
}

function plus(index) {
    const product = cart.products[index];
    product.qty = product.qty + 1;
    cart.subtotal += product.sale_price;
    cart.discount_price += product.sale_price * product.discount / 100;
    cart.total = (cart.subtotal - cart.discount_price);
    localStorage.setItem('carts', JSON.stringify(cart));
}

function remove(index) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to remove this cart!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        confirmButtonColor: '#42b883',
        cancelButtonColor: '#d33',
        reverseButtons: true
    }).then(async (result) => {
        if (result.isConfirmed) {
            const product = cart.products[index];
            cart.subtotal -= product.qty * product.sale_price;
            cart.discount_price -= product.qty * product.sale_price * product.discount / 100;
            cart.total = (cart.subtotal - cart.discount_price);
            cart.products.splice(index, 1);
            localStorage.setItem('carts', JSON.stringify(cart));
            Swal.fire({
                toast: true,
                position: 'top',
                showClass: {
                    icon: 'animated heartBeat delay-1s'
                },
                icon: 'success',
                text: 'Cart has been remove!',
                showConfirmButton: false,
                timer: 1000
            });
        }
    })
}

function shippingInfo() {
    if (localStorage.getItem('token') || sessionStorage.getItem('token')) {
        router.push('/shippinginfo');
    }
    else Swal.fire({
        toast: true,
        position: 'top',
        showClass: {
            icon: 'animated heartBeat delay-1s'
        },
        icon: 'warning',
        text: 'You need have an account',
        showConfirmButton: false,
        timer: 1000
    });
}

</script>

<template>
    <div v-if="cart.products.length > 0" class='mycontainer min-h-[90vh]'>
        <h1 class='text-3xl font-bold text-black_500'>Cart</h1>
        <div class="flex flex-col gap-10 md:flex-row mt-7">
            <div class="flex-[4]">
                <div
                    class="w-full pb-2 overflow-x-auto overflow-y-none scroll-smooth scrollbar-thin scrollbar-track-gray-200 scrollbar-track-rounded-xl scrollbar-thumb-primary scrollbar-thumb-rounded-xl ">
                    <table class='w-[800px] md:w-full'>
                        <thead class='border-solid border-b border-t border-gray-300'>
                            <tr>
                                <th v-for="(item, index) in header" :class="index == 0 ? 'w-[300px]' : ''"
                                    class=" text-start text-gray-600 text-sm py-2 px-3">{{ item }}</th>
                                <th class='text-end text-gray-600 text-sm py-2 px-3 pr-4 w-3'></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in cart.products" :key="index"
                                class='group relative border-solid border-b border-gray-300'>
                                <td class='py-2 px-3 flex items-center gap-1'>
                                    <img :src="item.image" alt=""
                                        class='w-[45px] h-[45px] border-solid border border-gray-300 rounded-md object-cover' />
                                    <p class='w-[300px] text-ph font-semibold truncate text-primary py-2 px-3'>
                                        {{ item.name }}</p>
                                </td>
                                <td class='text-ph font-semibold text-gray-700 py-2 px-3'>${{ item.sale_price }}</td>
                                <td class='text-ph font-semibold text-gray-700 py-2 px-3 items-center'>
                                    <div className='flex items-center gap-3'>
                                        <i @click="minus(index)"
                                            class="fas fa-minus w-3 h-3 cursor-pointer text-gray-700 text-[12px]"></i>
                                        <p class="text-ph">{{ item.qty }}</p>
                                        <i @click="plus(index)"
                                            class="fas fa-plus w-3 h-3 cursor-pointer text-gray-700 text-[12px]"></i>
                                    </div>
                                </td>
                                <td class='text-ph font-semibold text-gray-700 py-2 px-3'>${{ item.sale_price * item.qty }}
                                </td>
                                <td>
                                    <i @click="remove(index)"
                                        class="fas fa-trash w-3 h-3 cursor-pointer text-gray-700 text-[12px] hover:text-black"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex items-center justify-between mt-2 border-b border-solid border-gray-300 pb-4">
                    <p class='text-base text-gray-800 font-semibold'>Items subtotal:</p>
                    <span class='text-lg text-gray-800 font-semibold'>${{ cart.subtotal }}</span>
                </div>
            </div>
            <div class="flex-[2]">
                <div class="border-solid border border-gray-300 rounded-lg p-4 bg-white mt-2 md:mt-0">
                    <h1 class='text-2xl font-bold text-black_500'>Summary</h1>
                    <div class="flex justify-between items-center mt-4">
                        <p class='text-base text-gray-900'>Items subtotal:</p>
                        <span class='text-lg text-gray-800'>${{ cart.subtotal }}</span>
                    </div>
                    <div class="flex justify-between items-center mt-4">
                        <p class='text-base text-gray-900'>Discount:</p>
                        <span class='text-lg text-red-500'>-${{ (cart.discount_price).toFixed(2) }}</span>
                    </div>
                    <div class="flex justify-between items-center mt-4">
                        <p class='text-base text-gray-900'>Tax:</p>
                        <span class='text-lg text-gray-800'>$0</span>
                    </div>
                    <div class="flex justify-between items-center mt-4">
                        <p class='text-base text-gray-900'>Subtotal:</p>
                        <span class='text-lg text-gray-800'>${{ cart.subtotal }}</span>
                    </div>
                    <div class="flex justify-between items-center mt-4 border-t pt-4 border-gray-300 border-dashed">
                        <p class='text-xl text-gray-800 font-semibold'>Total:</p>
                        <span class='text-xl text-gray-800 font-semibold'>${{ cart.total }}</span>
                    </div>

                    <button @click="shippingInfo()"
                        class='w-full py-2 mt-8 bg-primary text-white rounded-lg text-base cursor-pointer'>Proceed to
                        checkout</button>
                </div>
            </div>
        </div>
    </div>
    <div v-else class='mycontainer h-[80vh] flex justify-center items-center flex-col bg-body'>
        <img :src="'/icons/empty.png'" alt="" class='w-[300px] h-[300px]' />
        <h1 class='text-lg md:text-4xl font-semibold mt-10 '>Your Cart is <span class='text-primary'>Empty!</span>
        </h1>
        <RouterLink to='/'>
            <button class='text-lg md:text-xl font-semibold text-white bg-primary px-[50px] py-2 rounded-full mt-10'>Back to
                shop</button>
        </RouterLink>
    </div>
</template>
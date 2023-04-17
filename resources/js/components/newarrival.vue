<script setup>
import { onMounted, reactive, ref } from 'vue';
import { RouterLink } from 'vue-router';

let more = ref(false);
let openId = ref(0);
let products = ref([]);
let cart = reactive(JSON.parse(localStorage.getItem('carts')) || {
    products: [],
    subtotal: 0,
    discount_price: 0,
    total: 0
});

onMounted(async () => {
    getProduct();
});

const getProduct = async () => {
    const respone = await axios.get('/api/product');
    products.value = respone.data.result.reverse();
}

function addToCart(item) {
    const product = {
        id: item.id,
        name: item.name,
        sale_price: new Number(item.sale_price),
        discount: new Number(item.discount),
        qty: new Number(1),
        image: item.image1
    };

    const index = cart.products.findIndex(p => p.id == product.id);
    if (index >= 0) { // exist in cart
        const existProduct = cart.products[index];
        existProduct.qty += product.qty;
        cart.subtotal += product.sale_price * product.qty;
        cart.discount_price += product.sale_price * product.qty * product.discount / 100;
        cart.total = (cart.subtotal - cart.discount_price);
    } else {
        cart.products.push(product);
        cart.subtotal += product.sale_price * product.qty;
        cart.discount_price += product.sale_price * product.qty * product.discount / 100;
        cart.total = (cart.subtotal - cart.discount_price);
    }
    localStorage.setItem('carts', JSON.stringify(cart));
    Swal.fire({
        toast: true,
        position: 'top',
        showClass: {
            icon: 'animated heartBeat delay-1s'
        },
        icon: 'success',
        text: 'One Product add to cart',
        showConfirmButton: false,
        timer: 1000
    });
}

function Image(image) {
    return image;
}

</script>


<template>
    <div class="mt-10">
        <div class="flex justify-between items-end">
            <div class="flex items-center">
                <img :src="'/icons/newarrivals.png'" alt="" class='w-8 h-8 mr-1' />
                <span class='text-2xl font-[700] text-gray-800 capitalize'>New Arrivals</span>
            </div>
            <p @click="more = !more" class="text-sm hover:underline cursor-pointer text-primary">{{ more ? 'See less' :
                'See more' }}</p>
        </div>
        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-9 mt-5">
            <div v-for="item in products">
                <div class="bg-white cursor-pointer p-3 relative rounded-[8px] shadow-[0_1px_3px_rgb(3,0,71,0.09)] group">
                    <span v-if="item.discount > 0"
                        class="bg-primary absolute top-4 left-3 text-white rounded-[10px] text-[0.65rem] px-2 p-1">{{
                            item.discount }}%Off</span>
                    <div class="">
                        <RouterLink :to="'/productdetail/' + item.id">
                            <img :src="Image(item.image1)" alt='' class='w-full h-[300px] object-cover mt-1' />
                        </RouterLink>
                        <div
                            class="absolute top-0 right-0 opacity-0 transition duration-100 m-2 group-hover:opacity-100 flex justify-center items-center flex-col text-gray-400">
                            <i @click="openId = item.id"
                                class="fa-regular fa-eye p-3 transition duration-200 hover:bg-gray-100 rounded-full"></i>
                            <i class='fa-regular fa-heart p-3 transition duration-200 hover:bg-gray-100 rounded-full'></i>
                        </div>
                    </div>
                    <div class="p-1">
                        <h3 class='text-md mb-2 text-gray-500 cursor-pointer truncate'>{{ item.name }}</h3>

                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2 text-sm">
                                <h4 class='text-primary text-base font-semibold'>${{ item.sale_price - (item.sale_price
                                    * item.discount / 100) }}</h4>
                                <h4 v-if="item.discount > 0" class='text-gray-500 del line-through'>${{ item.sale_price }}
                                </h4>
                            </div>
                            <button type='button'
                                class='text w-[30px] p-[2px] border border-solid border-primary rounded  cursor-pointer transition duration-500 hover:bg-gray-50'>
                                <i @click="addToCart(item)" class='fa fa-plus w-full text-black text-sm'></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-center transition-all duration-700 fixed top-0 left-0 z-50 overflow-hidden"
                    :class="openId == item.id ? 'w-full h-full opacity-100 block bg-opacity-5 bg-black' : 'w-full h-0'">
                    <div class='relative bg-white rounded w-[55rem] h-[30rem] p-5 flex justify-center items-center gap-5'>
                        <i @click="openId = 0"
                            class='absolute top-3 right-3 fa-solid fa-x text-sm font-extrabold cursor-pointer bg-[#F6F9FC] h-10 w-10 leading-10 text-center rounded-full'></i>
                        <div class="w-[50%] h-[95%]">
                            <img :src="Image(item.image1)" alt='' class='w-full h-full object-cover' />
                        </div>
                        <div class="w-[50%] h-[95%] flex flex-col justify-center">
                            <h2 class='text-2xl font-semibold'>{{ item.name }}</h2>
                            <p class='uppercase font-semibold text-gray-500 text-sm my-3'>Category: {{ item.category.name }}
                            </p>
                            <h2 class='uppercase font-semibold text-primary text-2xl my-3'>${{ item.sale_price -
                                (item.sale_price * item.discount / 100) }}</h2>

                            <p class='text-gray-500 text-sm my-3 border-b border-solid border-gray-300 pb-5'>
                                {{ item.description }}</p>
                            <button @click="addToCart(item)"
                                class='capitalize text-white bg-primary py-2 rounded shadow-[0px_4px_16px_rgb(43,52,69,0.10)]'>Add
                                to cart</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div></template>
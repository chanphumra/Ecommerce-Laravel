<script setup>
import { onMounted, ref, reactive } from 'vue';
import { useRoute } from 'vue-router';

let route = useRoute();
let product = ref();
let image = ref("");
let qty = ref(1);
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
    const respone = await axios.get('/api/product/' + route.params.id);
    if (respone.status == 200) product.value = respone.data.result;
}

function addToCart() {
    const productItem = {
        id: product.value.id,
        name: product.value.name,
        sale_price: new Number(product.value.sale_price),
        discount: new Number(product.value.discount),
        qty: new Number(qty.value),
        image: product.value.image1
    };

    const index = cart.products.findIndex(p => p.id == productItem.id);
    if (index >= 0) { // exist in cart
        const existProduct = cart.products[index];
        existProduct.qty += productItem.qty;
        cart.subtotal += productItem.sale_price * productItem.qty;
        cart.discount_price += productItem.sale_price * productItem.qty * productItem.discount / 100;
        cart.total = (cart.subtotal - cart.discount_price);
    } else {
        cart.products.push(productItem);
        cart.subtotal += productItem.sale_price * productItem.qty;
        cart.discount_price += productItem.sale_price * productItem.qty * productItem.discount / 100;
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

</script>

<template>
    <p class="mycontainer py-0 mt-4 text-xs text-primary"><RouterLink :to="'/productcategory/' + product.category.id"><span class="hover:underline font-bold cursor-pointer">{{ product.category.name }}</span></RouterLink> <span class="text-gray-700">></span> <span class="font-semibold">{{product.name}}</span></p>
    <div class='mycontainer flex flex-col lg:flex-row gap-5 lg:gap-0'>
        <div class="flex flex-col gap-5 w-full">
            <div class="flex flex-col lg:flex-row gap-5 w-full">
                <div class='flex flex-row lg:flex-col gap-5'>
                    <img @click="image = product.image1" :src="product.image1" alt=""
                        class='w-[80px] h-[80px] object-cover rounded-lg border border-solid border-gray-300 cursor-pointer'
                        :class="image == product.image1 || image == '' ? 'border-primary' : ''" />
                    <img @click="image = product.image2" :src="product.image2" alt=""
                        class='w-[80px] h-[80px] object-cover rounded-lg border border-solid border-gray-300 cursor-pointer'
                        :class="image == product.image2 ? 'border-primary' : ''" />
                    <img @click="image = product.image3" :src="product.image3" alt=""
                        class='w-[80px] h-[80px] object-cover rounded-lg border border-solid border-gray-300 cursor-pointer'
                        :class="image == product.image3 ? 'border-primary' : ''" />
                </div>
                <img :src="image == '' ? product.image1 : image" alt=""
                    class='w-full lg:w-[450px] h-[450px] object-cover rounded-lg border border-solid border-gray-300 cursor-pointer' />
            </div>
            <div class="flex justify-between items-center w-full lg:w-[550px] gap-5">
                <button
                    class='flex justify-center items-center gap-2 w-full text-sm font-semibold rounded-full py-3 text-primary hover:text-white bg-transparent hover:bg-primary border border-solid border-primary'>
                    <i class="fas fa-heart"></i>
                    <p>Add to wishlist</p>
                </button>
                <button @click="addToCart()" class='flex justify-center items-center gap-2 w-full text-sm
                            font-semibold bg-primary text-white rounded-full border border-solid border-primary py-3
                            hover:opacity-95'>
                    <i class="fas fa-shopping-cart"></i>
                    <p>Add to cart</p>
                </button>
            </div>
        </div>
        <div class='w-full flex flex-col gap-5'>
            <h1 class='w-full text-xl lg:text-3xl font-semibold text-ellipsis text-black_500'>{{product.name}}</h1>
            <div class="flex items-end gap-3">
                <p class='text-4xl font-semibold text-gray-800'>${{product.sale_price - (product.sale_price *
                    product.discount / 100)}}</p>
                <p v-if="product.discount > 0" class='text-3xl line-through font-semibold text-gray-600'>${{product.sale_price}}</p>
                <p v-if="product.discount > 0" class='text-2xl font-semibold text-primary'>{{product.discount}} %Off</p>
            </div>
            <button class="text-sm bg-primary text-white py-[2px] w-[90px]
                        rounded-xl">{{product.qty > 0 ? 'In stock' : 'Out Stock'}}</button>
            <p class='text-gray-600'>{{product.description}}</p>

            <div class="flex flex-col gap-5">
                <p class='text-base text-gray-700'>Quantity :</p>
                <div class="flex gap-5 items-center">
                    <div @click="qty = qty == 1 ? qty : qty - 1" class="group text-center p-2 border
                            border-solid border-gray-300 rounded-lg cursor-pointer hover:bg-primary hover:text-white">
                        <i class='fas fa-minus w-4 h-4 text-gray-700 group-hover:text-white'></i>
                    </div>
                    <p class='text-base text-gray-700'>{{qty}}</p>
                    <div @click="qty = qty + 1" class="group text-center p-2 border border-solid border-gray-300
                            rounded-lg cursor-pointer hover:bg-primary hover:text-white">
                        <i class='fas fa-plus w-4 h-4 text-gray-700 group-hover:text-white'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
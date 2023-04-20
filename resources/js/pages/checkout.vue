<script setup>
import { onMounted, reactive, ref } from 'vue';
import { RouterLink, useRoute, useRouter } from 'vue-router';

let route = useRoute();
let router = useRouter();
let data = JSON.parse(route.query.data) || [];
let user = ref({});
let token = ref("");
let thankyou = ref(false);
let cart = reactive(JSON.parse(localStorage.getItem('carts')) || { products: [], subtotal: 0, discount_price: 0, total: 0 });

let paypal = ref();

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
    const script = document.createElement("script");
    script.src =
        "https://www.paypal.com/sdk/js?client-id=AQWkrZ-K_tJ6LOb4smFBfS69sKsndyWpfnEQpQ_WPvdSQ7wkm9uut6dXk7PpOITDJ_n0BVrg2gXLea3c&enable-funding=venmo&currency=USD";
    script.addEventListener("load", loadPaypal);
    document.body.appendChild(script);

    getUser();
});

const loadPaypal = () => {
    window.paypal
        .Buttons({
            createOrder: (data, actions) => {
                return actions.order.create({
                    purchase_units: [
                        {
                            amount: {
                                currency_code: "USD",
                                value: cart.total
                            }
                        }
                    ]
                });
            },
            onApprove: async (data, actions) => {
                const order = await actions.order.capture();
                storeOder();
                clearStock();
                thankyou.value = true;
                Swal.fire({
                    toast: true,
                    position: 'top',
                    showClass: {
                        icon: 'animated heartBeat delay-1s'
                    },
                    icon: 'success',
                    text: 'Thank you for your order',
                    showConfirmButton: false,
                    timer: 1000
                });
            },
            onError: err => {
                console.log(err);
            }
        })
        .render(paypal.value);
}

const getUser = async () => {
    token.value = localStorage.getItem('token') || sessionStorage.getItem('token');
    const respone = await axios.get('/api/user', {
        headers: {
            'Authorization': `Bearer ${token.value}`,
            'Accept': 'application/json'
        }
    });
    user.value = respone.data;
}

const storeOder = async () => {
    /*========== insert to table order ===========*/
    const formData = new FormData();
    formData.append('user_id', user.value.id);
    formData.append('payment_method', "paypal");
    formData.append('fullname', data.fullname);
    formData.append('email', data.email);
    formData.append('phone', data.phone);
    formData.append('address', data.address1);
    formData.append('status', "padding");
    formData.append('total', cart.total);
    const respone = await axios.post('/api/order/store', formData);

    /*========== insert to table order_details ===========*/
    for (let index = 0; index < cart.products.length; index++) {
        const product = cart.products[index];
        const formdata = new FormData();
        formdata.append('o_id', respone.data.insert_id);
        formdata.append('p_id', product.id);
        formdata.append('qty', product.qty);
        axios.post('/api/order/storeDetail', formdata).then(res => { }).catch(err => { console.log(err); });
    }

    /*========== sendMessage Telegram ===========*/
    sendMessageTelegram(respone.data.insert_id);
}

const clearStock = async () => {
    for (let index = 0; index < cart.products.length; index++) {
        const product = cart.products[index];
        const formData = new FormData();
        formData.append('qty', product.qty);
        formData.append('_method', 'PUT');
        axios.post(`/api/product/clearStock/${product.id}`, formData, {
            headers: {
                'Authorization': `Bearer ${token.value}`,
                'Accept': 'application/json'
            }
        }).then(res => { console.log(res); }).catch(err => { console.log(err) });
    }
    localStorage.removeItem('carts');
}

function sendMessageTelegram(order_id) {
    const TELEGRAM_BOT_TOKEN = "6147139821:AAFIk9fp-ePPaE9oAhYLXpRnTRsL8_khPIk";
    const TELEGRAM_GROUP_ID = "-996407006";

    let text = `<b>Summary Order #${order_id}</b>` + '\n\n';
    for (let index = 0; index < cart.products.length; index++) {
        const product = cart.products[index];
        text += (index + 1) + ". " + product.name + "      x" + product.qty + "      $" + product.sale_price + "\n";
    }
    text += "-----------------------------------------" + "\n";
    text += "subtotal:              $" + cart.subtotal + "\n";
    text += "discount:             $" + cart.discount_price.toFixed(2) + "\n";
    text += "total:                     $" + cart.total + "\n";
    const data = {
        chat_id: TELEGRAM_GROUP_ID,
        parse_mode: "HTML",
        text: text
    };
    axios.post(`https://api.telegram.org/bot${TELEGRAM_BOT_TOKEN}/sendMessage`, data).then(res => {
        console.log(res);
    }).catch(err => {
        console.log(err);
    });
}

</script>

<template>
    <div v-if="thankyou" class="mycontainer min-h-[90vh] flex flex-col gap-3 justify-center items-center">
        <h1 class="font-bold text-xl lg:text-4xl">Thank for your order</h1>
        <RouterLink :to="'/'"><button class="rounded px-10 py-3 bg-primary text-white">Back to shop</button></RouterLink>
    </div>
    <div v-else class='mycontainer min-h-[90vh]'>
        <h1 class='text-3xl font-bold text-black_500'>Check out</h1>
        <div class="flex flex-col gap-8 md:gap-[100px] md:flex-row mt-7">
            <div class="flex-[4]">
                <h1 class='text-2xl font-bold text-black_500 mb-8'>Shopping Details</h1>
                <div class="mt-5 flex">
                    <div class='flex gap-2 items-center'>
                        <FiUser />
                        <p class='text-base font-semibold w-[300px]'>Name</p>
                    </div>
                    <span class='mr-10 font-bold'>:</span>
                    <span class='text-base font-semibold'>{{ data.fullname }}</span>
                </div>

                <div class="mt-5 flex">
                    <div class='flex gap-2 items-center'>
                        <MdOutlineEmail />
                        <p class='text-base font-semibold w-[300px]'>Email</p>
                    </div>
                    <span class='mr-10 font-bold'>:</span>
                    <span class='text-base font-semibold'>{{ data.email }}</span>
                </div>

                <div class="mt-5 flex">
                    <div class='flex gap-2 items-center'>
                        <FiPhone />
                        <p class='text-base font-semibold w-[300px]'>Phone</p>
                    </div>
                    <span class='mr-10 font-bold'>:</span>
                    <span class='text-base font-semibold'>{{ data.phone }}</span>
                </div>

                <div class="mt-5 flex">
                    <div class='flex gap-2 items-center'>
                        <GrLocation />
                        <p class='text-base font-semibold w-[300px]'>Address 1</p>
                    </div>
                    <span class='mr-10 font-bold'>:</span>
                    <span class='text-base font-semibold'>{{ data.address1 }}</span>
                </div>

                <div class="mt-5 flex">
                    <div class='flex gap-2 items-center'>
                        <GrLocation />
                        <p class='text-base font-semibold w-[300px]'>Address 2</p>
                    </div>
                    <span class='mr-10 font-bold'>:</span>
                    <span class='text-base font-semibold'>{{ data.address2 }}</span>
                </div>

                <div class="mt-5 flex">
                    <div class='flex gap-2 items-center'>
                        <BiHome />
                        <p class='text-base font-semibold w-[300px]'>Province</p>
                    </div>
                    <span class='mr-10 font-bold'>:</span>
                    <span class='text-base font-semibold'>{{ data.province }}</span>
                </div>

                <div class="mt-5 flex">
                    <div class='flex gap-2 items-center'>
                        <BiHome />
                        <p class='text-base font-semibold w-[300px]'>Country</p>
                    </div>
                    <span class='mr-10 font-bold'>:</span>
                    <span class='text-base font-semibold'>{{ data.country }}</span>
                </div>
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
                    <div ref="paypal" class="mt-4"></div>
                </div>
            </div>
        </div>
    </div>
</template>
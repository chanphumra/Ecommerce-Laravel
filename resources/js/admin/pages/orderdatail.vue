<script setup>
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();
const header = ['PRODUCT NAME', 'PRICE', 'QUANTITY', 'TOTAL'];
let orderId = route.params.id;
let subtotal = ref(0);
let discount = ref(0);
let orderdetail = ref([]);

onMounted(async () => {
    getOrderDetail();
});

const getOrderDetail = async () => {
    const respone = await axios.get(`/api/order/${orderId}`);
    orderdetail.value = respone.data.result;
    for (let index = 0; index < orderdetail.value.details.length; index++) {
        const product = orderdetail.value.details[index].products;
        subtotal.value += new Number(new Number(orderdetail.value.details[index].qty) * new Number(product.sale_price));
        discount.value += orderdetail.value.details[index].qty * (product.sale_price * product.discount / 100);
    }
}

</script>

<template>
    <div class='lg:py-7 lg:px-10 p-5'>
        <div>
            <h1 class='text-3xl font-bold text-black_500'>Order #{{ orderId }}</h1>
            <h1 class='text-base text-gray-600 mt-1'>Customer ID :
                <span class='text-primary font-semibold cursor-pointer hover:underline'>{{ orderdetail.order.user_id
                }}</span>
            </h1>
        </div>
        <div class="flex flex-col gap-8 md:flex-row mt-7">
            <div class="flex-[4]">
                <div
                    class="w-full pb-2 overflow-x-auto overflow-y-none scroll-smooth scrollbar-thin scrollbar-track-gray-200 scrollbar-track-rounded-xl scrollbar-thumb-current scrollbar-thumb-rounded-xl ">
                    <table class='w-[800px] md:w-full'>
                        <thead class='border-solid border-b border-t border-gray-300'>
                            <tr>
                                <th v-for="(item, index) in header" :class="index == 0 ? 'w-[300px]' : ''"
                                    class="text-start text-gray-600 text-sm py-2 px-3">{{ item }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in orderdetail.details"
                                class='group relative border-solid border-b border-gray-300'>
                                <td class='py-2 px-3 flex items-center gap-1'>
                                    <img :src="item.products.image1" alt=""
                                        class='w-[45px] h-[45px] border-solid border border-gray-300 rounded-md object-cover' />
                                    <p class='w-[230px] text-ph font-semibold truncate text-primary py-2 px-3'>
                                        {{ item.products.name }}
                                    </p>
                                </td>
                                <td class='text-ph font-semibold text-gray-700 py-2 px-3'>${{ item.products.sale_price }}
                                </td>
                                <td class='text-ph font-semibold text-gray-700 py-2 px-3'>
                                    <p>{{ item.qty }}</p>
                                </td>
                                <td class='text-ph font-semibold text-gray-700 py-2 px-3'>
                                    {{ item.products.sale_price * item.qty }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex items-center justify-between mt-2 border-b border-solid border-gray-300 pb-4">
                    <p class='text-base text-gray-800 font-semibold'>Items subtotal:</p>
                    <span class='text-lg text-gray-800 font-semibold'>${{ subtotal }}</span>
                </div>
            </div>
            <div class="flex-[2]">
                <div class="border-solid border border-gray-300 rounded-lg p-4 bg-white mt-2 md:mt-0">
                    <h1 class='text-xl font-semibold text-gray-800'>Summary</h1>
                    <div class="flex justify-between items-center mt-4">
                        <p class='text-base text-gray-900'>Items subtotal:</p>
                        <span class='text-lg text-gray-800'>${{ subtotal }}</span>
                    </div>
                    <div class="flex justify-between items-center mt-4">
                        <p class='text-base text-gray-900'>Discount:</p>
                        <span class='text-lg text-red-500'>-${{ discount }}</span>
                    </div>
                    <div class="flex justify-between items-center mt-4">
                        <p class='text-base text-gray-900'>Tax:</p>
                        <span class='text-lg text-gray-800'>$0</span>
                    </div>
                    <div class="flex justify-between items-center mt-4">
                        <p class='text-base text-gray-900'>Subtotal:</p>
                        <span class='text-lg text-gray-800'>${{ subtotal }}</span>
                    </div>
                    <div class="flex justify-between items-center mt-4 border-t pt-4 border-gray-300 border-dashed">
                        <p class='text-xl text-gray-800 font-semibold'>Total:</p>
                        <span class='text-xl text-gray-800 font-semibold'>${{ orderdetail.order.total }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
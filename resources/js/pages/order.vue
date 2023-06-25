<script setup>
import { computed } from '@vue/reactivity';
import { onMounted, ref } from 'vue';
import { RouterLink } from 'vue-router';

const header = ['ORDER', 'TOTAL', 'CUSTOMER', 'PAYMENT METHOD', 'DATE'];
const ITEM_PER_PAGE = 5;
let page = ref(0);
let activePage = ref(1);
let orders = ref([]);
let token = ref("");
let user = ref({});

onMounted(async () => {
    if (localStorage.getItem('token') || sessionStorage.getItem('token')) {
        token.value = localStorage.getItem('token') || sessionStorage.getItem('token');
        const respone = await axios.get('/api/user', {
            headers: {
                'Authorization': `Bearer ${token.value}`,
                'Accept': 'application/json'
            }
        });
        user.value = respone.data;
    }
    getOrder();
});

let orderByPage = computed(() => {
    let order = [];
    for (let index = 0; index < orders.value.length; index++) {
        if (index >= (activePage.value - 1) * ITEM_PER_PAGE && index < activePage.value * ITEM_PER_PAGE)
            order.push(orders.value[index]);
    }
    return order;
});

const getOrder = async () => {
    console.log(user.value);
    const respone = await axios.get('/api/order');
    orders.value = respone.data.result.filter(order => order.user_id == user.value.id).reverse();
    page = Math.ceil(orders.value.length / ITEM_PER_PAGE);
}

function setIcon(icon) {
    return "/icons/" + icon;
}

</script>
<template>
    <div v-if="orders.length > 0" class='mycontainer min-h-[90vh]'>
        <h1 class='text-3xl font-bold text-black_500'>Your Orders</h1>
        <div class='mt-5'>
            <div class='bg-white relative border-solid border-t border-b border-gray-200 border-t-gray-300 px-5 lg:px-10'>
                <div
                    class="w-full pb-2 overflow-x-auto overflow-y-none scroll-smooth scrollbar-thin scrollbar-track-gray-200 scrollbar-track-rounded-xl scrollbar-thumb-current scrollbar-thumb-rounded-xl ">
                    <table class='w-[800px] md:w-full'>
                        <thead class='border-solid border-b border-gray-300'>
                            <tr>
                                <th class='text-start text-gray-600 text-md w-[50px] py-2 px-3'>
                                    <input type="checkbox" name="" id=""
                                        class='w-4 h-4 border-solid border border-gray-500 rounded-[4px] checked:rounded-[4px]' />
                                </th>
                                <th v-for="item in header" class='text-start text-gray-600 text-sm py-2 px-3'>{{ item }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in orderByPage" class='group relative border-solid border-b border-gray-300'>
                                <td class='text-sm text-gray-700 py-2 px-3'>
                                    <input type="checkbox" name="" id=""
                                        class='w-4 h-4 border-solid border border-gray-500 rounded-[4px] checked:rounded-[4px]' />
                                </td>
                                <td class='text-ph font-semibold text-primary hover:underline cursor-pointer py-2 px-3'>
                                    <RouterLink :to="'/orderdetail/' + item.id" class="w-full h-full">
                                        <p>#{{ item.id }}</p>
                                    </RouterLink>
                                </td>
                                <td class='text-ph font-semibold text-gray-700 py-2 px-3'>${{ item.total }}</td>
                                <td class='text-ph font-semibold text-gray-700 py-2 px-3 flex items-center gap-1'>
                                    <img :src="item.customer.image" alt=""
                                        class='w-[40px] h-[40px] border-solid border border-gray-300 rounded-full object-cover' />
                                    <p
                                        class='text-ph font-semibold text-gray-700 py-2 px-3 hover:underline hover:text-primary cursor-pointer'>
                                        {{ item.customer.name }}</p>
                                </td>
                                <td class='text-ph font-semibold text-gray-700 py-2 px-3'>{{ item.payment_method }}</td>
                                <td class='text-ph font-semibold text-gray-700 py-2 px-3'>{{ item.created_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="flex items-center justify-between border-t border-gray-200 bg-white px-2 py-3 sm:px-2">
                    <div class="flex flex-1 justify-between sm:hidden">
                        <a @click="activePage = activePage > 1 ? activePage - 1 : activePage"
                            class="relative inline-flex items-center rounded-md border border-gray-300 bg-white border-solid px-4 py-2 text-sm font-medium text-gray-700 hover:bg-body cursor-pointer">
                            Previous
                        </a>
                        <a @click="activePage = activePage < page ? activePage + 1 : activePage"
                            class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white border-solid px-4 py-2 text-sm font-medium text-gray-700 hover:bg-body cursor-pointer">
                            Next
                        </a>
                    </div>

                    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">Showing
                                <span class="font-medium">{{ orders.length > 0 ? (activePage - 1) * ITEM_PER_PAGE + 1 :
                                    0 }}</span> to
                                <span class="font-medium">{{ (orders.length - (activePage - 1) * ITEM_PER_PAGE) >
                                    ITEM_PER_PAGE
                                    ? activePage * ITEM_PER_PAGE : orders.length }}</span> of
                                <span class="font-medium">{{ orders.length }}</span> results
                            </p>
                        </div>
                        <div>
                            <nav class="flex gap-2 rounded-md" aria-label="Pagination">
                                <a @click="activePage = activePage > 1 ? activePage - 1 : activePage"
                                    class="relative cursor-pointer inline-flex items-center rounded-l-md bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-20">
                                    <span class="sr-only">Previous</span>
                                    <img :src="setIcon('left.svg')" alt="" class="h-4 w-4">
                                </a>

                                <a v-for="(item, index) in page" @click="activePage = index + 1"
                                    :class="index + 1 == activePage ? 'bg-primary border-primary text-white hover:bg-primary' : 'border-gray-300 text-gray-500 bg-white hover:bg-gray-50'"
                                    class="relative rounded-md cursor-pointer inline-flex items-center border-solid border px-3 py-1 text-sm font-medium focus:z-20">
                                    {{ index + 1 }}
                                </a>

                                <a @click="activePage = activePage < page ? activePage + 1 : activePage"
                                    class="relative cursor-pointer inline-flex items-center rounded-r-md bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-20">
                                    <span class="sr-only">Next</span>
                                    <img :src="setIcon('right.svg')" alt="" class="h-4 w-4">
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-else class='mycontainer h-[80vh] flex justify-center items-center flex-col bg-body'>
        <img :src="'/icons/empty.png'" alt="" class='w-[300px] h-[300px]' />
        <h1 class='text-lg md:text-4xl font-semibold mt-10 '>Your Order is <span class='text-primary'>Empty!</span>
        </h1>
        <RouterLink to='/'>
            <button class='text-lg md:text-xl font-semibold text-white bg-primary px-[50px] py-2 rounded-full mt-10'>Back to
                shop</button>
        </RouterLink>
    </div>
</template>
<script setup>
import { onMounted, ref } from 'vue';
let developers = ref([]);
onMounted(async () => {
    getDeveloper();
});
const getDeveloper = async () => {
    const respone = await axios.get('/api/about_us');
    developers.value = respone.data.result.reverse();
}
</script>

<template>
    <h1 class='text-4xl mt-10 font-semibold text-primary text-center mb-10'>Our Developer</h1>
    <div v-for="(item, index) in developers" class="mycontainer">
        <div v-if="index % 2 == 0" class="flex flex-col md:flex-row gap-5 mt-5 justify-center mb-12">
            <img :src="item.image" alt="" class='shadow-sm w-full md:w-[250px] h-[400px] md:h-[300px]  p-2 rounded-lg border border-solid border-gray-300 ' />
            <div class='w-full md:w-[70%] order-first md:order-last'>
                <h1 class='text-2xl font-semibold text-gray-800 mb-1'>{{ item.name }}</h1>
                <h1 class='text-2xl font-semibold text-gray-600 mb-1'>{{ item.position }}</h1>
                <p>{{ item.description }}</p>
            </div>
        </div>

        <div v-else class="flex flex-col md:flex-row gap-5 mt-5 justify-center mb-12">
            <img :src="item.image" alt="" class='shadow-sm w-full md:w-[250px] h-[400px] md:h-[300px]  p-2 rounded-lg border border-solid border-gray-300 ' />
            <div class='w-full md:w-[70%] order-first'>
                <h1 class='text-2xl font-semibold text-gray-800 mb-1'>{{ item.name }}</h1>
                <h1 class='text-2xl font-semibold text-gray-600 mb-1'>{{ item.position }}</h1>
                <p class='w-full overflow-hidden'>{{ item.description }}</p>
            </div>
        </div>
    </div>
</template>
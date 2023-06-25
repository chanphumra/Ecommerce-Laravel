<script setup>
import { onMounted, ref } from 'vue';
import Profile from '../setting/profile';

let footer = ref([]);
let profile = ref({});
onMounted(async () => {
    profile.value = await Profile;
    getFooter();
});
const getFooter = async () => {
    const respone = await axios.get('/api/footer');
    footer.value = respone.data.result;
}
</script>

<template>
    <div class='bg-white mt-10 shadow-sm'>
        <div class='mycontainer text-gray-400'>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 py-10">

                <div class='flex flex-col gap-4'>
                    <div class="flex items-center gap-4">
                        <div class="logo w-[40px]">
                            <img :src="profile.image" alt="" class='w-full h-[40px] object-cover' />
                        </div>
                        <p class='text-gray-700 font-semibold text-xl md:text-2xl'>{{profile.name}}</p>
                    </div>
                    <div class='text-gray-700 whitespace-normal'>{{ footer[0].description }}</div>
                </div>

                <div class='flex flex-col gap-4'>
                    <h1 class='font-semibold text-lg text-primary uppercase'>{{footer[1].title}}</h1>
                    <div class="flex flex-col gap-1">
                        <p class='text-base text-gray-700 hover:text-gray-500 cursor-pointer'>{{footer[1].text1}}</p>
                        <p class='text-base text-gray-700 hover:text-gray-500 cursor-pointer'>{{footer[1].text2}}</p>
                        <p class='text-base text-gray-700 hover:text-gray-500 cursor-pointer'>{{footer[1].text3}}</p>
                        <p class='text-base text-gray-700 hover:text-gray-500 cursor-pointer'>{{footer[1].text4}}</p>
                    </div>
                </div>

                <div class='flex flex-col gap-4'>
                    <h1 class='font-semibold text-lg text-primary uppercase'>{{footer[2].title}}</h1>
                    <div class="flex flex-col gap-1">
                        <p class='text-base text-gray-700 hover:text-gray-500 cursor-pointer'>{{footer[2].text1}}</p>
                        <p class='text-base text-gray-700 hover:text-gray-500 cursor-pointer'>{{footer[2].text2}}</p>
                        <p class='text-base text-gray-700 hover:text-gray-500 cursor-pointer'>{{footer[2].text3}}</p>
                        <p class='text-base text-gray-700 hover:text-gray-500 cursor-pointer'>{{footer[2].text4}}</p>
                    </div>
                </div>

                <div class='flex flex-col gap-4'>
                    <h1 class='font-semibold text-lg text-primary uppercase'>{{footer[3].title}}</h1>
                    <div class="flex flex-col gap-1">
                        <p class='text-base text-gray-700 hover:text-gray-500 cursor-pointer'>{{footer[3].text1}}</p>
                        <p class='text-base text-gray-700 hover:text-gray-500 cursor-pointer'>{{footer[3].text2}}</p>
                        <p class='text-base text-gray-700 hover:text-gray-500 cursor-pointer'>{{footer[3].text3}}</p>
                        <p class='text-base text-gray-700 hover:text-gray-500 cursor-pointer'>{{footer[3].text4}}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>
<script setup>
import { onMounted, ref } from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import { Autoplay, Pagination, Navigation } from 'swiper';


const modules = [Autoplay, Pagination, Navigation];
let slideshows = ref([]);

onMounted(async () => {
    getSlideshow();
});

const getSlideshow = async () => {
    const respone = await axios.get('/api/slideshow');
    slideshows.value = respone.data.result.filter(slideshow => slideshow.enable == 1).reverse();
}
</script>

<template>
    <div class="mycontainer m-auto mt-4 py-0 rounded-lg overflow-hidden">
        <swiper v-if="slideshows.length > 0"
            :style="{
                '--swiper-navigation-color': '#42b883',
                '--swiper-pagination-color': '#42b883',
            }" 
            :loop="true" 
            :spaceBetween="30" 
            :centeredSlides="true" 
            :autoplay="{
                delay: 2500,
                disableOnInteraction: false,
            }" 
            :pagination="{
                clickable: true,
            }" 
            :navigation="true" 
            :modules="modules" 
            class="mySwiper h-[600px] bg-white rounded-lg overflow-hidden">
            <swiper-slide v-for="item in slideshows" class="h-full">
                <div class='flex items-center flex-col lg:flex-row h-full w-full'>
                    <div class="flex items-center justify-center w-full lg:w-1/2 h-[35%] lg:h-full">
                        <div class="ml-7 md:ml-14">
                            <h1 class='capitalize text-2xl lg:text-5xl font-bold'>{{ item.title }}</h1>
                            <h4 class="text-gray-500 my-5 md:my-7">{{item.text}}</h4>
                            <button class='capitalize bg-primary text-white py-3 px-7 rounded'>Shop now</button>
                        </div>
                    </div>
                    <div class="image w-full lg:w-1/2 h-[65%] lg:h-full">
                        <img :src="item.image" alt="" class="w-full h-full object-cover" />
                    </div>
                </div>
            </swiper-slide>
        </swiper>
    </div>
</template>
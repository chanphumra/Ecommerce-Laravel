<script setup>
import { ref, onMounted } from 'vue';
import Sidebar from './sidebar.vue';
import Profile from '../../setting/profile';
let open = ref(false);
let profile = ref({});

onMounted(async () => {
    profile.value = await Profile;
});

function handle(value) {
    open.value = value;
}
</script>

<template>
    <div
        class='sticky z-50 top-0 flex justify-between items-center w-full bg-white border-solid border-gray-300 border-b py-3 px-5 lg:px-10'>
        <div class="flex items-center gap-3">
            <i @click="open = !open" class='lg:hidden text-2xl text-gray-600 mr-2 cursor-pointer fas fa-bars'></i>
            <img :src="profile.image" alt="" class='w-10 h-10 object-cover' />
            <h1 class='font-semibold text-xl lg:text-2xl text-gray-500'>{{ profile.name }}</h1>
        </div>
        <div class='flex gap-4 items-center'>
            <img src="" alt="" class='w-10 h-10 rounded-full object-cover cursor-pointer' />
        </div>
    </div>
    <Sidebar :openSide="open" @close-side="handle(value)" />
</template>
<script setup>
    import { ref } from 'vue';
    import Sidebar from './sidebar.vue';
    let open = ref(false);
</script>

<template>
    <div 
        class='sticky z-50 top-0 flex justify-between items-center w-full bg-white border-solid border-gray-300 border-b py-3 px-5 lg:px-10'>
        <div class="flex items-center gap-3">
            <i @click="open = !open" class='lg:hidden text-2xl text-gray-600 mr-2 cursor-pointer fas fa-bars'></i>
            <img src="" alt="" class='w-10 h-10 object-cover' />
            <h1 class='font-semibold text-xl lg:text-2xl text-gray-500'>Bazaar Shop</h1>
        </div>
        <div class='flex gap-4 items-center'>
            <!-- <Link to='/admin/chat?page_name=chat'> -->
            <div
                class='border border-solid border-gray-300 w-10 h-10 rounded-full object-cover cursor-pointer bg-body flex items-center justify-center'>
                <div class='text-lg font-semibold cursor-pointer text-gray-500'></div>
            </div>
            <!-- </Link> -->
            <img src="" alt="" class='w-10 h-10 rounded-full object-cover cursor-pointer' />
        </div>
    </div>
    <Sidebar :openSide="open"/>
</template>
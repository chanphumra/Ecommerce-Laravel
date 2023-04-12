<script setup>
import { ref } from 'vue';

const header = ['CATEGORY NAME', 'DESCRIPTION', 'PUBLISHED ON'];
const ITEM_PER_PAGE = 5;
let page = ref(0);
let activePage = ref(1);



function setIcon(icon) {
    return "/icons/" + icon;
}   

</script>

<template>
    <div class='lg:py-7 lg:px-10 p-5'>
        <h1 class='text-3xl font-bold text-black_500'>Category</h1>
    </div>
    <div class="flex gap-4 flex-col lg:flex-row lg:items-center justify-between px-5 lg:px-10 mb-4">
        <div class='relative'>
            <input type="text" name="" id="" placeholder='Search category'
                class='text-sm pl-10 w-full lg:w-[300px] h-[40px] rounded-md border-gray-300 border-solid border focus:border-current focus:ring-current' />
            <img :src="setIcon('search.svg')" alt="" class="absolute top-[50%] left-3 translate-y-[-50%] w-4 h-4" />
        </div>
        <button class='flex items-center gap-1 px-4 py-2 rounded-md bg-primary text-white text-sm cursor-pointer'>
            <img :src="setIcon('plus.svg')" alt=""/>Add category
        </button>
    </div>

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
                        <th class="text-gray-600 text-sm py-2 px-3" v-for="(item, index) in header">{{ item }}</th>
                        <th class='text-end text-gray-600 text-sm py-2 px-3 pr-4'></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class='group relative border-solid border-b border-gray-300'>
                        <td class='text-sm text-gray-700 py-2 px-3'>
                            <input type="checkbox" name="" id=""
                                class='w-4 h-4 border-solid border border-gray-500 rounded-[4px] checked:rounded-[4px]' />
                        </td>
                        <td class='py-2 px-3 flex items-center gap-1'>
                            <img src="" alt=""
                                class='w-[45px] h-[45px] border-solid border border-gray-300 rounded-md object-cover' />
                            <p
                                class='w-[230px] text-ph font-semibold truncate text-primary py-2 px-3 hover:underline cursor-pointer'>
                            </p>
                        </td>
                        <td class='text-ph font-semibold text-gray-700 py-2 px-3'>
                            <p class='w-[300px] text-ph font-semibold truncate text-primary py-2 px-3'></p>
                        </td>
                        <td class='text-ph font-semibold text-gray-700 py-2 px-3'></td>
                        <td class='text-lg w-4 text-gray-700 py-2 px-3 pr-5'>
                            <div class="w-4 h-4"><img :src="setIcon('more.svg')" alt="" /></div>
                        </td>

                        <div class='hidden group-hover:flex absolute right-0 top-[50%] translate-y-[-50%] pr-[10px]  gap-1'>
                            <div
                                class='inline-flex px-[10px] py-[6px] bg-body border-solid border border-gray-300 rounded-md cursor-pointer hover:bg-gray-200'>
                                <img :src="setIcon('check.svg')" alt="">
                            </div>
                            <div
                                class='inline-flex px-[10px] py-[6px] bg-body border-solid border border-gray-300 rounded-md cursor-pointer hover:bg-gray-200'>
                                <img :src="setIcon('edit.svg')" alt="">
                            </div>
                            <div
                                class='inline-flex px-[10px] py-[6px] bg-body border-solid border border-gray-300 rounded-md cursor-pointer hover:bg-gray-200'>
                                <img :src="setIcon('trash.svg')" alt="">
                            </div>
                        </div>
                    </tr>
                </tbody>
            </table>
        </div>


        <div class="flex items-center justify-between border-t border-gray-200 bg-white px-2 py-3 sm:px-2">
            <div class="flex flex-1 justify-between sm:hidden">
                <a
                    class="relative inline-flex items-center rounded-md border border-gray-300 bg-white border-solid px-4 py-2 text-sm font-medium text-gray-700 hover:bg-body cursor-pointer">
                    Previous
                </a>
                <a
                    class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white border-solid px-4 py-2 text-sm font-medium text-gray-700 hover:bg-body cursor-pointer">
                    Next
                </a>
            </div>

            <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">Showing <span class="font-medium">1</span> to <span
                            class="font-medium">8</span> of
                        <span class="font-medium">8</span> results
                    </p>
                </div>
                <div>
                    <nav class="flex gap-2 rounded-md" aria-label="Pagination">
                        <a class="relative
                                    cursor-pointer inline-flex items-center rounded-l-md bg-white px-2 py-2 text-sm font-medium
                                    text-gray-500 hover:bg-gray-50 focus:z-20">
                            <span class="sr-only">Previous</span>
                            <img :src="setIcon('left.svg')" alt="" class="h-4 w-4">
                        </a>

                        <a
                            class="bg-primary border-primary text-white hover:bg-primary relative rounded-md cursor-pointer inline-flex items-center border-solid border px-3 py-1 text-sm font-medium focus:z-20">
                            1
                        </a>

                        <a
                            class="relative cursor-pointer inline-flex items-center rounded-r-md bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-20">
                            <span class="sr-only">Next</span>
                            <img :src="setIcon('right.svg')" alt="" class="h-4 w-4">
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</template>
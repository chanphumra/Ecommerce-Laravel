<script setup>
import { computed } from '@vue/reactivity';
import { onMounted, ref } from 'vue';
import { useRouter, RouterLink } from 'vue-router';

let token = ref("");
const router = useRouter();
const header = ['SLIDESHOW TITLE', 'TEXT', 'LINK', 'PUBLISHED ON'];
const ITEM_PER_PAGE = 5;
let page = ref(0);
let activePage = ref(1);

let slideshows = ref([]);

onMounted(async () => {
    getSlideshow();
    token.value = sessionStorage.getItem('adminToken') || '';
});

let slideshowByPage = computed(() => {
    let slideshow = [];
    for (let index = 0; index < slideshows.value.length; index++) {
        if (index >= (activePage.value - 1) * ITEM_PER_PAGE && index < activePage.value * ITEM_PER_PAGE)
            slideshow.push(slideshows.value[index]);
    }
    return slideshow;
});

const getSlideshow = async () => {
    const respone = await axios.get('/api/slideshow');
    slideshows.value = respone.data.result.reverse();
    page = Math.ceil(slideshows.value.length / ITEM_PER_PAGE);
}

const deleteSlideshow = (id) => {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this slideshow!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        confirmButtonColor: '#42b883',
        cancelButtonColor: '#d33',
        reverseButtons: true
    }).then(async (result) => {
        if (result.isConfirmed) {
            axios.delete("/api/slideshow/" + id, {
                headers: {
                    'Authorization': `Bearer ${token.value}`,
                    'Accept': 'application/json'
                }
            }).then(res => {
                if (res.status == 200) {
                    getSlideshow();
                    if ((slideshows.length - 1) % ITEM_PER_PAGE == 0) {
                        activePage = activePage - 1;
                    }
                    Swal.fire({
                        toast: true,
                        position: 'top',
                        showClass: {
                            icon: 'animated heartBeat delay-1s'
                        },
                        icon: 'success',
                        text: 'Slideshow has been delete!',
                        showConfirmButton: false,
                        timer: 1000
                    });
                }
            });
        }
    })
}

const updateEnable = (id, enable) => {
    const formData = new FormData();
    formData.append('enable', enable == 1 ? 0 : 1);
    formData.append('_method', "PUT");
    axios.post('/api/slideshow/updateEnable/' + id, formData, {
        headers: {
            'Authorization': `Bearer ${token.value}`,
            'Accept': 'application/json'
        }
    }).then(res => {
        if (res.data.success) {
            Swal.fire({
                toast: true,
                position: 'top',
                showClass: {
                    icon: 'animated heartBeat delay-1s'
                },
                icon: 'success',
                text: `Slideshow has been ${enable == 1 ? 'disable' : 'enable'}`,
                showConfirmButton: false,
                timer: 1000
            });
            getSlideshow();
        }
    }).catch(err => {
        console.log(err);
    });
}

function setIcon(icon) {
    return "/icons/" + icon;
}

function Image(image) {
    return image;
}

</script>

<template>
    <div class='lg:py-7 lg:px-10 p-5'>
        <h1 class='text-3xl font-bold text-black_500'>Slideshow</h1>
    </div>
    <div class="flex gap-4 flex-col md:flex-row lg:items-center justify-between px-5 lg:px-10 mb-4">
        <div class='relative'>
            <input type="text" name="" id="" placeholder='Search slideshow'
                class='text-sm pl-10 w-full lg:w-[300px] h-[40px] rounded-md border-gray-300 border-solid border focus:border-current focus:ring-current' />
            <img :src="setIcon('search.svg')" alt="" class="absolute top-[50%] left-3 translate-y-[-50%] w-4 h-4" />
        </div>
        <RouterLink to="/admin/add_slideshow">
            <button class='flex items-center gap-1 px-4 py-2 rounded-md bg-primary text-white text-sm cursor-pointer'>
                <img :src="setIcon('plus.svg')" alt="" />Add Slideshow
            </button>
        </RouterLink>
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
                        <th v-for="(item, index) in header" :class="index == 0 ? 'w-[300px] text-center' : 'text-start'"
                            class="text-gray-600 text-sm py-2 px-3">{{ item }}</th>
                        <th class='text-end text-gray-600 text-sm py-2 px-3 pr-4'></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in slideshowByPage" class='group relative border-solid border-b border-gray-300'>
                        <td class='text-sm text-gray-700 py-2 px-3'>
                            <input type="checkbox" name="" id=""
                                class='w-4 h-4 border-solid border border-gray-500 rounded-[4px] checked:rounded-[4px]' />
                        </td>
                        <td class='py-2 px-3 flex items-center gap-1'>
                            <img :src="Image(item.image)" alt=""
                                class='w-[45px] h-[45px] border-solid border border-gray-300 rounded-md object-cover' />
                            <p
                                class='w-[230px] text-ph font-semibold truncate text-primary py-2 px-3 hover:underline cursor-pointer'>
                                {{ item.title }}
                            </p>
                        </td>
                        <td class='text-ph font-semibold text-gray-700 py-2 px-3'>
                            <p class='w-[300px] text-ph font-semibold truncate py-2 px-3'>{{ item.text }}</p>
                        </td>
                        <td class='text-ph font-semibold text-gray-700 py-2 px-3'>
                            <p class='w-[300px] text-ph font-semibold truncate py-2 px-3'>{{ item.link }}</p>
                        </td>
                        <td class='text-ph font-semibold text-gray-700 py-2 px-3'>{{ item.created_at }}</td>
                        <td class='text-lg w-4 text-gray-700 py-2 px-3 pr-5'>
                            <div class="w-4 h-4"><img :src="setIcon('more.svg')" alt="" /></div>
                        </td>

                        <div class='hidden group-hover:flex absolute right-0 top-[50%] translate-y-[-50%] pr-[10px]  gap-1'>
                            <div
                                class='inline-flex px-[10px] py-[6px] bg-body border-solid border border-gray-300 rounded-md cursor-pointer hover:bg-gray-200'>
                                <img :src="setIcon('check.svg')" alt="" class="w-[14px] h-[14px]">
                            </div>
                            <div @click="updateEnable(item.id, item.enable)"
                                class='inline-flex px-[10px] py-[6px] bg-body border-solid border border-gray-300 rounded-md cursor-pointer hover:bg-gray-200'>
                                <img :src="setIcon(item.enable == 1 ? 'eye.svg' : 'eye-off.svg')" alt=""
                                    class="w-[14px] h-[14px]">
                            </div>
                            <RouterLink :to="'/admin/edit_slideshow/' + item.id">
                                <div
                                    class='inline-flex px-[10px] py-[6px] bg-body border-solid border border-gray-300 rounded-md cursor-pointer hover:bg-gray-200'>
                                    <img :src="setIcon('edit.svg')" alt="" class="w-[14px] h-[14px]">
                                </div>
                            </RouterLink>
                            <div @click="deleteSlideshow(item.id)"
                                class='inline-flex px-[10px] py-[6px] bg-body border-solid border border-gray-300 rounded-md cursor-pointer hover:bg-gray-200'>
                                <img :src="setIcon('trash.svg')" alt="" class="w-[14px] h-[14px]">
                            </div>
                        </div>
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
                        <span class="font-medium">{{ slideshows.length > 0 ? (activePage - 1) * ITEM_PER_PAGE + 1 :
                            0 }}</span> to
                        <span class="font-medium">{{ (slideshows.length - (activePage - 1) * ITEM_PER_PAGE) > ITEM_PER_PAGE
                            ? activePage * ITEM_PER_PAGE : slideshows.length }}</span> of
                        <span class="font-medium">{{ slideshows.length }}</span> results
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
</template>
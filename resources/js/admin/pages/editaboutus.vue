<script setup>
import { computed } from '@vue/reactivity';
import { onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const router = useRouter();
const route = useRoute();
const params = computed(() => {
    return route.params;
});

let token = ref('');
let form = ref({
    name: '',
    position: '',
    description: '',
    image: ''
});

let imagePreview = ref("");

onMounted(async () => {
    getCategory();
    token.value = sessionStorage.getItem('adminToken') || '';
});

const getCategory = async () => {
    const respone = await axios.get(`/api/about_us/${params.value.id}`);
    if (respone.status == 200) {
        form.value.name = respone.data.result.name;
        form.value.position = respone.data.result.position;
        form.value.description = respone.data.result.description;
        imagePreview.value = respone.data.result.image;
    }
}

function updateSlideshow() {
    if (form.value.name == "" || form.value.position == "" || form.value.description == "") return Swal.fire({
        toast: true,
        position: 'top',
        showClass: {
            icon: 'animated heartBeat delay-1s'
        },
        icon: 'error',
        text: 'Please check information again',
        showConfirmButton: false,
        timer: 1000
    });

    const formData = new FormData();
    formData.append('name', form.value.name);
    formData.append('position', form.value.position);
    formData.append('description', form.value.description);
    formData.append('image', form.value.image);
    formData.append('_method', "PUT");

    axios.post(`/api/about_us/${params.value.id}`, formData, {
        headers: {
            'Authorization': `Bearer ${token.value}`,
            'Accept': 'application/json'
        }
    }).then(res => {
        if (res.status == 200) Swal.fire({
            toast: true,
            position: 'top',
            showClass: {
                icon: 'animated heartBeat delay-1s'
            },
            icon: 'success',
            text: 'Developer has been updated',
            showConfirmButton: false,
            timer: 1000
        }).then(r => {
            router.push('/admin/show_aboutus');
        });
    }).catch(err => {
        console.log(err);
    });
}

function previewImage() {
    if (form.value.image != "")
        return URL.createObjectURL(form.value.image);
    return imagePreview.value;
}

function browseImage(e) {
    const file = e.target.files[0];
    const allowExtenstions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    if (allowExtenstions.exec(e.target.value))
        form.value.image = file;
}

</script>

<template>
    <div class='lg:py-7 lg:px-10 p-5'>
        <div class="flex justify-between items-end">
            <h1 class='text-3xl font-bold text-black_500'>Edit a developer</h1>
            <button class='px-4 py-2 rounded-md bg-primary text-white text-sm cursor-pointer'
                @click="updateSlideshow()">Edit
                slideshow</button>
        </div>
        <div class="mt-10 flex flex-col gap-8 md:flex-row">
            <div class='flex-[4]'>
                <div class="flex justify-between">
                    <h1 class='text-xl font-semibold text-gray-800'>Name</h1>
                </div>
                <div class="mt-3">
                    <input type="text" name="" id="" class='input text-sm w-full' placeholder='Write name here...'
                        v-model="form.name" />
                </div>
                <div class="flex justify-between">
                    <h1 class='text-xl font-semibold text-gray-800'>Position</h1>
                </div>
                <div class="mt-3">
                    <input type="text" name="" id="" class='input text-sm w-full' placeholder='Write position here...'
                        v-model="form.position" />
                </div>
                <div class="mt-7">
                    <h1 class='text-xl font-semibold text-gray-800'>Description</h1>
                    <div class='mt-3'>
                        <textarea name="" id="" placeholder='Write a description here...'
                            class='text-sm h-[200px] input w-full resize-none' v-model="form.description"></textarea>
                    </div>
                </div>
                <div class="mt-7">
                    <h1 class='text-xl font-semibold text-gray-800'>Display images</h1>

                    <div class="inline-flex gap-4 mt-2" v-if="form.image !== '' || imagePreview !== ''">
                        <div
                            class='relative w-[100px] h-[100px] p-[2px] rounded-lg border-solid border border-gray-300 overflow-hidden'>
                            <div class='absolute right-[2px] top-[2px] cursor-pointer'>
                                <!-- <IoClose color='white' class='bg-red-500 w-4 h-4 rounded-full p-[0.1rem]' /> -->
                            </div>
                            <img :src="previewImage()" alt="" class='w-full h-full rounded-lg object-cover' />
                        </div>
                    </div>

                    <div
                        class="relative h-[200px] mt-3 border-dashed border-2 border-gray-300 rounded-lg flex flex-col justify-center items-center">
                        <i class="fas fa-cloud-upload text-primary text-[46px]"></i>
                        <p class='text-[15px] text-gray-600'>Browse developer image</p>
                        <input class='absolute w-full h-full opacity-0 cursor-pointer' type="file" name="" id=""
                            accept="image/*" @change="browseImage" />
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
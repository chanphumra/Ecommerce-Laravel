<script setup>
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
let token = ref('');

onMounted(() => {
    token.value = sessionStorage.getItem('adminToken') || '';
});

let form = ref({
    title: '',
    text: '',
    link: '',
    image: '',
    enable: false
});

function previewImage() {
    return URL.createObjectURL(form.value.image);
}

function browseImage(e) {
    const file = e.target.files[0];
    const allowExtenstions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    if (allowExtenstions.exec(e.target.value))
        form.value.image = file;
}

function saveSlideshow() {
    if (form.value.title == "" || form.value.text == "" || form.value.link == "") return Swal.fire({
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

    if (form.value.image == "") return Swal.fire({
        toast: true,
        position: 'top',
        showClass: {
            icon: 'animated heartBeat delay-1s'
        },
        icon: 'error',
        text: 'Please choose one image',
        showConfirmButton: false,
        timer: 1000
    });

    const formData = new FormData();
    formData.append('title', form.value.title);
    formData.append('text', form.value.text);
    formData.append('link', form.value.link);
    formData.append('image', form.value.image);
    formData.append('enable', form.value.enable ? 1 : 0);

    axios.post("/api/slideshow/", formData, {
        headers: {
            'Authorization': `Bearer ${token.value}`,
            'Accept': 'application/json'
        }
    }).then(res => {
        Swal.fire({
            toast: true,
            position: 'top',
            showClass: {
                icon: 'animated heartBeat delay-1s'
            },
            icon: 'success',
            text: 'Slideshow has been saved',
            showConfirmButton: false,
            timer: 1000
        }).then(r => {
            router.push('/admin/show_slideshow');
        });
    }).catch(err => {
        console.log(err);
    });
}
</script>

<template>
    <div class='lg:py-7 lg:px-10 p-5'>
        <div class="flex justify-between items-end">
            <h1 class='text-3xl font-bold text-black_500'>Add a slideshow</h1>
            <button class='px-4 py-2 rounded-md bg-primary text-white text-sm cursor-pointer'
                @click="saveSlideshow()">Publish slideshow</button>
        </div>
        <div class="mt-10 flex flex-col gap-8 md:flex-row">
            <div class='flex-[4]'>
                <div class="flex justify-between">
                    <h1 class='text-xl font-semibold text-gray-800'>Title</h1>
                    <div class="flex items-center gap-2">
                        <input v-model="form.enable" type="checkbox" id="enable" class="accent-current border border-solid border-gray-300 rounded-sm cursor-pointer focus:ring-primary">
                        <label for="enable">Enable</label>
                    </div>
                </div>
                <div class="mt-3">
                    <input type="text" name="" id="" class='input text-sm w-full' placeholder='Write title here...'
                        v-model="form.title" />
                </div>
                <div class="mt-7">
                    <h1 class='text-xl font-semibold text-gray-800'>Text</h1>
                    <div class='mt-3'>
                        <textarea name="" id="" placeholder='Write a text here...'
                            class='text-sm h-[200px] input w-full resize-none' v-model="form.text"></textarea>
                    </div>
                </div>
                <div class="flex justify-between">
                    <h1 class='text-xl font-semibold text-gray-800'>Link</h1>
                </div>
                <div class="mt-3">
                    <input type="text" name="" id="" class='input text-sm w-full' placeholder='Write link here...'
                        v-model="form.link" />
                </div>
                <div class="mt-7">
                    <h1 class='text-xl font-semibold text-gray-800'>Display images</h1>

                    <div class="inline-flex gap-4 mt-2" v-if="form.image !== ''">
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
                        <p class='text-[15px] text-gray-600'>Browse slideshow image</p>
                        <input class='absolute w-full h-full opacity-0 cursor-pointer' type="file" name="" id=""
                            accept="image/*" @change="browseImage" />
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
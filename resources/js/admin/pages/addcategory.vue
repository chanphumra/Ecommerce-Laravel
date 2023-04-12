<script setup>
import { ref } from 'vue';
    let form = ref({
        name: '',
        description: '',
        image: ''
    });

    function previewImage() {
        let image = '';
        if(form.value.image){
            if(form.value.image.indexOf('base64') != -1){
                image = form.value.image;
            }
            else{
                image = "/uploads/" + form.value.image;
            }
        }
        return image;
    }

    function browseImage(e) {
        const file = e.target.files[0];
        const reader = new FileReader();
        const limit = 1024 * 1024 * 2;
        if(file['size'] > limit){
            return false;
        }
        reader.onloadend = (file) => {
            form.value.image = reader.result;
        }
        reader.readAsDataURL(file);
    }
</script>

<template>
    <div class='lg:py-7 lg:px-10 p-5'>
        <div class="flex justify-between items-end">
            <h1 class='text-3xl font-bold text-black_500'>Add a category</h1>
            <button class='px-4 py-2 rounded-md bg-primary text-white text-sm cursor-pointer'>Publish category</button>
        </div>
        <div class="mt-10 flex flex-col gap-8 md:flex-row">
            <div class='flex-[4]'>
                <div class="flex justify-between">
                    <h1 class='text-xl font-semibold text-gray-800'>Category Title</h1>
                </div>
                <div class="mt-3">
                    <input type="text" name="" id="" class='input text-sm w-full' placeholder='Write title here...' v-model="form.name" />
                </div>
                <div class="mt-7">
                    <h1 class='text-xl font-semibold text-gray-800'>Category Description</h1>
                    <div class='mt-3'>
                        <textarea name="" id="" placeholder='Write a description here...' class='text-sm h-[200px] input w-full resize-none' v-model="form.description"></textarea>
                    </div>
                </div>

                <div class="mt-7">
                    <h1 class='text-xl font-semibold text-gray-800'>Display images</h1>

                    <div class="inline-flex gap-4 mt-2" v-if="form.image !== ''">
                        <div class='relative w-[100px] h-[100px] p-[2px] rounded-lg border-solid border border-gray-300 overflow-hidden'>
                            <div class='absolute right-[2px] top-[2px] cursor-pointer'>
                                <!-- <IoClose color='white' class='bg-red-500 w-4 h-4 rounded-full p-[0.1rem]' /> -->
                            </div>
                            <img :src="previewImage()" alt="" class='w-full h-full rounded-lg object-cover' />
                        </div>
                    </div>

                    <div
                        class="relative h-[200px] mt-3 border-dashed border-2 border-gray-300 rounded-lg flex flex-col justify-center items-center">
                        <!-- <MdCloudUpload class='text-primary text-[46px]' /> -->
                        <p class='text-[15px] text-gray-600'>Browse category image</p>
                        <input class='absolute w-full h-full opacity-0 cursor-pointer' type="file" name="" id="" accept="image/*" @change="browseImage"/>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
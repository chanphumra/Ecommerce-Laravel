<script setup>
import { computed } from '@vue/reactivity';
import { onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const router = useRouter();
const route = useRoute();

let token = ref('');
let form = ref({
    name: '',
    city: '',
    country: '',
    phone: '',
    email: '',
    image: ''
});

let imagePreview = ref("");

onMounted(async () => {
    getProfile();
    token.value = sessionStorage.getItem('adminToken') || '';
});

const getProfile = async () => {
    const respone = await axios.get("/api/profile_setting/1");
    console.log(respone.data.result)
    if (respone.status == 200) {
        form.value.name = respone.data.result.name;
        form.value.city = respone.data.result.city;
        form.value.country = respone.data.result.country;
        form.value.phone = respone.data.result.phone;
        form.value.email = respone.data.result.email;
        imagePreview.value = respone.data.result.image;
    }
}
function previewImage() {
    if (form.value.image != "")
        return URL.createObjectURL(form.value.image);
    return imagePreview.value;
}
</script>

<template>
    <div className='lg:py-7 lg:px-10 p-5'>
        <div className="flex justify-between items-end">
            <h1 className='text-3xl font-bold text-black_500'>Profile Setting</h1>
            <button @click="" className='px-4 py-2 rounded-md bg-primary text-white text-sm cursor-pointer'>Save Change</button>
        </div>
        <div className="flex mt-14 gap-8 flex-col md:flex-row">
            <div className="flex-[2] bg-white p-5 rounded-lg shadow-md">
                <div className='relative w-[150px] h-[150px] rounded-full border border-solid border-gray-300 bg-white shadow-sm'>
                    <img :src="previewImage()" alt="" className='w-full h-full rounded-full object-cover p-1' />
                    <i className="absolute fa-solid fa-pen-to-square w-[40px] h-[40px] leading-[40px] text-center text-primary cursor-pointer bg-white rounded-full right-0 bottom-[5px] shadow-sm border border-solid border-gray-300"></i>
                    <input onChange={previewImage} ref={imageRef} type='file' className="opacity-0 absolute fa-solid fa-pen-to-square w-[40px] h-[40px] leading-[40px] text-center text-primary cursor-pointer bg-white rounded-full right-0 bottom-[5px] shadow-md border border-solid border-gray-300" />
                </div>
                <div className="mt-5">
                    <p className='mb-2'>Company name</p>
                    <input v-model="form.name" type="text" className='input w-full' placeholder='company name' />
                </div>
            </div>
            <div className="flex-[4] bg-white p-5 rounded-lg shadow-md">
                <h1 className='text-xl font-semibold'>General information</h1>
                <div className="flex flex-col md:flex-row gap-4 md:gap-8 w-full mt-5">
                    <div className="w-full">
                        <p className='mb-2'>City</p>
                        <input v-model="form.city" type="text" className='input w-full' placeholder='phnom penh' />
                    </div>
                    <div className="w-full">
                        <p className='mb-2'>Country</p>
                        <input v-model="form.country" type="text" className='input w-full' placeholder='cambodia' />
                    </div>
                </div>
                <div className="flex flex-col md:flex-row gap-4 md:gap-8 w-full mt-3">
                    <div className="w-full">
                        <p className='mb-2'>Phone</p>
                        <input v-model="form.phone" type="text" className='input w-full' placeholder='+1234567890' />
                    </div>
                    <div className="w-full">
                        <p className='mb-2'>Email</p>
                        <input v-model="form.email" type="text" className='input w-full' placeholder='company@gmail.com' />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
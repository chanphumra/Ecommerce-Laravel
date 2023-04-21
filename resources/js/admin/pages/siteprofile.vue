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
function updateProfile() {
    if (form.value.name == "" || form.value.city == "" || form.value.country == "" || form.value.phone == "" || form.value.email == "") return Swal.fire({
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
    formData.append('city', form.value.city);
    formData.append('country', form.value.country);
    formData.append('phone', form.value.phone);
    formData.append('email', form.value.email);
    formData.append('image', form.value.image);
    formData.append('_method', "PUT");

    axios.post(`/api/profile_setting/1`, formData, {
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
            text: 'Profile has been updated',
            showConfirmButton: false,
            timer: 1000
        }).then(r => {
            // router.push('/admin/show_slideshow');
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
            <h1 class='text-3xl font-bold text-black_500'>Profile Setting</h1>
            <button @click="updateProfile()" class='px-4 py-2 rounded-md bg-primary text-white text-sm cursor-pointer'>Save Change</button>
        </div>
        <div class="flex mt-14 gap-8 flex-col md:flex-row">
            <div class="flex-[2] bg-white p-5 rounded-lg shadow-md">
                <div class='relative w-[150px] h-[150px] rounded-full border border-solid border-gray-300 bg-white shadow-sm'>
                    <img :src="previewImage()" alt="" class='w-full h-full rounded-full object-cover p-1' />
                    <i class="absolute fa-solid fa-pen-to-square w-[40px] h-[40px] leading-[40px] text-center text-primary cursor-pointer bg-white rounded-full right-0 bottom-[5px] shadow-sm border border-solid border-gray-300"></i>
                    <input @change="browseImage" ref={imageRef} type='file' class="opacity-0 absolute fa-solid fa-pen-to-square w-[40px] h-[40px] leading-[40px] text-center text-primary cursor-pointer bg-white rounded-full right-0 bottom-[5px] shadow-md border border-solid border-gray-300" />
                </div>
                <div class="mt-5">
                    <p class='mb-2'>Company name</p>
                    <input v-model="form.name" type="text" class='input w-full' placeholder='company name' />
                </div>
            </div>
            <div class="flex-[4] bg-white p-5 rounded-lg shadow-md">
                <h1 class='text-xl font-semibold'>General information</h1>
                <div class="flex flex-col md:flex-row gap-4 md:gap-8 w-full mt-5">
                    <div class="w-full">
                        <p class='mb-2'>City</p>
                        <input v-model="form.city" type="text" class='input w-full' placeholder='phnom penh' />
                    </div>
                    <div class="w-full">
                        <p class='mb-2'>Country</p>
                        <input v-model="form.country" type="text" class='input w-full' placeholder='cambodia' />
                    </div>
                </div>
                <div class="flex flex-col md:flex-row gap-4 md:gap-8 w-full mt-3">
                    <div class="w-full">
                        <p class='mb-2'>Phone</p>
                        <input v-model="form.phone" type="text" class='input w-full' placeholder='+1234567890' />
                    </div>
                    <div class="w-full">
                        <p class='mb-2'>Email</p>
                        <input v-model="form.email" type="text" class='input w-full' placeholder='company@gmail.com' />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
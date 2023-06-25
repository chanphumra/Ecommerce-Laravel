<script setup>
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import Profile from '../setting/profile.js';
const router = useRouter();

let firstStep = ref(true);
let form = ref({
    name: '',
    email: '',
    password: '',
    confirm: '',
    image: '',
    otp: '',
});
let profile = ref({});

onMounted(async () => {
    profile.value = await Profile;
});

const saveUser = () => {

    if (form.value.image == '') return Swal.fire({
        toast: true,
        position: 'top',
        showClass: {
            icon: 'animated heartBeat delay-1s'
        },
        icon: 'warning',
        text: 'Please choose a profile',
        showConfirmButton: false,
        timer: 1000
    });

    form.value.otp = Math.floor(Math.random() * 9000 + 1000);
    const formData = new FormData();
    formData.append('name', form.value.name);
    formData.append('email', form.value.email);
    formData.append('receiver', form.value.email);
    formData.append('password', form.value.password);
    formData.append('image', form.value.image);
    formData.append('otp', form.value.otp);
    formData.append('verify', 0);
    formData.append('role', 0);

    Swal.fire({
        toast: true,
        text: 'please wait a minute!',
        position: 'top',
        allowEscapeKey: false,
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    /*============ send email =============*/
    axios.post('/api/sendEmail', formData).then(res => {
        Swal.close();
        if (res.data.success) {
            /*============ save user to database =============*/
            axios.post('/api/auth/register', formData).then(res => { console.log(res) }).catch(err => { console.log(err) });
            /*============ save otp to database =============*/
            axios.post('/api/storeOTP', formData).then(res => { console.log(res) }).catch(err => { console.log(err) });

            return Swal.fire({
                toast: true,
                position: 'top',
                showClass: {
                    icon: 'animated heartBeat delay-1s'
                },
                icon: 'success',
                text: 'We send otp to your email',
                showConfirmButton: false,
                timer: 1000
            }).then(respone => {
                router.push("/verify/" + form.value.email);
            });
        }
        else {
            return Swal.fire({
                toast: true,
                position: 'top',
                showClass: {
                    icon: 'animated heartBeat delay-1s'
                },
                icon: 'error',
                text: res.data.message,
                showConfirmButton: false,
                timer: 1000
            });
        }
    }).catch(err => { console.log(err) });
}

function previewImage() {
    if (form.value.image != '')
        return URL.createObjectURL(form.value.image);
    return "/image/avatar.png";
}

function browseImage(e) {
    const file = e.target.files[0];
    const allowExtenstions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    if (allowExtenstions.exec(e.target.value))
        form.value.image = file;
}

async function nextStep() {
    if (form.value.name == "" || form.value.email == "" || form.value.password == "" || form.value.confirm == "") {
        return Swal.fire({
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
    }

    if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(form.value.email)) return Swal.fire({
        toast: true,
        position: 'top',
        showClass: {
            icon: 'animated heartBeat delay-1s'
        },
        icon: 'error',
        text: 'Please enter a valid email',
        showConfirmButton: false,
        timer: 1000
    });

    if (form.value.password != form.value.confirm) {
        return Swal.fire({
            toast: true,
            position: 'top',
            showClass: {
                icon: 'animated heartBeat delay-1s'
            },
            icon: 'error',
            text: 'Password not match',
            showConfirmButton: false,
            timer: 1000
        });
    }

    const respone = await axios.post('/api/auth/exist', { email: form.value.email });
    if (respone.data.exist) return Swal.fire({
        toast: true,
        position: 'top',
        showClass: {
            icon: 'animated heartBeat delay-1s'
        },
        icon: 'error',
        text: 'Please register other email',
        showConfirmButton: false,
        timer: 1000
    });

    firstStep.value = false;
}

</script>

<template>
    <section v-if="firstStep" class=" bg-gray-50 h-screen bg-no-repeat bg-opacity-0
                                                            bg-[url('/image/bg.png')]"
        :style="'background-size: 100% 100%'">
        <div class="bg-black bg-opacity-20 flex flex-col items-center justify-center px-6 py-8 mx-auto h-screen lg:py-0">
            <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-white">
                <img class="w-8 h-8 mr-2" :src="profile.image" alt="logo" />
                {{profile.name}}
            </a>
            <div class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0 ">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                        Create an account
                    </h1>
                    <div class="space-y-4 md:space-y-6">
                        <div>
                            <label for="username" class="block mb-2 text-sm font-medium text-gray-900">Username</label>
                            <input v-model="form.name" type="text" name="username" id="username"
                                class="bg-gray-50 border border-solid border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5 "
                                placeholder="username" />
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                            <input v-model="form.email" type="email" name="email" id="email"
                                class="bg-gray-50 border border-solid border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5 "
                                placeholder="example@gmail.com" />
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                            <input v-model="form.password" type="password" name="password" id="password"
                                placeholder="••••••••"
                                class="bg-gray-50 border border-solid border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5 " />
                        </div>
                        <div>
                            <label for="confirm-password" class="block mb-2 text-sm font-medium text-gray-900">Confirm
                                password</label>
                            <input v-model="form.confirm" type="password" name="confirm-password" id="confirm-password"
                                placeholder="••••••••"
                                class="bg-gray-50 border border-solid border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5 " />
                        </div>
                        <button @click="nextStep()"
                            class="w-full text-white bg-primary focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center">Next</button>
                        <p class="text-sm font-normal text-gray-500">
                            Already have an account?
                            <RouterLink to='/login' class="font-medium text-primary hover:underline ml-1">Sign in here</RouterLink>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section v-else class="bg-gray-50 h-screen bg-no-repeat bg-opacity-0
                                                            bg-[url('/image/bg.png')]"
        :style="'background-size: 100% 100%'">
        <div class="bg-black bg-opacity-20 flex flex-col items-center justify-center px-6 py-8 mx-auto h-screen lg:py-0">
            <div class="flex items-center mb-6 text-2xl font-semibold text-white">
                <img class="w-8 h-8 mr-2" :src="profile.image" alt="logo" />
                {{profile.name}}
            </div>
            <div class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0 ">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                        Create an account
                    </h1>
                    <div class="space-y-4 md:space-y-6">
                        <div class="w-full flex justify-center py-5">
                            <div
                                class='relative w-[150px] h-[150px] rounded-full border border-solid border-gray-300 bg-white shadow-sm'>
                                <img :src="previewImage()" alt="" class='w-full h-full rounded-full object-cover p-1' />
                                <i
                                    class="absolute fa-solid fa-pen-to-square w-[40px] h-[40px] leading-[40px] text-center text-primary cursor-pointer bg-white rounded-full right-0 bottom-[5px] shadow-sm border border-solid border-gray-300"></i>
                                <input @change="browseImage" type='file'
                                    class="opacity-0 absolute fa-solid fa-pen-to-square w-[40px] h-[40px] leading-[40px] text-center text-primary cursor-pointer bg-white rounded-full right-0 bottom-[5px] shadow-md border border-solid border-gray-300" />
                            </div>
                        </div>
                        <button @click="saveUser()"
                            class="w-full text-white bg-primary focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center">Create
                            an account</button>
                        <p class="text-sm font-normal text-gray-500">
                            Already have an account?
                            <RouterLink to='/login' class="font-medium text-primary hover:underline ml-1">Sign in here</RouterLink>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style>
.swal2-loader {
    border-color: #42b883 transparent #42b883 transparent;
}
</style>
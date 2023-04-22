<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import Profile from '../../setting/profile.js';

const router = useRouter();
let form = ref({
    email: '',
    password: ''
});
let profile = ref({});

onMounted(async () => {
    profile.value = await Profile;
});

function login() {
    if (form.value.email == "" || form.value.password == "") return Swal.fire({
        toast: true,
        position: 'top',
        showClass: {
            icon: 'animated heartBeat delay-1s'
        },
        icon: 'warning',
        text: 'Please check information again',
        showConfirmButton: false,
        timer: 1000
    });

    const formData = new FormData();
    formData.append('email', form.value.email);
    formData.append('password', form.value.password);
    formData.append('role', 1);
    axios.post('/api/auth/login', formData).then(res => {
        if (res.data.success) {
            sessionStorage.setItem("adminToken", res.data.token);
            Swal.fire({
                toast: true,
                position: 'top',
                showClass: {
                    icon: 'animated heartBeat delay-1s'
                },
                icon: 'success',
                text: 'Welcome back admin',
                showConfirmButton: false,
                timer: 1000
            });
            router.replace("/admin");
        }
        else {
            Swal.fire({
                toast: true,
                position: 'top',
                showClass: {
                    icon: 'animated heartBeat delay-1s'
                },
                icon: 'warning',
                text: 'Incorrect email or password',
                showConfirmButton: false,
                timer: 1000
            });
        }
    }).catch(err => {
        console.log(err);
    });
}

</script>

<template>
    <section class="bg-gray-50 h-screen bg-no-repeat bg-opacity-0 bg-[url('/image/background.jpg')]"
        :style="'background-size: 100% 100%'">
        <div class="bg-black bg-opacity-20 flex flex-col items-center justify-center px-6 py-8 mx-auto h-screen lg:py-0">
            <Link to='/' class="flex items-center mb-6 text-2xl font-semibold text-white">
                <img class="w-8 h-8 mr-2" :src="profile.image" alt="logo" />
                {{profile.name}}
            </Link>
            <div class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0 ">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                        Login as administator
                    </h1>
                    <div class="space-y-4 md:space-y-6">
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                            <input v-model="form.email" type="email" name="email" id="email"
                                class="bg-gray-50 border border-solid border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5 "
                                placeholder="example@gmail.com" required />
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                            <input v-model="form.password" type="password" name="password" id="password" placeholder="••••••••"
                                class="bg-gray-50 border border-solid border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5 "
                                required />
                        </div>
                        <button @click="login()"
                            class="w-full text-white bg-primary focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center">Login</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
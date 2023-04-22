<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import Profile from '../setting/profile';

const router = useRouter();
let reset = ref(true);
let form = ref({
    email: '',
    newpassword: ''
});
let profile = ref({});

onMounted(async () => {
    profile.value = await Profile;
});

function nextStep() {
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
    reset.value = false;
}

function resetPassword() {
    if (form.value.newpassword == '') return Swal.fire({
        toast: true,
        position: 'top',
        showClass: {
            icon: 'animated heartBeat delay-1s'
        },
        icon: 'error',
        text: 'Please enter a new password',
        showConfirmButton: false,
        timer: 1000
    });

    const otp = Math.floor(Math.random() * 9000 + 1000);
    const formData = new FormData();
    formData.append('receiver', form.value.email);
    formData.append('email', form.value.email);
    formData.append('otp', otp);

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
            /*============ save otp to database =============*/
            axios.post('/api/storeOTP', formData).then(res => { console.log(res) }).catch(err => { console.log(err) });

            Swal.fire({
                toast: true,
                position: 'top',
                showClass: {
                    icon: 'animated heartBeat delay-1s'
                },
                icon: 'success',
                text: 'We send otp to your email',
                showConfirmButton: false,
                timer: 1000
            }).then(respone => { }).catch(err => { });
            router.replace(`/verifyresetpassword/${form.value.email}/${form.value.newpassword}`);
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

</script>

<template>
    <section class="bg-gray-50 h-screen bg-no-repeat bg-opacity-0 bg-[url('/image/bg.png')]"
        :style="'background-size: 100% 100%'">
        <div class="bg-black bg-opacity-20 flex flex-col items-center justify-center px-6 py-8 mx-auto h-screen lg:py-0">
            <Link to='/' class="flex items-center mb-6 text-2xl font-semibold text-white">
                <img class="w-8 h-8 mr-2" :src="profile.image" alt="logo" />
                {{profile.name}}
            </Link>

            <div v-if="reset" class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0 ">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                        Reset your password
                    </h1>
                    <div class="space-y-4 md:space-y-6">
                        <div>
                            <label htmlFor="email" class="block mb-4 text-sm font-medium text-gray-900">Enter your user
                                account's verified email address and we will send you a opt code.</label>
                            <input v-model="form.email" type="email" name="email" id="email"
                                class="bg-gray-50 border border-solid border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5 "
                                placeholder="Enter your email address" required="" />
                        </div>
                        <button @click="nextStep()"
                            class="w-full text-white bg-primary focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center">Next</button>
                    </div>
                </div>
            </div>

            <div v-else class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0 ">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                        Reset your password
                    </h1>
                    <div class="space-y-4 md:space-y-6">
                        <div>
                            <input v-model="form.newpassword" type="password"
                                class="bg-gray-50 border border-solid border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5 "
                                placeholder="Enter new password" required="" />
                        </div>
                        <button @click="resetPassword()"
                            class="w-full text-white bg-primary focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center">Reset</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
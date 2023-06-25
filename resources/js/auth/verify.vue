<script setup>
import { onMounted, onUpdated, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
const route = useRoute();
const router = useRouter();
let counter = ref(60);

let form = ref({
    num1: '',
    num2: '',
    num3: '',
    num4: ''
});

onMounted(() => {
    let interval = setInterval(() => {
        counter.value = counter.value - 1;
        if (counter.value == 0) {
            /*======= delete otp from databe =======*/
            axios.delete('/api/deleteOTP/' + route.params.email).then(res => { }).catch(err => { console.log(err) });
            Swal.fire({
                toast: true,
                position: 'top',
                showClass: {
                    icon: 'animated heartBeat delay-1s'
                },
                icon: 'info',
                text: "OTP was expired",
                showConfirmButton: false,
                timer: 1000
            });
            clearInterval(interval);
        }
    }, 1000);
});

function Resend() {
    counter.value = 60;
    form.value.num1 = form.value.num2 = form.value.num3 = form.value.num4 = "";
    const otp = Math.floor(Math.random() * 9000 + 1000);

    const formData = new FormData();
    formData.append('receiver', route.params.email);
    formData.append('email', route.params.email);
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

            let interval = setInterval(() => {
                counter.value = counter.value - 1;
                if (counter.value == 0) {
                    /*======= delete otp from databe =======*/
                    axios.delete('/api/deleteOTP/' + route.params.email).then(res => { }).catch(err => { console.log(err) });
                    Swal.fire({
                        toast: true,
                        position: 'top',
                        showClass: {
                            icon: 'animated heartBeat delay-1s'
                        },
                        icon: 'info',
                        text: "OTP was expired",
                        showConfirmButton: false,
                        timer: 1000
                    });
                    clearInterval(interval);
                }
            }, 1000);

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
            }).then(respone => { }).catch(err => { });
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

function Verify() {

    if (form.value.num1 == "" || form.value.num2 == "" || form.value.num3 == "" || form.value.num4 == "") return Swal.fire({
        toast: true,
        position: 'top',
        showClass: {
            icon: 'animated heartBeat delay-1s'
        },
        icon: 'warning',
        text: "Please complete your otp",
        showConfirmButton: false,
        timer: 1000
    });
    let otp = form.value.num1 + form.value.num2 + form.value.num3 + form.value.num4;

    const formData = new FormData();
    formData.append("email", route.params.email);
    formData.append("otp", otp);

    axios.post("/api/auth/verify", formData).then(res => {
        if (res.data.success) {
            Swal.fire({
                toast: true,
                position: 'top',
                showClass: {
                    icon: 'animated heartBeat delay-1s'
                },
                icon: 'success',
                text: res.data.message,
                showConfirmButton: false,
                timer: 1000
            }).then(res => {
                router.push("/login");
            });
        }
        else {
            Swal.fire({
                toast: true,
                position: 'top',
                showClass: {
                    icon: 'animated heartBeat delay-1s'
                },
                icon: 'warning',
                text: res.data.message,
                showConfirmButton: false,
                timer: 1000
            });
        }
    }).catch(err => { console.log(err); });
}

</script>

<template>
    <section class="bg-gray-50 h-screen bg-no-repeat bg-opacity-0 bg-[url('/image/bg.png')]"
        :style="'background-size: 100% 100%'">
        <div class="bg-black bg-opacity-20 flex flex-col items-center justify-center px-6 py-8 mx-auto h-screen lg:py-0">
            <div class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0 ">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <div class="flex flex-col items-center justify-center text-center space-y-2">
                        <div class="font-semibold text-3xl">
                            <p>Email Verification</p>
                        </div>
                        <div class="flex flex-row text-sm font-medium text-gray-400">
                            <p>We have sent a code to your email {{ route.params.email }}</p>
                        </div>
                    </div>
                    <div class="space-y-4 md:space-y-6">
                        <div class="flex flex-col space-y-16">
                            <div class="flex flex-row items-center justify-between mx-auto w-full max-w-xs">
                                <div class="w-16 h-16 ">
                                    <input v-model="form.num1" maxLength="1"
                                        class="w-full h-full flex flex-col items-center justify-center text-center px-5 outline-none input text-xl"
                                        type="text" name="" id="" />
                                </div>
                                <div class="w-16 h-16 ">
                                    <input v-model="form.num2" maxLength="1"
                                        class="w-full h-full flex flex-col items-center justify-center text-center px-5 outline-none input text-xl"
                                        type="text" name="" id="" />
                                </div>
                                <div class="w-16 h-16 ">
                                    <input v-model="form.num3" maxLength="1"
                                        class="w-full h-full flex flex-col items-center justify-center text-center px-5 outline-none input text-xl"
                                        type="text" name="" id="" />
                                </div>
                                <div class="w-16 h-16 ">
                                    <input v-model="form.num4" maxlength="1"
                                        class="w-full h-full flex flex-col items-center justify-center text-center px-5 outline-none input text-xl"
                                        type="text" name="" id="" />
                                </div>
                            </div>

                            <div class="flex flex-col space-y-5">
                                <div>
                                    <button @click="Verify()"
                                        class="flex flex-row items-center justify-center text-center w-full border rounded-lg outline-none py-3 bg-primary border-none text-white text-base shadow-sm">
                                        Verify Account
                                    </button>
                                </div>

                                <div
                                    class="flex flex-row items-center justify-center text-center text-sm font-medium space-x-1 text-gray-500">
                                    <p>Didn't recieve code?</p> <span @click="Resend()"
                                        :class="counter > 0 ? '' : 'cursor-pointer hover:underline'"
                                        class="flex flex-row items-center text-primary" target="_blank"
                                        rel="noopener noreferrer">{{ counter > 0 ? `OTP expired in ${counter}s`
                                            : "Resend OTP" }}</span>
                                </div>
                            </div>
                        </div>
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
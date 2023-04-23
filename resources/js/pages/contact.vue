<script setup>
import { ref } from 'vue';


const form = ref({
    name: '',
    sender: '',
    message: ''
});

const sendMessage = () => {
    if (form.value.message == "" || form.value.sender == "") return Swal.fire({
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
    formData.append('name', form.value.name);
    formData.append('sender', form.value.sender);
    formData.append('message', form.value.message);

    Swal.fire({
        toast: true,
        text: 'sending! please wait a minute!',
        position: 'top',
        allowEscapeKey: false,
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    /*============ send email =============*/
    axios.post('/api/sendAdmin', formData).then(res => {
        Swal.close();
        if (res.data.success) {
            form.value.name = form.value.sender = form.value.message = '';
            return Swal.fire({
                toast: true,
                position: 'top',
                showClass: {
                    icon: 'animated heartBeat delay-1s'
                },
                icon: 'success',
                text: 'Message was send',
                showConfirmButton: false,
                timer: 1000
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

</script>
<template>
    <div class="mycontainer h-[85vh]">
        <div class="h-full m-auto flex flex-col items-center justify-center">
            <div class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-xl xl:p-0 ">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                        Contact for get more information
                    </h1>
                    <div class="space-y-4 md:space-y-6">
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
                            <input v-model="form.name" type="text" name="name" id="name"
                                class="border border-solid border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5 "
                                placeholder="yourname" required />
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                            <input v-model="form.sender" type="email" name="email" id="email"
                                class="border border-solid border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5 "
                                placeholder="example@gmail.com" required />
                        </div>
                        <div>
                            <label for="message" class="block mb-2 text-sm font-medium text-gray-900">Message</label>
                            <textarea v-model="form.message" name="" id="message" placeholder='Write message here...'
                                class='text-sm h-[200px] input w-full resize-none'></textarea>
                        </div>
                        <button @click="sendMessage()" class="w-full text-white bg-primary focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center">Send Message</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
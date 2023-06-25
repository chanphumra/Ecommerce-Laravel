<script setup>
import { onMounted, ref } from 'vue';

let token = ref('');
let form = ref({
    description: '',

    //Column1
    title2: '',
    text2_1: '',
    text2_2: '',
    text2_3: '',
    text2_4: '',

    //Column2
    title3: '',
    text3_1: '',
    text3_2: '',
    text3_3: '',
    text3_4: '',

    //Column2
    title4: '',
    text4_1: '',
    text4_2: '',
    text4_3: '',
    text4_4: ''
})

onMounted(async () => {
    getFooter();
    token.value = sessionStorage.getItem('adminToken') || '';
})

const getFooter = async () => {
    const respone = await axios.get('/api/footer');

    if (respone.status == 200) {
        const data1 = respone.data.result[0];
        const data2 = respone.data.result[1];
        const data3 = respone.data.result[2];
        const data4 = respone.data.result[3];

        // column 1
        form.value.description = data1.description;

        // column 2
        form.value.title2 = data2.title;
        form.value.text2_1 = data2.text1;
        form.value.text2_2 = data2.text2;
        form.value.text2_3 = data2.text3;
        form.value.text2_4 = data2.text4;

        // column 3
        form.value.title3 = data3.title;
        form.value.text3_1 = data3.text1;
        form.value.text3_2 = data3.text2;
        form.value.text3_3 = data3.text3;
        form.value.text3_4 = data3.text4;

        // column 4
        form.value.title4 = data4.title;
        form.value.text4_1 = data4.text1;
        form.value.text4_2 = data4.text2;
        form.value.text4_3 = data4.text3;
        form.value.text4_4 = data4.text4;
    }
}

const updateFooter = async () => {
    const datas = [
        {
            id: 1,
            description: form.value.description,
            title: "",
            text1: "",
            text2: "",
            text3: "",
            text4: "",
        },
        {
            id: 2,
            description: "",
            title: form.value.title2,
            text1: form.value.text2_1,
            text2: form.value.text2_2,
            text3: form.value.text2_3,
            text4: form.value.text2_4,
        },
        {
            id: 3,
            description: "",
            title: form.value.title3,
            text1: form.value.text3_1,
            text2: form.value.text3_2,
            text3: form.value.text3_3,
            text4: form.value.text3_4,
        },
        {
            id: 4,
            description: "",
            title: form.value.title4,
            text1: form.value.text4_1,
            text2: form.value.text4_2,
            text3: form.value.text4_3,
            text4: form.value.text4_4,
        },
    ];

    for (let index = 0; index < datas.length; index++) {
        const data = datas[index];

        const formData = new FormData();
        formData.append('id', data.id);
        formData.append('description', data.description);
        formData.append('title', data.title);
        formData.append('text1', data.text1);
        formData.append('text2', data.text2);
        formData.append('text3', data.text3);
        formData.append('text4', data.text4);
        formData.append('_method', "PUT");

        await axios.post(`/api/footer`, formData, {
            headers: {
                'Authorization': `Bearer ${token.value}`,
                'Accept': 'application/json'
            }
        }).then(res => {
            console.log(res);
        }).catch(err => {
            console.log(err);
        });
    }
    Swal.fire({
        toast: true,
        position: 'top',
        showClass: {
            icon: 'animated heartBeat delay-1s'
        },
        icon: 'success',
        text: 'Footer has been updated',
        showConfirmButton: false,
        timer: 1000
    })
};
</script>
<template>
    <div class='lg:py-7 lg:px-10 p-5'>
        <div class="flex justify-between items-end">
            <h1 class='text-3xl font-bold text-black_500'>Footer Setting</h1>
            <button @click="updateFooter()" class='px-4 py-2 rounded-md bg-primary text-white text-sm cursor-pointer'>Save
                Change</button>
        </div>
        <div class="grid grid-cols md:grid-cols-2 mt-8 gap-4">
            <div class='p-4 bg-white rounded-lg shadow-md'>
                <h1 class='text-lg font-semibold mb-4'>Column 1</h1>
                <p class='text-base'>Description</p>
                <input v-model="form.description" type="text" class='input w-full mt-2' />
            </div>
            <div class='p-4 bg-white rounded-lg shadow-md'>
                <h1 class='text-lg font-semibold mb-4'>Column 2</h1>
                <p class='text-base'>Title</p>
                <input v-model="form.title2" type="text" class='input w-full mt-2' />
                <div class="flex gap-4">
                    <div class='w-full'>
                        <p class='text-base mt-2'>Text1</p>
                        <input v-model="form.text2_1" type="text" class='input w-full mt-2' />
                    </div>
                    <div class='w-full'>
                        <p class='text-base mt-2'>Text2</p>
                        <input v-model="form.text2_2" type="text" class='input w-full mt-2' />
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class='w-full'>
                        <p class='text-base mt-2'>Text3</p>
                        <input v-model="form.text2_3" type="text" class='input w-full mt-2' />
                    </div>
                    <div class='w-full'>
                        <p class='text-base mt-2'>Text4</p>
                        <input v-model="form.text2_4" type="text" class='input w-full mt-2' />
                    </div>
                </div>
            </div>
            <div class='p-4 bg-white rounded-lg shadow-md'>
                <h1 class='text-lg font-semibold mb-4'>Column 3</h1>
                <p class='text-base'>Title</p>
                <input v-model="form.title3" type="text" class='input w-full mt-2' />
                <div class="flex gap-4">
                    <div class='w-full'>
                        <p class='text-base mt-2'>Text1</p>
                        <input v-model="form.text3_1" type="text" class='input w-full mt-2' />
                    </div>
                    <div class='w-full'>
                        <p class='text-base mt-2'>Text2</p>
                        <input v-model="form.text3_2" type="text" class='input w-full mt-2' />
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class='w-full'>
                        <p class='text-base mt-2'>Text3</p>
                        <input v-model="form.text3_3" type="text" class='input w-full mt-2' />
                    </div>
                    <div class='w-full'>
                        <p class='text-base mt-2'>Text4</p>
                        <input v-model="form.text3_4" type="text" class='input w-full mt-2' />
                    </div>
                </div>
            </div>
            <div class='p-4 bg-white rounded-lg shadow-md'>
                <h1 class='text-lg font-semibold mb-4'>Column 4</h1>
                <p class='text-base'>Title</p>
                <input v-model="form.title4" type="text" class='input w-full mt-2' />
                <div class="flex gap-4">
                    <div class='w-full'>
                        <p class='text-base mt-2'>Text1</p>
                        <input v-model="form.text4_1" type="text" class='input w-full mt-2' />
                    </div>
                    <div class='w-full'>
                        <p class='text-base mt-2'>Text2</p>
                        <input v-model="form.text4_2" type="text" class='input w-full mt-2' />
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class='w-full'>
                        <p class='text-base mt-2'>Text3</p>
                        <input v-model="form.text4_3" type="text" class='input w-full mt-2' />
                    </div>
                    <div class='w-full'>
                        <p class='text-base mt-2'>Text4</p>
                        <input v-model="form.text4_4" type="text" class='input w-full mt-2' />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { computed } from '@vue/reactivity';
import { onMounted, ref } from 'vue';
import { RouterLink, useRouter, useRoute } from 'vue-router';

const router = useRouter();
const route = useRoute();
const params = computed(() => {
    return route.params;
});

let token = ref('');
let form = ref({
    c_id: '',
    name: '',
    description: '',
    price: '',
    sale_price: '',
    qty: '',
    discount: '',
    image: []
});
let imagePreview = ref([]);
let categories = ref([]);

onMounted(async () => {
    getCategory();
    token.value = sessionStorage.getItem('adminToken') || '';
});

const getCategory = async () => {
    const respone = await axios.get('/api/category');
    categories = respone.data.result;
    getProduct();
}

const getProduct = async () => {
    const respone = await axios.get('/api/product/' + params.value.id);
    form.value.name = respone.data.result.name;
    form.value.description = respone.data.result.description;
    form.value.price = respone.data.result.price;
    form.value.sale_price = respone.data.result.sale_price;
    form.value.qty = respone.data.result.qty;
    form.value.discount = respone.data.result.discount;
    form.value.c_id = respone.data.result.category.id;
    imagePreview.value.push(respone.data.result.image1);
    imagePreview.value.push(respone.data.result.image2);
    imagePreview.value.push(respone.data.result.image3);
}

function previewImage(image) {
    if (form.value.image.length > 0)
        return URL.createObjectURL(image);
    return image;
}

function browseImage(e) {
    form.value.image = [];
    const files = e.target.files;
    const allowExtenstions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    for (let index = 0; index < files.length; index++) {
        if (allowExtenstions.exec(files[index]['name']))
            form.value.image.push(files[index]);
    }
}

const updateProduct = () => {
    if (form.value.name == '' || form.value.description == "" || form.value.price == "" || form.value.sale_price == "" || form.value.qty == "" || form.value.c_id == "") return Swal.fire({
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

    if (form.value.image.length > 0 && form.value.image.length < 3) return Swal.fire({
        toast: true,
        position: 'top',
        showClass: {
            icon: 'animated heartBeat delay-1s'
        },
        icon: 'error',
        text: 'Please choose three images',
        showConfirmButton: false,
        timer: 1000
    });

    const formData = new FormData();
    formData.append('c_id', form.value.c_id);
    formData.append('name', form.value.name);
    formData.append('description', form.value.description);
    formData.append('price', form.value.price);
    formData.append('sale_price', form.value.sale_price);
    formData.append('qty', form.value.qty);
    formData.append('discount', form.value.discount);
    formData.append('image1', form.value.image[0]);
    formData.append('image2', form.value.image[1]);
    formData.append('image3', form.value.image[2]);
    formData.append('_method', "PUT");
    
    axios.post('/api/product/' + params.value.id, formData, {
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
            text: 'Product has been updated',
            showConfirmButton: false,
            timer: 1000
        }).then(r => {
            router.push('/admin/show_product');
        });
    }).catch(err => {
        console.log(err);
    });
}
</script>

<template>
    <div class='lg:py-7 lg:px-10 p-5'>
        <div class="flex justify-between items-end">
            <h1 class='text-3xl font-bold text-black_500'>Edit a product</h1>
            <button @click="updateProduct()"
                class='px-4 py-2 rounded-md bg-primary text-white text-sm cursor-pointer'>Edit
                product</button>
        </div>
        <div class="mt-10 flex flex-col gap-8 md:flex-row">
            <div class='flex-[4]'>
                <h1 class='text-xl font-semibold text-gray-800'>Product Title</h1>
                <div class="mt-3">
                    <input type="text" name="" id="" class='input text-sm w-full' placeholder='Write title here...'
                        v-model="form.name" />
                </div>
                <div class="mt-7">
                    <h1 class='text-xl font-semibold text-gray-800'>Product Description</h1>
                    <div class='mt-3'>
                        <textarea name="" id="" placeholder='Write a description here...'
                            class='text-sm h-[200px] input w-full resize-none' v-model="form.description"></textarea>
                    </div>
                </div>

                <div class="mt-7">
                    <h1 class='text-xl font-semibold text-gray-800'>Display images
                        <span class='text-[12px] text-red-500'> ( 3 images require )</span>
                    </h1>
                    <div class="inline-flex gap-4 mt-2 mr-2" v-if="form.image.length > 0">
                        <div v-for="item in form.image"
                            class='relative w-20 h-20 p-[2px] rounded-lg border-solid border border-gray-300 overflow-hidden'>
                            <img :src="previewImage(item)" alt="" class='w-full h-full rounded-lg object-cover' />
                        </div>
                    </div>
                    <div class="inline-flex gap-4 mt-2 mr-2" v-else>
                        <div v-for="item in imagePreview"
                            class='relative w-20 h-20 p-[2px] rounded-lg border-solid border border-gray-300 overflow-hidden'>
                            <img :src="previewImage(item)" alt="" class='w-full h-full rounded-lg object-cover' />
                        </div>
                    </div>

                    <div
                        class="relative h-[200px] mt-3 border-dashed border-2 border-gray-300 rounded-lg flex flex-col justify-center items-center">
                        <i class="fas fa-cloud-upload text-primary text-[46px]"></i>
                        <p class='text-[15px] text-gray-600'>Browse product image</p>
                        <input class='absolute w-full h-full opacity-0 cursor-pointer' type="file" name="" id=""
                            accept="image/*" multiple @change="browseImage" />
                    </div>
                </div>

                <div class="border border-solid border-gray-300 rounded-lg p-4 mt-8 bg-white">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                        <div class='w-full'>
                            <p class='mb-2 text-gray-800 text-[15px] font-semibold'>Regular price</p>
                            <input type="text" placeholder='$$$' class='input w-full' v-model="form.price" />
                        </div>
                        <div class='w-full'>
                            <p class='mb-2 text-gray-800 text-[15px] font-semibold'>Sale price</p>
                            <input type="text" placeholder='$$$' class='input w-full' v-model="form.sale_price" />
                        </div>
                    </div>
                    <div class='w-full mt-4'>
                        <p class='mb-2 text-gray-800 text-[15px] font-semibold'>Add to stock</p>
                        <input type="text" placeholder='Quantity' class='input w-full' v-model="form.qty" />
                    </div>
                    <div class='w-full mt-4'>
                        <p class='mb-2 text-gray-800 text-[15px] font-semibold'>Discount</p>
                        <input type="text" placeholder='0.00%' class='input w-full' v-model="form.discount" />
                    </div>
                </div>
            </div>

            <div class='flex-[2]'>
                <div class="border-solid border border-gray-300 rounded-lg p-4 h-[305px] bg-white mt-2 md:mt-10">
                    <div class="flex justify-between items-center">
                        <p class='text-xl font-semibold text-gray-800'>Category</p>
                        <RouterLink :to="'/admin/add_category'">
                            <p class='text-sm cursor-pointer font-semibold text-primary hover:underline'>Add new category
                            </p>
                        </RouterLink>
                    </div>
                    <select name="" id="" class="w-full mt-4 text-[14px] cursor-pointer" v-model="form.c_id">
                        <option v-for="item in categories" :value="item.id">{{ item.name }}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</template>
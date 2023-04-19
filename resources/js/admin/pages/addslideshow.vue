<script setup>

</script>

<template>
     <div class='lg:py-7 lg:px-10 p-5'>
                <div class="flex justify-between items-end">
                    <h1 class='text-3xl font-bold text-black_500'>Add a slideshow</h1>
                    <button class='px-4 py-2 rounded-md bg-primary text-white text-sm cursor-pointer'>Publish slideshow</button>
                </div>
                <div class="mt-10 flex flex-col gap-8 md:flex-row">
                    <div class='flex-[4]'>
                        <div class="flex justify-between">
                            <h1 class='text-xl font-semibold text-gray-800'>Title</h1>
                            <div class="flex gap-2 items-center" >
                                <input ref={enableRef} type="checkbox" name="" id="enable" class='w-4 h-4 cursor-pointer ml-2  border-solid border border-gray-500 rounded-[4px] checked:rounded-[4px]' />
                                <label htmlFor="enable" class='text-md cursor-pointer'>Enable</label>
                            </div>
                        </div>
                        <div class="mt-3">
                            <input ref={titleRef} type="text" name="" id="" class='input text-sm w-full' placeholder='Write title here...' />
                        </div>
                        <div class="mt-7">
                            <h1 class='text-xl font-semibold text-gray-800'>Description</h1>
                            <div class='mt-3'>
                                <textarea ref={textRef} name="" id="" placeholder='Write a description here...' class='text-sm h-[200px] input w-full resize-none'></textarea>
                            </div>
                        </div>
                        <div class="flex justify-between mt-7">
                            <h1 class='text-xl font-semibold text-gray-800'>Link</h1>
                        </div>
                        <div class="mt-3">
                            <input ref={linkRef} type="text" name="" id="" class='input text-sm w-full' placeholder='Write link here...' />
                        </div>

                        <div class="mt-7">
                            <h1 class='text-xl font-semibold text-gray-800'>Display images</h1>
                            
                                
                                <div class="inline-flex gap-4 mt-7">
                                    <div class='relative w-20 h-20 p-[2px] rounded-lg border-solid border border-gray-300 overflow-hidden'>
                                        <div @click='' class='absolute right-[2px] top-[2px] cursor-pointer'>
                                            <IoClose color='white' class='bg-red-500 w-4 h-4 rounded-full p-[0.1rem]' />
                                        </div>
                                        <img src={image} alt="" class='w-full h-full rounded-lg object-cover' />
                                    </div>
                                </div>
                            

                            <div class="relative h-[200px] mt-3 border-dashed border-2 border-gray-300 rounded-lg flex flex-col justify-center items-center">
                                <MdCloudUpload class='text-primary text-[46px]' />
                                <p class='text-[15px] text-gray-600'>Browse slideshow image</p>
                                <input  ref={imageRef} class='absolute w-full h-full opacity-0 cursor-pointer' type="file" name="" id="" accept="image/*" />
                            </div>
                        </div>
                    </div>

                </div>
            </div>
</template>
<script setup>
    import Header from "../layout/header.vue";
</script>

<template>
    <Header />
    <div class="lg:ml-[250px]" @click="open = !open">
        <RouterView></RouterView>
    </div>
</template>

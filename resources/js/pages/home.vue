<script setup>
    import slideshow from '../components/slideshow.vue';
    import newarrival from '../components/newarrival.vue';
    import bigdiscount from '../components/bigdiscount.vue';
</script>

<template>
    <slideshow />
    <div className="mycontainer m-auto">
        <newarrival />
        <bigdiscount />
    </div>
</template>
<template>
    <div class="text-center error">
        <i class="fa fa-bomb"></i>
        <h1 class="mt-4">We've encountered a problem</h1>
        <h2>Unfortunately we can not process</h2>
    </div>
</template>

<script>
    export default {
        name: "FatalError"
    }
</script>

<style scoped>
    .error {
        color: gray;
        font-size: 10rem;
    }
</style>

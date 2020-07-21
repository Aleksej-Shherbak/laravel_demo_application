<template>
    <div class="text-center success">
        <i class="fa fa-thumbs-up"></i>
        <h1 class="mt-4">Success!</h1>
        <h2>
            <slot></slot>
        </h2>
    </div>
</template>

<script>
    export default {
        name: "Success"
    }
</script>

<style scoped>
    .success {
        color: gray;
        font-size: 10rem;
    }
</style>

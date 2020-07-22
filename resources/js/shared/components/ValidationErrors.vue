<template>
    <div>
        <div class="invalid-feedback"
             v-for="(error, index) in errors" :key="key()">
            {{ error }}
        </div>
    </div>
</template>

<script>
    import uniqueKey from "../mixins/uniqueKey";

    export default {
        name: "ValidationErrors",
        props: ['errors'],
        mixins: [uniqueKey],
        methods: {

        }
    }
</script>

<style scoped>
    .form-control.is-invalid ~ div > .invalid-feedback {
        display: block;
    }
</style>

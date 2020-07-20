<template>
    <div>
        <div class="invalid-feedback"
             v-for="(error, index) in errors" :key="key()">
            {{ error }}
        </div>
    </div>
</template>

<script>
    import { v4 as uuidv4 } from 'uuid';

    export default {
        name: "ValidationErrors",
        props: ['errors'],
        methods: {
            key(index) {
                return uuidv4('error', index);
            }
        }
    }
</script>

<style scoped>
    .form-control.is-invalid ~ div > .invalid-feedback {
        display: block;
    }
</style>

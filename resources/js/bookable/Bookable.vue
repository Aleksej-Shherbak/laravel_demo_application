<template>
    <div>Bookable</div>
</template>

<script>
    export default {
        name: "Bookable",
        created() {
            axios.get(`/api/bookables/${this.$route.params.id}`)
            .then(res => {
                this.bookable = res.data
            });

        },
        data() {
            return {
                bookable: null,
            };
        }
    }
</script>

<style scoped>

</style>

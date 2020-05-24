<template>
    <div class="row">
        <div class="col-md-8 pb-4">
            <div class="card">
                <div class="card-body">
                    <template v-if="!loading">
                        <h5>{{ bookable.title }}</h5>
                        <hr>
                        <article>{{ bookable.description }}</article>
                    </template>
                    <div class="card-text" v-else>Loading ...</div>
                </div>
            </div>
        </div>
        <div class="col-md-4 pb-4">
            <availability></availability>
        </div>
    </div>
</template>

<script>
    import Availability from "./Availability";

    export default {
        name: "Bookable",
        components: {
            Availability
        },
        created() {
            this.loading = true;
            axios.get(`/api/bookables/${this.$route.params.id}`)
            .then(res => {
                this.bookable = res.data.data;
                this.loading = false;
            });

        },
        data() {
            return {
                loading: false,
                bookable: null,
            };
        }
    }
</script>

<style scoped>

</style>

<template>
    <div style="padding: 1.25rem">
        <h6 class="text-uppercase text-secondary font-weight-bold pt-4">Review list</h6>

        <div v-if="loading">Loading ...</div>
        <div v-else>
            <div class="border-bottom" v-for="(review, i) in reviews" :key="i">
                <div class="row pt-4">
                    <div class="col-md-6">Aleksej Shherbak (mock)</div>
                    <div class="col-md-6 d-md-flex justify-content-end">
                        <star-rating :value="review.rating" class="fa-lg"></star-rating>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">{{ review.created_at | fromNow }}</div>
                </div>
                <div class="row pt-4 pb-4">
                    <div class="col-md-12">
                        {{ review.content }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import StarRating from "../shared/components/StarRating";
    export default {
        name: "ReviewList",
        components: {StarRating},
        data() {
            return {
                loading: false,
                reviews: null,
            }
        },
        props: {
            bookableId: Number
        },
        created() {
            this.loading = true;

            axios.get(`/api/bookables/${this.bookableId}/reviews`)
                .then(response => this.reviews = response.data.data)
                .then(() => this.loading = false);
        }
    }
</script>

<style scoped>

</style>

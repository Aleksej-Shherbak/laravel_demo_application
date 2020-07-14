<template>
    <div>
        <div v-if="loading">Loading</div>
        <div v-else>
            <div v-if="existingReview">
                You've already left a review for this booking!
            </div>
            <div v-else>
                <div class="form-group">
                    <label class="text-muted">Select the star rating (from 1 to 5)</label>
                    <star-rating class="fa-3x" v-model="review.rating"></star-rating>
                </div>
                <div class="form-group">
                    <label for="content" class="text-muted">Describe your experience with</label>
                    <textarea v-model="review.content" id="content" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <button class="btn btn-primary btn-lg btn-block">Submit</button>
            </div>
        </div>
    </div>
</template>

<script>
    import StarRating from "../shared/components/StarRating";

    export default {
        name: "Review",
        components: {StarRating},
        methods: {},
        created() {
            this.loading = true;
            // Check if review already exists
            axios.get(`/api/reviews/${this.$route.params.id}`)
                .then(res => {
                    this.existingReview = true
                })
                .catch(err => {
                    //
                }).finally(() => {
                this.loading = false;
            })
            // Fetch a booking ny a review key
            // Store the review

        },
        data() {
            return {
                review: {
                    rating: 0,
                    content: null
                },
                existingReview: false,
                loading: false,
            }
        },
        computed: {

        }
    }
</script>

<style scoped>

</style>

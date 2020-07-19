<template>
    <div class="row">
        <div :class="[{'col-md-4': !alreadyReviewed}, {'d-none': alreadyReviewed}]">
            <div class="card">
                <div class="card-body">
                    <div v-if="loading">Loading...</div>
                    <div v-else>
                       <p>
                           Stayed at <router-link :to="{name: 'bookable',
                            params: {id: booking.bookable.bookable_id}}">
                           {{ booking.bookable.title}}
                       </router-link>
                       </p>
                        <p>From {{ booking.from}} to {{ booking.to }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div :class="[{'col-md-8': !alreadyReviewed }, {'col-md-12': alreadyReviewed}]">
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
                    this.existingReview = res.data
                })
                .catch(err => {
                    // Fetch a booking ny a review key
                    if (err.response && err.response.status && err.response.status === 404) {
                        return axios.get(`/api/booking-by-review/${this.$route.params.id}`)
                            .then(response => {
                                this.booking = response.data.data
                            })
                    }
                }).then(() => {
                this.loading = false;
            })
            // Store the review

        },
        data() {
            return {
                review: {
                    rating: 0,
                    content: null
                },
                existingReview: null,
                loading: false,
                booking: null,
            }
        },
        computed: {
            alreadyReviewed() {
                return this.hasReview || !this.booking
            },
            hasReview() {
                return this.existingReview !== null;
            },
            hasBooking() {
                return this.booking !== null;
            }
        }
    }
</script>

<style scoped>

</style>

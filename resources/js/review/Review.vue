<template>
    <div>
        <fatal-error v-if="error"></fatal-error>
        <div class="row" v-else>
            <div :class="[{'col-md-4': twoColumns}, {'d-none': oneColumn}]">
                <div class="card">
                    <div class="card-body">
                        <div v-if="loading">Loading...</div>
                        <div v-if="hasBooking">
                            <p>
                                Stayed at
                                <router-link :to="{name: 'bookable',
                            params: {id: booking.bookable.bookable_id}}">
                                    {{ booking.bookable.title}}
                                </router-link>
                            </p>
                            <p>From {{ booking.from}} to {{ booking.to }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div :class="[{'col-md-8': twoColumns }, {'col-md-12': oneColumn}]">
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
                            <textarea v-model="review.content" id="content" cols="30" rows="10"
                                      class="form-control"
                                      :class="[{'is-invalid': errorFor('content')}]"></textarea>
                            <v-errors :errors="errorFor('content')"></v-errors>
                        </div>
                        <button class="btn btn-primary btn-lg btn-block"
                                @click.prevent="submit" :disabled="sanding">
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import StarRating from "../shared/components/StarRating";
    import {is404, is422} from "../shared/utils/response";
    import FatalError from "../shared/components/FatalError";

    export default {
        name: "Review",
        components: {FatalError, StarRating},
        methods: {
            submit() {
                this.errors = null;
                this.sanding = true;
                axios.post(`/api/reviews`, this.review)
                    .then(res => (console.log(res)))
                    .catch(err => {
                        if (is422(err)) {
                            const errors = err.response.data.errors;
                            if (errors['content'] && _.size(errors) === 1) {
                                this.errors = errors;
                                return;
                            }
                        }

                        this.error = true;
                    })
                    .then((res) => (this.sanding = false));
            },
            errorFor(field) {
                return this.errors !== null && this.errors[field] ? this.errors[field] : null;
            },
        },
        created() {
            this.review.id = this.$route.params.id;
            this.loading = true;
            // Check if review already exists
            axios.get(`/api/reviews/${this.review.id}`)
                .then(res => {
                    this.existingReview = res.data
                })
                .catch(err => {
                    // Fetch a booking by a review key
                    if (is404(err)) {
                        return axios.get(`/api/booking-by-review/${this.review.id}`)
                            .then(response => {
                                this.booking = response.data.data
                            })
                            .catch((err) => {
                                if (!is404(err)) {
                                    this.error = true;
                                }
                            })
                    }

                    this.error = true;
                }).then(() => {
                this.loading = false;
            })

        },
        data() {
            return {
                review: {
                    id: null,
                    rating: 5,
                    content: null
                },
                existingReview: null,
                loading: false,
                sanding: false,
                booking: null,
                error: false,
                errors: null,
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
            },
            oneColumn() {
                return this.alreadyReviewed
            },
            twoColumns() {
                return !this.alreadyReviewed
            }
        }
    }
</script>

<style scoped>

</style>

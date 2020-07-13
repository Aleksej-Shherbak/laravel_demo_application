<template>
    <div>
        <div class="form-group">
            <label class="text-muted">Select the star rating (from 1 to 5)</label>
            <star-rating class="fa-3x" v-model="review.rating"></star-rating>
        </div>
        <div class="form-group">
            <label for="content" class="text-muted">Describe your experience with</label>
            <textarea name="" id="content" cols="30" rows="10" class="form-control"></textarea>
        </div>
        <button class="btn btn-primary btn-lg btn-block">Submit</button>
    </div>
</template>

<script>
    import StarRating from "../shared/components/StarRating";
    export default {
        name: "Review",
        components: {StarRating},
        methods: {

        },
        data() {
            return {
                review: {
                    rating: 0,
                    content: null
                }
            }
        }
    }
</script>

<style scoped>

</style>

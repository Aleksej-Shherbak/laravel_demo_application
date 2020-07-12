<template>
    <div class="d-flex">
        <i class="fas fa-star" v-for="star in fullStars" :key="`full` + star"></i>
        <i class="fas fa-star-half-alt" v-if="halStar"></i>
        <i class="far fa-star" v-for="star in emptyStars" :key="`empty` + star"></i>
    </div>
</template>

<script>
    export default {
        name: "StarRating",
        props: {
            rating: Number,
        },
        computed: {
            halStar() {
                return false;
            },
            fullStars() {
                return 4;
            },
            emptyStars() {
                return 1;
            }
        }
    }
</script>

<style scoped>

</style>

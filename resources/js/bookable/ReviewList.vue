<template>
    <div style="padding: 1.25rem">
        <h6 class="text-uppercase text-secondary font-weight-bold pt-4">Review list</h6>

        <div class="border-bottom" v-for="i in 3" :key="i">
            <div class="row pt-4">
                <div class="col-md-6">Aleksej Shherbak</div>
                <div class="col-md-6 d-md-flex justify-content-end">STAR RATING</div>
            </div>
            <div class="row">
                <div class="col-md-12">Added 12 minutes ago</div>
            </div>
            <div class="row pt-4 pb-4">
                <div class="col-md-12">
                    Content of the review
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ReviewList"
    }
</script>

<style scoped>

</style>

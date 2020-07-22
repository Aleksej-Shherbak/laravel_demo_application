<template>
    <div>
        <h6 class="text-uppercase text-secondary font-weight-bold">
            Price breakdown
        </h6>

        <div v-for="(price, days) in price.breakdown" :key="key()"
             class="py-2 border-bottom border-top d-flex justify-content-between">
            <span>{{ days }} x ${{ price }}</span>
            <span>${{ days * price }}</span>
        </div>
        <div class="pt-2 font-weight-bold d-flex justify-content-between">
            <span>Total</span>
            <span>${{ price.total }}</span>
        </div>
    </div>

</template>

<script>
    import uniqueKey from "../shared/mixins/uniqueKey";

    export default {
        name: "PriceBreakdown",
        mixins: [uniqueKey],
        props: {
            price: Object,
        }
    }
</script>

<style scoped>

</style>

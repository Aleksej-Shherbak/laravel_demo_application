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
            <review-list :bookable-id="bookableId"></review-list>
        </div>
        <div class="col-md-4 pb-4">
            <availability :bookable-id="bookableId" @availability="checkPrice($event)"
            class="mb-4"></availability>

            <transition name="fade">
                <price-breakdown :price="price" v-if="price" class="mb-4"></price-breakdown>
            </transition>

            <transition name="fade">
                <button class="btn btn-outline-secondary btn-block" v-if="price">Book now!</button>
            </transition>
        </div>
    </div>
</template>

<script>
    import Availability from "./Availability";
    import ReviewList from "./ReviewList";
    import PriceBreakdown from "../components/PriceBreakdown";
    import {mapState} from  'vuex';

    export default {
        name: "Bookable",
        components: {
            Availability,
            ReviewList,
            PriceBreakdown,
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
                price: null,
            };
        },
        computed: {
            ...mapState({
                lastSearch: 'lastSearch',
            }),
            bookableId() {
                return parseInt(this.$route.params.id);
            }
        },
        methods: {
            async checkPrice(hasAvailability) {
                if (!hasAvailability) {
                    this.price = null;
                    return;
                }

                try {
                    this.price =
                        (await axios.get(
                            `/api/bookables/${this.bookableId}/price?`
                                + `from=${this.lastSearch.from}&to=${this.lastSearch.to}`)
                        ).data.data;
                } catch (e) {
                    this.price = null;
                }
            }
        }
    }
</script>

<style scoped>

</style>

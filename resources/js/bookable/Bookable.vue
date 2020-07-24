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
                <button class="btn btn-outline-secondary btn-block" v-if="price"
                        @click="addToBasket" :disabled="inBasketAlready">Book now!
                </button>
            </transition>

            <transition name="fade">
                <button class="btn btn-outline-secondary btn-block" v-if="inBasketAlready"
                        @click="removeFromBasket">Remove from basket
                </button>
            </transition>

            <small v-if="inBasketAlready" class="text-muted">
                Seems like you've added this to basket already. If you want to change date, remove from the basket
                first.
            </small>
        </div>
    </div>
</template>

<script>
    import Availability from "./Availability";
    import ReviewList from "./ReviewList";
    import PriceBreakdown from "../components/PriceBreakdown";
    import {mapState, mapGetters} from 'vuex';

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
            inBasketAlready() {
                if (this.bookable === null) {
                    return false;
                }

                return this.$store.getters.inBasketAlready(this.bookable.id);
            },
            bookableId() {
                return parseInt(this.$route.params.id);
            },

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
            },
            addToBasket() {
                this.$store.dispatch('addToBasket', {
                    bookable: this.bookable,
                    price: this.price,
                    dates: this.lastSearch,
                })
            },
            removeFromBasket() {
                this.$store.dispatch('removeFromBasket', this.bookable.id);
            },
        }
    }
</script>

<style scoped>

</style>

<template>
    <div>
        <success v-if="success">
            Congratulations! Your purchase is done!
        </success>
        <div class="row" v-else>
            <div class="col-md-8" v-if="itemsInBasket">
                <div class="form-row">
                    <div class="col-md-6 form-group">
                        <label for="first-name">First name</label>
                        <input type="text" id="first-name" v-model="customer.first_name" class="form-control"
                               :class="[{'is-invalid': this.errorFor('customer.first_name')}]">
                        <v-errors :errors="errorFor('customer.first_name')"></v-errors>

                    </div>
                    <div class="col-md-6 form-group">
                        <label for="last-name">Last name</label>
                        <input type="text" id="last-name" v-model="customer.last_name" class="form-control"
                               :class="[{'is-invalid': this.errorFor('customer.last_name')}]">
                        <v-errors :errors="errorFor('customer.last_name')"></v-errors>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" v-model="customer.email" class="form-control"
                               :class="[{'is-invalid': this.errorFor('customer.email')}]">
                        <v-errors :errors="errorFor('customer.first_name')"></v-errors>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 form-group">
                        <label for="street">Street</label>
                        <input type="text" id="street" v-model="customer.street" class="form-control"
                               :class="[{'is-invalid': this.errorFor('customer.street')}]">
                        <v-errors :errors="errorFor('customer.street')"></v-errors>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="city">City</label>
                        <input type="text" id="city" v-model="customer.city" class="form-control"
                               :class="[{'is-invalid': this.errorFor('customer.city')}]">
                        <v-errors :errors="errorFor('customer.city')"></v-errors>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 form-group">
                        <label for="country">Country</label>
                        <input type="text" id="country" v-model="customer.country" class="form-control"
                               :class="[{'is-invalid': this.errorFor('customer.country')}]">
                        <v-errors :errors="errorFor('customer.country')"></v-errors>

                    </div>
                    <div class="col-md-4 form-group">
                        <label for="state">State</label>
                        <input type="text" id="state" v-model="customer.state" class="form-control"
                               :class="[{'is-invalid': this.errorFor('customer.state')}]">
                        <v-errors :errors="errorFor('customer.state')"></v-errors>

                    </div>
                    <div class="col-md-2 form-group">
                        <label for="zip-code">Zip code</label>
                        <input type="text" id="zip-code" v-model="customer.zip" class="form-control"
                               :class="[{'is-invalid': this.errorFor('customer.zip')}]">
                        <v-errors :errors="errorFor('customer.zip')"></v-errors>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <button type="submit" class="btn btn-block btn-lg btn-primary"
                                @click.prevent="book" :disabled="loading">
                            Book now!
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-8" v-else>
                <div class="jumbotron jumbotron-fluid text-center">
                    <h1>Basket is empty</h1>
                </div>
            </div>

            <div class="col-md-4">
                <div class="d-flex justify-content-between">
                    <h6 class="text-uppercase text-secondary font-weight-bold">Your Cart</h6>
                    <h6 class="badge badge-secondary text-uppercase">
                        <span v-if="itemsInBasket">Items: {{ itemsInBasket }}</span>
                        <span v-else>Empty</span>
                    </h6>
                </div>

                <transition-group name="fade">
                    <div v-for="item in basket" :key="item.bookable.id">
                        <div class="py-2 border-top d-flex justify-content-between">
                    <span>
                        <router-link :to="{name: 'bookable', params: {id: item.bookable.id}}">
                            {{ item.bookable.title }}
                        </router-link>
                    </span>
                            <span class="font-weight-bold">
                        ${{ item.price.total }}
                    </span>
                        </div>

                        <div class="py-2 d-flex justify-content-between">
                            <span>From {{ item.dates.from }}</span>
                            <span>To {{ item.dates.to }}</span>
                        </div>

                        <div class="py-2 text-right">
                            <button class="btn btn-sm btn-outline-secondary"
                                    @click="$store.dispatch('removeFromBasket', item.bookable.id)">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </transition-group>


            </div>

        </div>
    </div>

</template>

<script>
    import {mapActions, mapGetters, mapState} from 'vuex';
    import validationErrors from "../shared/mixins/validationErrors";
    import Success from "../shared/components/Success";

    export default {
        name: "Basket",
        components: {Success},
        mixins: [validationErrors],
        computed: {
            ...mapGetters(['itemsInBasket']),
            ...mapState({
                basket: state => state.basket.items
            }),
            success() {
                return !this.loading && !this.itemsInBasket && this.bookingAttempted;
            }
        },
        data() {
            return {
                loading: false,
                bookingAttempted: false,
                customer: {
                    first_name: null,
                    last_name: null,
                    email: null,
                    street: null,
                    city: null,
                    state: null,
                    zip: null,
                    country: null,
                }
            }
        },
        methods: {
            ...mapActions(['clearBasket']),
            async book() {
                this.errors = null;
                this.loading = true;
                this.bookingAttempted = false;

                try {
                    await axios.post('/api/checkout', {
                        customer: this.customer,
                        bookings: this.basket.map(x => ({
                            bookable_id: x.bookable.id,
                            from: x.dates.from,
                            to: x.dates.to,
                        })),
                    });
                    this.clearBasket();
                    this.bookingAttempted = true;
                } catch (e) {
                    this.errors = e.response && e.response.data.errors;
                }

                this.loading = false;
            }
        }
    }
</script>

<style scoped>
    h6.badge {
        font-size: 100%;
    }

    a {
        color: black;
    }
</style>

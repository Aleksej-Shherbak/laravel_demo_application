<template>
    <div class="row">
        <div class="col-md-8">
            <div class="form-row">
                <div class="col-md-6 form-group">
                    <label for="first-name">First name</label>
                    <input type="text" id="first-name" class="form-control">
                </div>
                <div class="col-md-6 form-group">
                    <label for="last-name">Last name</label>
                    <input type="text" id="last-name" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 form-group">
                    <label for="street">Street</label>
                    <input type="text" id="street" class="form-control">
                </div>

                <div class="col-md-6 form-group">
                    <label for="city">City</label>
                    <input type="text" id="city" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 form-group">
                    <label for="country">Country</label>
                    <input type="text" id="country" class="form-control">
                </div>
                <div class="col-md-4 form-group">
                    <label for="state">State</label>
                    <input type="text" id="state" class="form-control">
                </div>
                <div class="col-md-2 form-group">
                    <label for="zip-code">Zip code</label>
                    <input type="text" id="zip-code" class="form-control">
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12 form-group">
                    <button type="submit" class="btn btn-block btn-lg btn-primary">
                        Book now!
                    </button>
                </div>
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
</template>

<script>
    import {mapGetters, mapState} from 'vuex';

    export default {
        name: "Basket",
        computed: {
            ...mapGetters(['itemsInBasket']),
            ...mapState({
                basket: state => state.basket.items
            })
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

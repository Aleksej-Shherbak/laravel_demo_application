<template>
    <div>
        <nav class="navbar bg-white border-bottom navbar-light">
            <router-link class="navbar-brand mr-auto" :to="{name: 'home'}">Home</router-link>

            <router-link class="btn " :to="{name: 'basket'}">
                Basket
                <span v-if="itemsInBasket" class="badge badge-secondary">{{ itemsInBasket}}</span>
            </router-link>
        </nav>

        <div class="container my-4 px-4">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    import {mapState, mapGetters} from 'vuex'

    export default {
        name: "Index",
        data() {
            return {
                lastSearch: this.$store.state.lastSearch
            }
        },

        // Test mapState!
        computed: {
            ...mapState({
                lastSearchComputed: 'lastSearch'
            }),
            ...mapGetters({
                itemsInBasket: 'itemsInBasket'
            }),

        }
    }
</script>

<style scoped>

</style>

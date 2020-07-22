require('./bootstrap');

import router from "./routes";
import VueRouter from 'vue-router'
import Vuex from 'vuex';
import moment from 'moment';

import Index from "./components/Index";
import StarRating from "./shared/components/StarRating";
import FatalError from "./shared/components/FatalError";
import ValidationErrors from "./shared/components/ValidationErrors";
import Success from "./shared/components/Success";
import storeDefinition from './store.js';

window.Vue = require('vue');

/*Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('example-2', require('./components/Example2.vue').default);*/

Vue.use(VueRouter);
Vue.use(Vuex);

Vue.component(StarRating);
Vue.component(Success);
Vue.component(FatalError);
Vue.component('v-errors', ValidationErrors);

// convert timestamp (in seconds) to fromNow() moment.js result
Vue.filter('fromNow', value => moment(value * 1000).fromNow());

const store = new Vuex.Store(storeDefinition);

const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
        "index": Index
    },
    beforeCreate() {
        this.$store.dispatch('loadStoredState');
    }
});


require('./bootstrap');

import router from "./routes";
import VueRouter from 'vue-router'
import moment from 'moment';

import Index from "./components/Index";
import StarRating from "./shared/components/StarRating";
import FatalError from "./shared/components/FatalError";
import ValidationErrors from "./shared/components/ValidationErrors";


window.Vue = require('vue');

/*Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('example-2', require('./components/Example2.vue').default);*/

Vue.use(VueRouter);

Vue.component(StarRating);
Vue.component(FatalError);
Vue.component('v-errors', ValidationErrors);

// convert timestamp (in seconds) to fromNow() moment.js result
Vue.filter('fromNow', value => moment(value * 1000).fromNow());

const app = new Vue({
    el: '#app',
    router,
    components: {
        "index": Index
    }
});

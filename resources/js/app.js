require('./bootstrap');

import router from "./routes";
import VueRouter from 'vue-router'
import Index from "./components/Index";
import moment from 'moment';

window.Vue = require('vue');

/*Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('example-2', require('./components/Example2.vue').default);*/

Vue.use(VueRouter);

// convert timestamp (in seconds) to fromNow() moment.js result
Vue.filter('fromNow', value => moment(value * 1000).fromNow());

const app = new Vue({
    el: '#app',
    router,
    components: {
        "index": Index
    }
});

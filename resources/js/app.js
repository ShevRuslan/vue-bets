require('./bootstrap');
window.Vue = require('vue');

import vuetify from './vuetify';
import App from './App.vue';

const app = new Vue({
    vuetify,
    el: '#app',
    render: h => h(App)
});

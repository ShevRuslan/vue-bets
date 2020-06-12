require('./bootstrap');
window.Vue = require('vue');

import vuetify from './vuetify';
import VueRouter from 'vue-router';
import App from './App.vue';
import routes from './router/routes';

Vue.use(VueRouter);

const router = new VueRouter({
    routes,
    mode: 'history'
})

const app = new Vue({
    vuetify,
    router,
    el: '#app',
    render: h => h(App)
});

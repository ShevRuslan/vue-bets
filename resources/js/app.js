require("./bootstrap");
window.Vue = require("vue");

import vuetify from "./vuetify";
import 'es6-promise/auto';

import VueRouter from "vue-router";
import App from "./App.vue";
import routes from "./router/routes";
import store from './store'


Vue.use(VueRouter);


const router = new VueRouter({
    routes,
    mode: "history"
});

new Vue({
    vuetify,
    router,
    store,
    el: "#app",
    render: h => h(App)
});

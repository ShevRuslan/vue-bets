require('./bootstrap');
window.Vue = require('vue');

import vuetify from './vuetify';
import App from './App.vue';
import ExampleComponent from './components/ExampleComponent.vue'

Vue.component('example-component', ExampleComponent);

const app = new Vue({
    vuetify,
    el: '#app',
    render: h => h(App)
});

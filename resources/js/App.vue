<template>
    <v-app id="inspire">
        <AsideMenu :drawer="drawer" @showAsideMenu="showAsideMenu"/>
        <Header @showAsideMenu="showAsideMenu" />
        <router-view />
    </v-app>
</template>

<script>
import Header from "./components/Header";
import AsideMenu from './components/AsideMenu';
import API from "./service/api";
export default {
    name: "App",
    components: {
        Header,
        AsideMenu,
    },
    data: function() {
        return {
            drawer: false,
        };
    },
    methods: {
        showAsideMenu: function(data) {
            this.drawer = data ? data : !this.drawer;
        }
    },

};
</script>

<style scoped>

</style>

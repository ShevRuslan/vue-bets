<template>
    <v-app id="inspire">
        <Header />
        <router-view />
    </v-app>
</template>

<script>
import Header from "./components/Header";
export default {
    name: "App",
    components: {
        Header,
    },
    data: function() {
        return {
           
        };
    },

};
</script>

<style scoped>
#inspire {
    background-color: #FAFBFE;
    padding: 0px;
}
</style>

<template>
    <div>
        <v-app-bar
            app
            color="indigo"
            dark
        >
<!--            <v-app-bar-nav-icon @click.stop="close"></v-app-bar-nav-icon>-->
            <v-toolbar-title>Ставки</v-toolbar-title>
        </v-app-bar>
    </div>
</template>

<script>
    export default {
        props: {
            drawer: Boolean,
        },
        name: "Header",
        methods: {
            close: function() {
                this.$emit('close');
            }
        }
    }
</script>

<style scoped>

</style>

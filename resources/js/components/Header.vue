<template>
    <div>
        <v-app-bar
            app
            color="indigo"
            dark
        >
            <v-app-bar-nav-icon @click="$emit('showAsideMenu')"></v-app-bar-nav-icon>
            <v-toolbar-title>Ставки</v-toolbar-title>
        </v-app-bar>
    </div>
</template>

<script>
    export default {
        name: "Header",
    }
</script>

<style scoped>

</style>

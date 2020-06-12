<template>
    <v-navigation-drawer
        :value="drawer"
        @input.passive="show"
        app
        temporary
    >
        <v-list dense>
            <v-list-item link to="/" >
                <v-list-item-action>
                    <v-icon>mdi-account-multiple</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                    <v-list-item-title>Поиск</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-list-item link to="/line-match">
                <v-list-item-action>
                    <v-icon>mdi-calendar-month-outline</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                    <v-list-item-title>Линия</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
export default {
    props: { drawer: { type: Boolean } },
    name: "AsideMenu",
    methods: {
        show: function(e) {
            this.$emit('showAsideMenu', e);
        }
    }
};
</script>

<style></style>

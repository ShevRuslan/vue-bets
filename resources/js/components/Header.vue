<template>
    <v-app-bar app color="#313A46" dark class="app-header d-flex flex-row">
        <v-toolbar-title class="app-name">TABLE TENNIS</v-toolbar-title>
        <HeaderForm></HeaderForm>
    </v-app-bar>
</template>

<script>
import HeaderForm from "./HeaderForm";
export default {
    name: "Header",
    components: {
        HeaderForm
    }
};
</script>

<style lang="scss">
.app-header {
    .v-label {
        color: #f1f3fa;
    }
    padding-left: 56px;
    padding-right: 56px;
    .v-toolbar__content {
        width: 100%;
    }
    .app-name {
        font-family: "Gemunu Libre SemiBold";
        font-style: normal;
        font-weight: 300;
        font-size: 24px;
        line-height: 26px;
        text-transform: uppercase;
        display: block;
        width: 15%;
    }
}
</style>

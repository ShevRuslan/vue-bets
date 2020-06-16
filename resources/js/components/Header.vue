<template>
    <div class="wrapper-header d-flex flex-column align-start">
        <v-app-bar app color="#313A46" dark class="app-header d-flex flex-row">
            <v-toolbar-title class="app-name">TABLE TENNIS</v-toolbar-title>
            <HeaderForm></HeaderForm>
        </v-app-bar>
        <div class="wrapper-header__navbar">
            <Navbar />
        </div>
    </div>
</template>

<script>
import HeaderForm from "./HeaderForm";
import Navbar from "./Navbar";
export default {
    name: "Header",
    components: {
        HeaderForm,
        Navbar
    }
};
</script>

<style lang="scss">
.wrapper-header__navbar {
    width: 100%;
    margin-top: 64px;
    background: #ffffff;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.075);
    align-items: baseline;
    display: flex;
    padding-left: 56px;
    padding-right: 56px;
}
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

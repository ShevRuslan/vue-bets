<template>
    <v-chip label x-small class="ma-1 pa-1" color="#6D7073" text-color="white">
        {{ this.rating }}
    </v-chip>
</template>

<script>
export default {
    name: 'RatingSquare',
    props: {
        rating: String
    }
};
</script>

<style></style>

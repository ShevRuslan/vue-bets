<template>
    <v-progress-linear
        :active="loading"
        :indeterminate="loading"
        color="#3688FC"
        class="loading-line"
    ></v-progress-linear>
</template>

<script>
export default {
    name: 'LineLoading',
    props: {
      loading: Boolean,
    }
};
</script>

<style>
.loading-line {
  z-index: 1000;
  position: fixed;
  top: 0;
}
</style>

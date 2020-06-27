<template>
    <div>
        <v-list dense two-line class="history-match text-left">
            <v-list-item v-for="match in history" :key="match.player1" @click="$emit('searchByData', match)">
                <v-list-item-content>
                    <v-list-item-title>{{ match.player1 }} - {{ match.player2 }}</v-list-item-title>
                    <v-list-item-subtitle>{{ match.champName }}</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
        </v-list>
        <v-btn color="error" dense width="100%" @click="clearHistory">
            Очистить историю
        </v-btn>
    </div>
</template>

<script>
export default {
    props: {
        history: Array,
        searchByData: Function
    },
    data() {
        return {};
    },
    methods: {
        clearHistory: function() {
            localStorage.clear();
            this.$emit('changeHistorySearch');
        }
    }
};
</script>

<style scoped>
.history-match {
    max-height: 524px;
    overflow: auto;
    font-size: 12px;
}
</style>

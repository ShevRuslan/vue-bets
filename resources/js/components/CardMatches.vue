<template>
    <div>
        <v-card class="pa-5 card-match">
            <v-card-text>
                <p class="display-1 text--primary name-player">
                    {{ name }}
                </p>
                <p>Последние {{ count }} матчей:</p>
                <v-simple-table>
                    <template v-slot:default>
                        <thead>
                            <tr>
                                <th
                                    class="text-right name-match element-header"
                                >
                                    Название матча
                                </th>
                                <th
                                    class="text-left element-header scores-match"
                                >
                                    Счёт
                                </th>
                                <th class="text-left element-header">Ф1</th>
                                <th class="text-left element-header">Т1</th>
                                <th class="text-left element-header">Ф2</th>
                                <th class="text-left element-header">Т2</th>
                                <th class="text-left element-header">Тотал</th>
                                <th class="text-left element-header">Дата</th>
                                <th class="text-left element-header">Турнир</th>
                                <th class="text-left element-header">Стадия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <Match
                                v-for="match in matches"
                                :key="match.id"
                                :match="match"
                                :player="name"
                            />
                        </tbody>
                    </template>
                </v-simple-table>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
import Match from "./Match";
export default {
    props: {
        name: String,
        matches: Array,
        count: Number
    },
    data() {
        return {};
    },
    components: {
        Match
    }
};
</script>

<style scoped>
.element-header {
    padding-left: 0px;
}
.name-match {
    border-right: 1px solid rgba(0, 0, 0, 0.12);
}
.scores-match {
    padding-left: 10px;
}
@media screen and (max-width: 600px) {
    .name-player {
        font-size: 24px !important;
    }
    .card-match {
        padding: 0px !important;
    }
}
</style>

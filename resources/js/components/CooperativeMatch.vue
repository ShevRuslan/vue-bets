<template>
    <v-card class="pa-10 card-match">
        <div class="display-1 pb-6 pt-10 ">
            Совместные матчи
        </div>
        <v-card-text>
            <p class="text--primary name-player">
                {{ firstPlayer }} - {{ secondPlayer }}
            </p>
            <p class="title font-weight-black">
                {{ winFirst }} - {{ winSecond }}
            </p>
            <v-simple-table>
                <template v-slot:default>
                    <thead>
                        <tr>
                            <th class="text-left element-header scores-match">
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
                            :player="firstPlayer"
                            cooperativeMatch
                        />
                    </tbody>
                </template>
            </v-simple-table>
        </v-card-text>
    </v-card>
</template>

<script>
import Match from "./Match";
export default {
    props: {
        firstPlayer: String,
        secondPlayer: String,
        winFirst: Number,
        winSecond: Number,
        matches: Array
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
.card-match {
    height: 100%;
}
.element-header {
    padding-left: 0px;
}
.card-match .name-player {
    font-size: 16px;
}
@media screen and (max-width: 600px) {
    .card-match .name-player {
        font-size: 12px;
    }
    .card-match {
        padding: 10px !important;
    }
}
</style>

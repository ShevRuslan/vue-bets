<template>
    <div>
        <div class="header">
            <div class="header__title">
                {{ getNameCard(name) }}
            </div>
        </div>
        <div class="content">
             <v-simple-table>
                    <template v-slot:default>
                        <thead>
                            <tr>
                                <th
                                    class="text-left name-match element-header"
                                >
                                    Матч
                                </th>
                                <th
                                    class="text-left element-header scores-match"
                                >
                                    Счёт
                                </th>
                                <th class="text-left element-header">Δ1</th>
                                <th class="text-left element-header">Очки</th>
                                <th class="text-left element-header">Δ2</th>
                                <th class="text-left element-header">Тотал</th>
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
        </div>
    </div>
</template>

<script>
import Match from "./Match";
export default {
    props: {
        name: String,
        matches: Array
    },
    components: {
        Match,
    },
    data() {
        return {
            headers: [
                {
                    text: "",
                    align: "start",
                    sortable: false,
                    value: "name",
                    class: "element-header"
                },
                { text: "Счёт", value: "calories", class: "element-header" },
                { text: "Δ1", value: "fat", class: "element-header" },
                { text: "Очки", value: "carbs", class: "element-header" },
                { text: "Δ2", value: "protein", class: "element-header" },
                { text: "Тотал", value: "iron", class: "element-header" }
            ]
        };
    },
    methods: {
        getNameCard(name) {
            const arrayName = name.split(' ');
            return `${arrayName[1]} ${arrayName[0][0]}.`;
        }
    },
    name: "CardMatches"
};
</script>

<style scoped lang="scss">
.element-header {
    padding-left: 0px;
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
}</style>


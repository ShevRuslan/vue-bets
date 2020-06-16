<template>
    <div>
        <div class="header">
            <div class="header__title">
                {{ firstPlayer }}-{{ secondPlayer }}
            </div>
            <div class="header__score">
                <v-chip color="#FF0000" text-color="white" class="score__chip">
                    {{ winFirst }}
                </v-chip>
                :
                <v-chip color="#33CC33" text-color="white" class="score__chip">
                    {{ winFirst }}
                </v-chip>
            </div>
        </div>
        <div class="content">
            <v-data-table
                :headers="headersCoop"
                :items="matches"
                disable-filtering
                disable-pagination
                disable-sort
                hide-default-footer
                class="elevation-0"
            ></v-data-table>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        firstPlayer: String,
        secondPlayer: String,
        winFirst: Number,
        winSecond: Number,
        matches: Array
    },
    data() {
        return {
            headersCoop: [
                {
                    text: "Дата",
                    align: "left",
                    sortable: false,
                    value: "name",
                    class: "element-header"
                },
                { text: "Счёт", value: "calories", class: "element-header" },
                { text: "Δ1", value: "fat", class: "element-header" },
                { text: "Очки", value: "carbs", class: "element-header" },
                { text: "Δ2", value: "protein", class: "element-header" },
                { text: "Тотал", value: "iron", class: "element-header" },
                { text: "Турнир", value: "champ", class: "element-header" }
            ]
        };
    },
    name: "CooperativeMatchNew"
};
</script>

<style scoped lang="scss"></style>

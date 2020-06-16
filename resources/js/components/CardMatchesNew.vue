<template>
    <div>
        <div class="header">
            <div class="header__title">
                {{ name }}
            </div>
        </div>
        <div class="content">
            <v-data-table
                :headers="headers"
                :items="matches"
                disable-filtering
                disable-pagination
                disable-sort
                hide-default-footer
                class="elevation-0"
            >
                <template v-slot:item.name="{ item }">
                    <div class="slot-name-match">
                        <div class="slot-date-champ">
                            <div class="date">
                                {{ item.name }}
                            </div>
                            <span class="champ-name">{{ item.champ }}</span>
                        </div>
                        <div>
                            {{ item.nameMatch }}
                        </div>
                    </div>
                </template>
            </v-data-table>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        name: String,
        matches: Array
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
    name: "CooperativeMatchNew"
};
</script>

<style scoped lang="scss"></style>

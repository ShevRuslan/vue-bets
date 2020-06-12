<template>
        <v-content>
            <v-container class="fill-height pa-6 align-start" max-width="600px">
                <v-row justify="center" align="center">
                    <v-col class="text-center ">
                        <div class="display-1 pb-12 ">
                            Линия
                        </div>
                        <!-- <div class="text-left">
                           <v-chip
                            class="ma-2"
                            color="green"
                            text-color="white"
                            >
                                Время до обновления: 00:00
                            </v-chip>
                        </div> -->
                        <div>
                            <v-data-table
                                :headers="headers"
                                :items="matches"
                                item-key="name"
                                dense
                                disable-filtering
                                disable-pagination
                                disable-sort
                                :loading="loading"
                                hide-default-footer
                                loading-text="Загрузка данных..."
                            >
                                <!-- <template v-slot:top>
                                <v-toolbar flat>
                                    <v-toolbar-title>Expandable Table</v-toolbar-title>
                                    <v-spacer></v-spacer>
                                    <v-switch v-model="singleExpand" label="Single expand" class="mt-2"></v-switch>
                                </v-toolbar>
                                </template>
                                <template v-slot:expanded-item="{ headers, item }">
                                <td :colspan="headers.length">More info about {{ item.name }}</td>
                                </template> -->
                            </v-data-table>
                        </div>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
</template>

<script>
import API from '../service/api';
import LineMatch from '../components/LineMatch';
export default {
    name: "Line",
    components: {
      LineMatch,
    },
    data: function() {
        return {
            matches:[],
            headers: [
                {
                    text: 'Дата',
                    value: 'date',
                },
                {
                    text: 'Матч',
                    value: 'nameMatch',
                },
                {
                    text: '+',
                    value: 'plus',
                },
                {
                    text: 'П1',
                    value: 'P1',
                },
                {
                    text: 'П2',
                    value: 'P2',
                },
                {
                    text: 'Б',
                    value: 'totalMore',
                },
                {
                    text: 'Тотал',
                    value: 'total',
                },
                {
                    text: 'М',
                    value: 'totalLess',
                },
                {
                    text: '1',
                    value: 'forFirst',
                },
                {
                    text: 'Фора',
                    value: 'for',
                },
                {
                    text: '2',
                    value: 'forSecond',
                },
                {
                    text: 'Б',
                    value: 'individualTotalFirstMore',
                },
                {
                    text: 'ИТ1',
                    value: 'individualTotalFirst',
                },
                {
                    text: 'М',
                    value: 'individualTotalFirstLess',
                },
                {
                    text: 'Б',
                    value: 'individualTotalSecondMore',
                },
                {
                    text: 'ИТ2',
                    value: 'individualTotalSecond',
                },
                {
                    text: 'М',
                    value: 'individualTotalSecondLess',
                },
            ],
            loading: false,
            timer: null,
        };
    },
    created: async function() {
        this.getMatches();
    },
    methods: {
        getMatches: async function() {
            this.loading = true;
            const response = await API.getLineMatches();
            this.matches = response;
            this.loading = false;
            this.timer = setTimeout(this.getMatches, 60000); // (*)
        }
    },
};
</script>

<style scoped>
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
}
</style>

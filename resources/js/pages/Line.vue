<template>
    <v-content>
        <v-container class="fill-height pa-6 align-start" max-width="600px">
            <v-row justify="center" align="center">
                <v-col class="text-center ">
                    <div class="display-1 pb-12 ">
                        Линия
                    </div>
                    <div>
                        <v-autocomplete
                            v-model.trim="currentChamp"
                            :items="champs.champs"
                            item-text="name"
                            return-object
                            required
                            outlined
                            label="Чемпионат"
                            hide-no-data
                            @change="changeChamp"
                        />
                    </div>
                    <div>
                        <v-data-table
                            :headers="headers"
                            :items="matches"
                            item-key="id"
                            disable-filtering
                            disable-pagination
                            disable-sort
                            :loading="loading"
                            hide-default-footer
                            loading-text="Загрузка данных..."
                            no-data-text="Выберите чемпионат"
                            no-results-text="Выберите чемпионат"
                            show-expand
                            :single-expand="singleExpand"
                            @item-expanded="loadStatics"
                            :expanded.sync="expanded"
                            
                        >
                            <template v-slot:expanded-item="{ item,headers }">
                                <td
                                        
                                        v-for="(fetchMatch, index) in fetchMatches"
                                        :key="index"
                                        v-if="fetchMatch.id == item.id"
                                        :colspan="headers.length"
                                    >
                                        <CardMatches
                                            :count="10"
                                            :name="fetchMatch.matches[0].name"
                                            :matches="fetchMatch.matches[0].matches"
                                            class="wrapper-card"
                                        ></CardMatches>
                                        <CardMatches
                                            :count="10"
                                            :name="fetchMatch.matches[1].name"
                                            :matches="fetchMatch.matches[1].matches"
                                            class="wrapper-card"
                                        ></CardMatches>
                                </td>
                            </template>
                        </v-data-table>
                    </div>
                </v-col>
            </v-row>
        </v-container>
    </v-content>
</template>

<script>
import API from "../service/api";
import CardMatches from "../components/CardMatches";
export default {
    name: "Line",
    data: function() {
        return {
            champs: [],
            currentId: null,
            expanded: [],
            matches: [],
            currentChamp: null,
            singleExpand: false,
            headers: [
                {
                    text: "Дата",
                    value: "date"
                },
                {
                    text: "Матч",
                    value: "nameMatch"
                },
                {
                    text: "+",
                    value: "plus"
                },
                {
                    text: "П1",
                    value: "P1"
                },
                {
                    text: "П2",
                    value: "P2"
                },
                {
                    text: "Б",
                    value: "totalMore"
                },
                {
                    text: "Тотал",
                    value: "total"
                },
                {
                    text: "М",
                    value: "totalLess"
                },
                {
                    text: "1",
                    value: "forFirst"
                },
                {
                    text: "Фора",
                    value: "for"
                },
                {
                    text: "2",
                    value: "forSecond"
                },
                {
                    text: "Б",
                    value: "individualTotalFirstMore"
                },
                {
                    text: "ИТ1",
                    value: "individualTotalFirst"
                },
                {
                    text: "М",
                    value: "individualTotalFirstLess"
                },
                {
                    text: "Б",
                    value: "individualTotalSecondMore"
                },
                {
                    text: "ИТ2",
                    value: "individualTotalSecond"
                },
                {
                    text: "М",
                    value: "individualTotalSecondLess"
                }
            ],
            loading: false,
            timer: null,
            fetchMatches: [],
            mapIndex: {}
        };
    },
    components: {
        CardMatches
    },
    async created() {
        this.getMatches();
    },
    beforeDestroy() {
        clearTimeout(this.timer);
    },
    watch: {
        champs: {
            handler() {
                this.$nextTick(() => {
                    this.matches = this.champs[this.currentChamp];
                });
            },
            immediate: true
        }
    },
    methods: {
        getMatches: async function() {
            this.loading = true;
            const response = await API.getLineMatches();
            this.champs = response;
            this.loading = false;
            this.timer = setTimeout(this.getMatches, 60000); // (*)
        },
        changeChamp() {
            this.matches = this.champs[this.currentChamp];
        },
        async loadStatics({ item, value }) {
            if (value) {
                this.loading = true;
                this.currentId = item.id;
                const players = item.nameMatch.split("-");
                const firstPlayer = players[0].trim();
                const secondPlayer = players[1].trim();
                const response = await API.searchBySportsmen({
                    player1: firstPlayer,
                    player2: secondPlayer,
                    champName: this.currentChamp,
                    countMatches: 10
                });

                const objectMatch = {
                    matches: response,
                    id: item.id
                };

                const exMatch = this.exsistMatch(item.id);

                console.log(exMatch);
                if(exMatch != null) {
                    this.fetchMatches[exMatch] = objectMatch
                } 
                else {
                    this.fetchMatches.push(objectMatch);
                }
                this.loading = false;
            }
        },
        exsistMatch(id) {
            let exsist = null
            this.fetchMatches.forEach((element, index) => {
                if (element.id == id) exsist = index;
            });
            return exsist;
        }
    }
};
</script>

<style lang="scss">
.v-data-table__expanded__content td {
    padding: 0px !important;
}
.v-data-table tbody tr.v-data-table__expanded__content {
    box-shadow: none !important;
}
.wrapper-cards {
    flex-direction: column;
}
wrapper-cards .wrapper-card {
    width: 100%;
}
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

<template>
    <v-dialog :value="dialog" @input="close" transition="dialog-bottom-transition" class="modal-statics">
        <v-card class="wrapper-dialog">
            <v-btn class="btn-close" dark icon absolute @click="close" color="#000">
                <v-icon>mdi-close</v-icon>
            </v-btn>
            <v-container fluid class="fill-height align-start wrapper-page-search">
                <v-row justify="center" align="center">
                    <v-col class="pa-0">
                        <div class="wrapper-tables" v-if="currentStatics.length > 1">
                            <div class="wrapper-coop-matches">
                                <CooperativeMatch
                                    :firstPlayer="currentStatics[2].player1"
                                    :secondPlayer="currentStatics[2].player2"
                                    :winFirst="currentStatics[2].win1"
                                    :winSecond="currentStatics[2].win2"
                                    :matches="currentStatics[2].mergeGames"
                                ></CooperativeMatch>
                            </div>
                            <div class="wrapper-firstplayer-matches">
                                <CardMatches
                                    :name="currentStatics[0].name"
                                    :matches="currentStatics[0].matches"
                                    :rating="currentStatics[2].rating1"
                                ></CardMatches>
                            </div>
                            <div class="wrapper-secondplayer-matches">
                                <CardMatches
                                    :name="currentStatics[1].name"
                                    :matches="currentStatics[1].matches"
                                     :rating="currentStatics[2].rating2"
                                ></CardMatches>
                            </div>
                        </div>
                        <div class="wrapper-bets">
                            <div class="current-champ pb-10 pa-10 ">
                                Таблица ставок
                            </div>
                            <div class="tables-bets">
                                <div class="wrapper-wins">
                                    <div class="win">
                                        <v-chip class="win-text win-item" small label>
                                            Победа 1
                                        </v-chip>
                                        <v-chip class="win-number win-item" small label>
                                            {{ bets['win1'] }} / {{ bets['countGames'] }}
                                        </v-chip>
                                    </div>
                                    <div class="win">
                                        <v-chip class="win-text win-item" small label>
                                            Победа 2
                                        </v-chip>
                                        <v-chip class="win-number win-item" small label>
                                            {{ bets['win2'] }} / {{ bets['countGames'] }}
                                        </v-chip>
                                    </div>
                                </div>
                                <div class="wrapper-tables" v-if="bets.length != 0">
                                    <BetTable :items="bets.total" :countGames="bets['countGames']">
                                        <tr>
                                            <th class="text-center"></th>
                                            <th class="text-center">
                                                ТБ
                                            </th>
                                            <th class="text-center">
                                                ТМ
                                            </th>
                                        </tr>
                                    </BetTable>

                                    <BetTable :items="bets.individualTotalFirst" :countGames="bets['countGames']">
                                        <tr>
                                            <th class="text-center"></th>
                                            <th class="text-center">
                                                ИТБ1
                                            </th>
                                            <th class="text-center">
                                                ИТМ1
                                            </th>
                                        </tr>
                                    </BetTable>

                                    <BetTable :items="bets.individualTotalSecond" :countGames="bets['countGames']">
                                        <tr>
                                            <th class="text-center"></th>
                                            <th class="text-center">
                                                ИТБ2
                                            </th>
                                            <th class="text-center">
                                                ИТМ2
                                            </th>
                                        </tr>
                                    </BetTable>

                                    <BetTable
                                        :items="bets.forFirst"
                                        isFor
                                        headerFor="Δ1"
                                        :countGames="bets['countGames']"
                                    />
                                    <BetTable
                                        :items="bets.forSecond"
                                        isFor
                                        headerFor="Δ2"
                                        :countGames="bets['countGames']"
                                        reverseArray
                                    />
                                </div>
                            </div>
                        </div>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>
    </v-dialog>
</template>

<script>
import CooperativeMatch from '../components/CooperativeMatch';
import CardMatches from '../components/CardMatches';
import BetTable from '../components/BetTable';
export default {
    name: 'LineInfoMatchDialog',
    props: {
        dialog: Boolean,
        currentStatics: Array,
        bets: Object
    },
    components: {
        CooperativeMatch,
        CardMatches,
        BetTable
    },
    methods: {
        close() {
            this.$emit('closeInfoDialog');
        }
    }
};
</script>

<style></style>

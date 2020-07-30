<template>
    <v-content>
        <v-container fluid class="fill-height align-start wrapper-page-search">
            <v-row justify="center" align="center">
                <v-col class="pa-0">
                    <div class="wrapper" v-if="getMatches.length > 0">
                        <div class="wrapper-tables">
                            <div class="wrapper-coop-matches">
                                <CooperativeMatch
                                    :firstPlayer="cooperativePlayers.player1"
                                    :secondPlayer="cooperativePlayers.player2"
                                    :winFirst="cooperativePlayers.win1"
                                    :winSecond="cooperativePlayers.win2"
                                    :matches="cooperativePlayers.mergeGames"
                                    :showGetRivalsMatch="true"
                                    @closeInfoDialogRivals="closeInfoDialogRivals"
                                ></CooperativeMatch>
                            </div>
                            <div class="wrapper-firstplayer-matches">
                                <CardMatches
                                    :rating="cooperativePlayers.rating1"
                                    :name="firstPlayer.name"
                                    :matches="firstPlayer.matches"
                                ></CardMatches>
                            </div>
                            <div class="wrapper-secondplayer-matches">
                                <CardMatches
                                    :rating="cooperativePlayers.rating2"
                                    :name="secondPlayer.name"
                                    :matches="secondPlayer.matches"
                                ></CardMatches>
                            </div>
                        </div>
                        <CommonRivalsMatch
                            v-if="commonRivals.length != 0"
                            :dialog="dialogRivals"
                            :commonRivals="commonRivals"
                            :firstPlayer="firstPlayer.name"
                            :secondPlayer="secondPlayer.name"
                            @closeInfoDialog="closeInfoDialogRivals"
                        >
                        </CommonRivalsMatch>
                    </div>
                </v-col>
            </v-row>
        </v-container>
    </v-content>
</template>

<script>
import CooperativeMatch from '../components/CooperativeMatch';
import CardMatches from '../components/CardMatches';
import CommonRivals from '../components/CommonRivals';
import CommonRivalsMatch from '../components/CommonRivalsMatch';
import { mapGetters } from 'vuex';
export default {
    name: 'Search',
    components: {
        CooperativeMatch,
        CardMatches,
        CommonRivals,
        CommonRivalsMatch
    },
    data() {
        return {
            dialogRivals: false
        };
    },
    computed: {
        ...mapGetters(['getMatches', 'getRivalsMatch']),
        firstPlayer() {
            return this.getMatches[0];
        },
        secondPlayer() {
            return this.getMatches[1];
        },
        cooperativePlayers() {
            return this.getMatches[2];
        },
        commonRivals() {
            return this.getRivalsMatch;
        }
    },
    methods: {
        closeInfoDialogRivals(bool) {
            this.dialogRivals = bool;
        }
    }
};
</script>

<style lang="scss">
.wrapper-page-search {
    padding-top: 32px;
    padding-left: 56px;
    padding-right: 56px;
    margin: 0px;
    .row {
        margin: 0px;
        .col {
            margin: 0px;
        }
    }
    .wrapper-common-rivals,
    .wrapper-tables {
        display: flex;
        justify-content: space-between;
        .wrapper-coop-matches,
        .wrapper-firstplayer-matches,
        .wrapper-secondplayer-matches {
            width: 34%;
        }
        .wrapper-firstplayer-matches {
            margin-right: 32px;
            margin-left: 32px;
        }
        .header {
            display: flex;
            font-style: normal;
            font-weight: bold;
            font-size: 18px;
            line-height: 21px;
            color: #474d56;
            .header__title {
                margin-right: 10px;
            }
        }
        .content {
            margin-top: 20px;
            background: #ffffff;
            box-shadow: 0px 0px 35px rgba(154, 161, 171, 0.15);
            .element-header {
                border-bottom: none;
                font-weight: bold;
                font-size: 12px;
                line-height: 14px;
                color: #474d56;
                height: 14px;
                padding-top: 16px;
                padding-bottom: 16px;
                padding-left: 0px;
            }
            .v-data-table__wrapper {
                padding: 4px 12px;
            }
            .v-data-table td {
                border-bottom: 1px solid #e8ecef !important;
                height: 36px;
                font-style: normal;
                font-weight: normal;
                font-size: 12px;
                line-height: 14px;
                padding-left: 0px;
                padding-top: 8px;
                padding-bottom: 8px;
                padding-right: 0px;
                color: #474d56;
                .slot-name-match {
                    white-space: nowrap;
                    margin-right: 12px;
                    .slot-date-champ {
                        margin-bottom: 4px;
                        display: flex;
                        flex-wrap: wrap;
                        align-items: self-start;
                        justify-content: left;
                        .date {
                            margin-right: 10px;
                        }
                        .champ-name {
                            font-size: 11px;
                            line-height: 13px;
                            color: #f0ac0e;
                        }
                    }
                }
            }
            .v-data-table tr:last-child td {
                border-bottom: none !important;
            }
        }
    }
}
.v-content {
    padding: 0px !important;
}
</style>

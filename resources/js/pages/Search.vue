<template>
    <v-content>
        <v-container fluid class="fill-height align-start wrapper-page-search">
            <v-row justify="center" align="center">
                <v-col class="pa-0">
                    <div class="wrapper-tables">
                        <div class="wrapper-coop-matches">
                            <CooperativeMatchNew
                                firstPlayer="Михайлова П."
                                secondPlayer="Фетюхина М."
                                winFirst=10
                                winSecond=15
                                :matches="desserts"
                            ></CooperativeMatchNew>
                        </div>
                        <div class="wrapper-firstplayer-matches">
                            <CardMatchesNew
                                name="Фетюхина М."
                                :matches="desserts"
                            ></CardMatchesNew>
                        </div>
                        <div class="wrapper-secondplayer-matches">
                            <CardMatchesNew
                                name="Михайлова П."
                                :matches="desserts"
                            ></CardMatchesNew>
                        </div>
                    </div>
                </v-col>
            </v-row>
        </v-container>
    </v-content>
</template>

<script>
import CooperativeMatchNew from '../components/CooperativeMatchNew';
import CardMatchesNew from '../components/CardMatchesNew';
export default {
    name: "Search",
    components: {
        CooperativeMatchNew,
        CardMatchesNew
    },
    data() {
        return {

            desserts: [
                {
                    name: "11.06.20",
                    calories: "3:4",
                    fat: "+4",
                    carbs: "5:26",
                    protein: "-13",
                    iron: "27",
                    champ: "BoomCup",
                    nameMatch: "Феликс Оже-Альяссим"
                },
                {
                    name: "11.06.20",
                    calories: "3:4",
                    fat: "+4",
                    carbs: "5:26",
                    protein: "-13",
                    iron: "27",
                    champ: "Tennis Point Exhibition Series",
                    nameMatch: "Феликс Оже-Альяссим"
                },
                {
                    name: "11.06.20",
                    calories: "3:4",
                    fat: "+4",
                    carbs: "5:26",
                    protein: "-13",
                    iron: "27",
                    champ: "BoomCup",
                    nameMatch: "Феликс Оже-Альяссим"
                },
                {
                    name: "11.06.20",
                    calories: "3:4",
                    fat: "+4",
                    carbs: "5:26",
                    protein: "-13",
                    iron: "27",
                    champ: "BoomCup",
                    nameMatch: "Феликс Оже-Альяссим"
                },
                {
                    name: "11.06.20",
                    calories: "3:4",
                    fat: "+4",
                    carbs: "5:26",
                    protein: "-13",
                    iron: "27",
                    champ: "BoomCup",
                    nameMatch: "Феликс Оже-Альяссим"
                },
                {
                    name: "11.06.20",
                    calories: "3:4",
                    fat: "+4",
                    carbs: "5:26",
                    protein: "-13",
                    iron: "27",
                    champ: "BoomCup",
                    nameMatch: "Феликс Оже-Альяссим"
                },
                {
                    name: "11.06.20",
                    calories: "3:4",
                    fat: "+4",
                    carbs: "5:26",
                    protein: "-13",
                    iron: "27",
                    champ: "BoomCup",
                    nameMatch: "Феликс Оже-Альяссим"
                },
                {
                    name: "11.06.20",
                    calories: "3:4",
                    fat: "+4",
                    carbs: "5:26",
                    protein: "-13",
                    iron: "27",
                    champ: "BoomCup",
                    nameMatch: "Феликс Оже-Альяссим"
                },
                {
                    name: "11.06.20",
                    calories: "3:4",
                    fat: "+4",
                    carbs: "5:26",
                    protein: "-13",
                    iron: "27",
                    champ: "BoomCup",
                    nameMatch: "Феликс Оже-Альяссим"
                },
                {
                    name: "11.06.20",
                    calories: "3:4",
                    fat: "+4",
                    carbs: "5:26",
                    protein: "-13",
                    iron: "27",
                    champ: "BoomCup",
                    nameMatch: "Феликс Оже-Альяссим"
                }
            ]
        };
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
            .header__score {
                display: flex;
                justify-content: center;
                align-items: center;
                .score__chip {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    border-radius: 3px;
                    width: 24px;
                    height: 15px;
                    font-size: 12px !important;
                    line-height: 14px !important;
                    padding: 0px;
                }
                .score__chip:first-child {
                    margin-right: 5px;
                }
                .score__chip:last-child {
                    margin-left: 5px;
                }
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

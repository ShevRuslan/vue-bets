<template>
    <v-content>
        <v-container fluid class="fill-height align-start wrapper-page-search">
            <v-row justify="center" align="center">
                <v-col>
                    <div class="wrapper-tables">
                        <div class="wrapper-coop-matches">
                            <div class="header">
                                <div class="header__title">
                                    Михайлова П.-Фетюхина М.
                                </div>
                                <div class="header__score">
                                    <v-chip
                                        color="#FF0000"
                                        text-color="white"
                                        class="score__chip"
                                    >
                                        10
                                    </v-chip>
                                    :
                                    <v-chip
                                        color="#33CC33"
                                        text-color="white"
                                        class="score__chip"
                                    >
                                        15
                                    </v-chip>
                                </div>
                            </div>
                            <div class="content">
                                <v-data-table
                                    :headers="headers"
                                    :items="desserts"
                                    disable-filtering
                                    disable-pagination
                                    disable-sort
                                    hide-default-footer
                                    class="elevation-0"
                                ></v-data-table>
                            </div>
                        </div>
                        <div class="wrapper-firstplayer-matches">
                            <div class="header">
                                <div class="header__title">
                                    Михайлова П.
                                </div>
                            </div>
                            <div class="content">
                                <v-data-table
                                    :headers="headers"
                                    :items="desserts"
                                    disable-filtering
                                    disable-pagination
                                    disable-sort
                                    hide-default-footer
                                    class="elevation-0"
                                ></v-data-table>
                            </div>
                        </div>
                        <div class="wrapper-secondplayer-matches">
                            <div class="header">
                                <div class="header__title">
                                    Фетюхина М.
                                </div>
                            </div>
                            <div class="content">
                                <v-data-table
                                    :headers="headers"
                                    :items="desserts"
                                    disable-filtering
                                    disable-pagination
                                    disable-sort
                                    hide-default-footer
                                    class="elevation-0"
                                ></v-data-table>
                            </div>
                        </div>
                    </div>
                </v-col>
            </v-row>
        </v-container>
    </v-content>
</template>

<script>
export default {
    name: "Search",
    data() {
        return {
            headers: [
                {
                    text: "Дата",
                    align: "start",
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
            ],
            desserts: [
                {
                    name: "11.06.20",
                    calories: 159,
                    fat: 6.0,
                    carbs: 24,
                    protein: 4.0,
                    iron: "1%",
                    champ: "BoomCup"
                },
                {
                    name: "11.06.20",
                    calories: 237,
                    fat: 9.0,
                    carbs: 37,
                    protein: 4.3,
                    iron: "1%",
                    champ: "BoomCup"
                },
                {
                    name: "11.06.20",
                    calories: 262,
                    fat: 16.0,
                    carbs: 23,
                    protein: 6.0,
                    iron: "7%",
                    champ: "BoomCup"
                },
                {
                    name: "11.06.20",
                    calories: 305,
                    fat: 3.7,
                    carbs: 67,
                    protein: 4.3,
                    iron: "8%",
                    champ: "BoomCup"
                },
                {
                    name: "11.06.20",
                    calories: 356,
                    fat: 16.0,
                    carbs: 49,
                    protein: 3.9,
                    iron: "16%",
                    champ: "BoomCup"
                },
                {
                    name: "11.06.20",
                    calories: 375,
                    fat: 0.0,
                    carbs: 94,
                    protein: 0.0,
                    iron: "0%",
                    champ: "BoomCup"
                },
                {
                    name: "11.06.20",
                    calories: 392,
                    fat: 0.2,
                    carbs: 98,
                    protein: 0,
                    iron: "2%",
                    champ: "BoomCup"
                },
                {
                    name: "11.06.20",
                    calories: 408,
                    fat: 3.2,
                    carbs: 87,
                    protein: 6.5,
                    iron: "45%",
                    champ: "BoomCup"
                },
                {
                    name: "11.06.20",
                    calories: 452,
                    fat: 25.0,
                    carbs: 51,
                    protein: 4.9,
                    iron: "22%",
                    champ: "BoomCup"
                },
                {
                    name: "11.06.20",
                    calories: 518,
                    fat: 26.0,
                    carbs: 65,
                    protein: 7,
                    iron: "6%",
                    champ: "BoomCup"
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
            /* identical to box height */
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
            background: #FFFFFF;
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
                color: #474d56;
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

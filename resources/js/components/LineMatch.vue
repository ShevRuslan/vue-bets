<template>
    <div class="wrapper_table-line">
        <div class="table-line__header">
            <div class="table-lite_header-group">
                <div class="table-line__header-item date-match">
                    Время
                </div>
                <div class="table-line__header-item name-match">
                    Название матча
                </div>
            </div>
            <div class="table-lite_header-group">
                <div class="table-line__header-item">
                    1
                </div>
                <div class="table-line__header-item important">
                    Х
                </div>
                <div class="table-line__header-item">
                    2
                </div>
            </div>
            <div class="table-lite_header-group">
                <div class="table-line__header-item">
                    1
                </div>
                <div class="table-line__header-item important">
                    Тотал
                </div>
                <div class="table-line__header-item">
                    2
                </div>
            </div>
            <div class="table-lite_header-group">
                <div class="table-line__header-item">
                    1
                </div>
                <div class="table-line__header-item important">
                    Фора
                </div>
                <div class="table-line__header-item">
                    2
                </div>
            </div>
            <div class="table-lite_header-group"></div>
        </div>
        <div class="table-line__content">
            <div class="table-line__content-item" v-for="(match, index) in matches" :key="match.id">
                <div class="table-line__content-date" v-if="newDate(match, matches, index)">
                    {{ getDate(match.date) }}
                </div>
                <div class="wrapper-info">
                    <div class="content-item__group">
                        <div class="content-item__group-item">
                            {{ getTime(match.date) }}
                        </div>
                        <div
                            class="content-item__group-item name-match"
                            :class="{ check: check[match.id] ? true : false }"
                            @click="getInfo(match)"
                        >
                            <span>{{ match.player1 }}</span>
                            <br />
                            <span>{{ match.player2 }}</span>
                        </div>
                    </div>
                    <div class="content-item__group">
                        <div class="content-item__group-item number-block">
                            {{ match.P1 }}
                        </div>
                        <div class="content-item__group-item drow-block">
                            {{ match.drow }}
                        </div>
                        <div class="content-item__group-item number-block">
                            {{ match.P2 }}
                        </div>
                    </div>
                    <div class="content-item__group">
                        <div class="content-item__group-item number-block">
                            {{ match.totalMore }}
                        </div>
                        <div class="content-item__group-item important-number-block">
                            {{ match.total }}
                        </div>
                        <div class="content-item__group-item number-block">
                            {{ match.totalLess }}
                        </div>
                    </div>
                    <div class="content-item__group">
                        <div class="content-item__group-item number-block">
                            {{ match.forFirst }}
                        </div>
                        <div class="content-item__group-item important-number-block">
                            {{ match.for }}
                        </div>
                        <div class="content-item__group-item number-block">
                            {{ match.forSecond }}
                        </div>
                    </div>
                    <div class="content-item__group action-block">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            @click="getInfo(match)"
                        >
                            <path
                                d="M24 11.9873C24.0762 18.4336 18.8191 24.0085 12.0127 24C5.32488 23.9915 0.0423361 18.645 8.05379e-06 12.0634C-0.04232 5.48185 5.24869 0 12.0127 0C18.7852 0 24.0593 5.52415 24 11.9873ZM22.0191 12.3511C22.1968 6.75079 17.7863 1.9711 11.9873 1.98802C6.38308 2.00493 2.05715 6.46316 1.98943 11.8773C1.9217 17.6045 6.62011 22.0627 12.0042 21.9866C17.4392 22.0543 21.8497 17.5876 22.0191 12.3511ZM11.6402 19.8294C12.7915 19.288 13.4773 18.2982 14.1037 17.2577C14.1714 17.1392 14.1122 17.0631 14.0106 16.9954C13.9005 16.9193 13.8074 16.9193 13.7228 17.0377C13.545 17.283 13.3587 17.5284 13.181 17.7737C13.0032 18.0106 12.7915 18.2136 12.5714 18.4082C12.4275 18.5351 12.2497 18.5858 12.0635 18.4928C11.8857 18.3997 11.8857 18.2221 11.9111 18.0529C11.9619 17.7906 12.0127 17.5284 12.0889 17.2661C12.5799 15.5488 13.0794 13.8315 13.5788 12.1142C13.8243 11.2682 14.0698 10.4307 14.3069 9.58477C14.3831 9.32252 14.3492 9.27177 14.0699 9.27177C13.9005 9.27177 13.7228 9.26331 13.5534 9.28868C12.4275 9.46634 11.3101 9.65245 10.1841 9.8301C10.091 9.84702 9.98943 9.85548 9.9217 9.93162C9.84551 10.0078 9.79472 10.1008 9.82858 10.2108C9.86244 10.3123 9.96403 10.3038 10.0487 10.3038C10.836 10.3715 11.0476 10.6507 10.8952 11.429C10.8868 11.4713 10.8783 11.5136 10.8699 11.5559C10.5905 12.6895 10.2349 13.7977 9.91324 14.9143C9.66773 15.7772 9.41376 16.6317 9.1598 17.4861C9.08361 17.7652 9.00742 18.036 8.98202 18.3236C8.8889 19.4149 9.46456 20.0409 10.5905 20.0493C10.9376 20.0747 11.2931 19.9901 11.6402 19.8294ZM15.3651 5.69334C15.3566 4.77124 14.6455 4.06063 13.7228 4.06063C12.7661 4.06063 12.0381 4.77124 12.0466 5.71026C12.0466 6.6239 12.7831 7.35143 13.7143 7.35143C14.6455 7.34297 15.3736 6.61544 15.3651 5.69334Z"
                                fill="#4D72C0"
                            />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <v-dialog v-model="dialog" transition="dialog-bottom-transition" class="modal-statics">
            <v-card class="wrapper-dialog">
                <v-btn class="btn-close" dark icon absolute @click="dialog = false" color="#000">
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
                                    ></CardMatches>
                                </div>
                                <div class="wrapper-secondplayer-matches">
                                    <CardMatches
                                        :name="currentStatics[1].name"
                                        :matches="currentStatics[1].matches"
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
        <v-overlay v-model="dialog"></v-overlay>
        <v-snackbar absolute v-model="snackbar" color="primary" left bottom>
            Начался запрос на получение статистики!
            <v-btn text @click="snackbar = false">
                <v-icon>mdi-close</v-icon>
            </v-btn>
        </v-snackbar>
    </div>
</template>

<script>
import API from '../service/api';
import CooperativeMatch from '../components/CooperativeMatch';
import CardMatches from '../components/CardMatches';
import BetTable from '../components/BetTable';
import { mapActions } from 'vuex';
import { mapMutations } from 'vuex';
import { mapGetters } from 'vuex';

export default {
    props: {
        matches: Array
    },
    components: {
        CooperativeMatch,
        CardMatches,
        BetTable
    },
    data() {
        return {
            currentStatics: [],
            bets: [],
            dialog: false,
            snackbar: false,
            snackbarStatics: false,
            check: {}
        };
    },
    computed: {
        ...mapGetters(['getCountLineMatches'])
    },
    methods: {
        ...mapActions(['setResponse']),
        ...mapMutations(['setHistory']),
        async getInfo(item) {
            this.check[item.id] = true;
            const data = {
                player1: item.player1,
                player2: item.player2,
                champName: item.champName,
                countMatches: this.getCountLineMatches,
                coopChamps: false,
                line: true,
            };
            this.search(data);
            this.bets = await API.getBetsMatch({
                ...data,
                totalArray: JSON.stringify(item.totalArray),
                forArray: JSON.stringify(item.forArray),
                individualTotalFirstArray: JSON.stringify(item.individualTotalFirstArray),
                individualTotalSecondArray: JSON.stringify(item.individualTotalSecondArray)
            });
            this.dialog = true;
        },
        search: async function(data) {
            this.snackbar = true;
            this.searchByData(data);
        },
        searchByData: async function(data) {
            this.currentStatics = [];
            this.currentStatics = await API.searchBySportsmen(data);
            this.snackbar = false;
        },
        getMatchName(player) {
            const arrayName = player.split(' ');
            return `${arrayName[1]} ${arrayName[0][0]}.`;
        },
        newDate(match, matches, index) {
            if (index == 0) {
                return true;
            }
            if (matches != undefined) {
                if (matches[index - 1] != undefined) {
                    const oldDateArray = match.date.split(' ');
                    const oldDateDay = oldDateArray[0].split('.')[0];
                    const newDateArray = matches[index - 1].date.split(' ');
                    const newDateDay = newDateArray[0].split('.')[0];
                    if (newDateDay != oldDateDay) return true;
                    else return false;
                } else {
                    return false;
                }
            }
        },
        getTime(date) {
            const oldDateArray = date.split(' ');
            return oldDateArray[1];
        },
        getDate(date) {
            const oldDateArray = date.split(' ');
            const oldDateDayAndMonth = oldDateArray[0].split('.');
            const oldDateDay = oldDateDayAndMonth[0];
            const oldDateMonth = oldDateDayAndMonth[1];
            const month = this.getNameMonth(parseInt(oldDateMonth));
            return `${oldDateDay} ${month}`;
        },
        getNameMonth(month) {
            switch (month) {
                case 1:
                    return 'января';
                case 2:
                    return 'февраля';
                case 3:
                    return 'марта';
                case 4:
                    return 'апреля';
                case 5:
                    return 'мая';
                case 6:
                    return 'июня';
                case 7:
                    return 'июля';
                case 8:
                    return 'августа';
                case 9:
                    return 'сентября';
                case 10:
                    return 'октября';
                case 11:
                    return 'ноября';
                case 12:
                    return 'декабря';
            }
        }
    }
};
</script>

<style lang="scss">
.check {
    font-weight: normal !important;
}
.wrapper-dialog {
    position: relative;
    .btn-close {
        position: absolute;
        right: 0px;
        z-index: 10;
    }
}
.wrapper_table-line {
    display: flex;
    flex-direction: column;
    width: 100%;
    max-width: 1030px;
    .table-line__header {
        display: flex;
        justify-content: space-between;
        background: #d8dbed;
        padding: 16px 24px;
        font-weight: bold;
        font-size: 13px;
        line-height: 15px;
        color: #474d56;
        .table-lite_header-group {
            display: flex;
            .table-line__header-item {
                width: 72px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .name-match {
                width: auto;
            }
            .date-match {
                justify-content: flex-start;
            }
            .important {
                color: #4d72c0;
            }
        }
    }
    .table-line__content {
        .table-line__content-item {
            .table-line__content-date {
                background: #f1f3fa;
                width: 100%;
                padding-left: 24px;
                padding-top: 8px;
                padding-bottom: 8px;
                text-align: left;
                font-weight: 500;
                font-size: 13px;
                line-height: 15px;
            }
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: #ffffff;
            border-bottom: 1px solid #c1c5e0;
            font-size: 13px;
            line-height: 15px;
            color: #474d56;
            .wrapper-info {
                padding: 0px 24px;
                display: flex;
                justify-content: space-between;
                .content-item__group {
                    display: flex;
                    align-items: center;
                    .important-number-block,
                    .drow-block,
                    .number-block {
                        width: 72px;
                        height: 58px;
                        background: #e8ecef;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        font-size: 13px;
                        line-height: 15px;
                    }
                    .important-number-block {
                        background: #fff;
                        color: #4d72c0;
                        font-weight: bold;
                    }
                    .drow-block {
                        background: #d8dbed;
                    }
                    .name-match {
                        width: auto;
                        margin-left: 40px;
                        text-align: left;
                        font-weight: bold;
                        cursor: pointer;
                    }
                    .check-match {
                        font-weight: normal;
                    }
                }
                .action-block {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    svg {
                        cursor: pointer;
                    }
                }
            }
        }
    }
    .content-item__group:nth-child(1),
    .table-lite_header-group:nth-child(1) {
        width: 25%;
    }
    .content-item__group:nth-child(2),
    .table-lite_header-group:nth-child(2) {
        width: 20%;
    }
    .content-item__group:nth-child(3),
    .table-lite_header-group:nth-child(3) {
        width: 20%;
    }
    .content-item__group:nth-child(4),
    .table-lite_header-group:nth-child(4) {
        width: 20%;
    }
    .content-item__group:nth-child(5),
    .table-lite_header-group:nth-child(5) {
        width: 10%;
    }
}
.wrapper-bets {
    display: flex;
    flex-direction: column;
    .tables-bets {
        display: flex;
        flex-direction: column;
        background: #ffffff;
        box-shadow: 0px 0px 35px rgba(154, 161, 171, 0.15);
        padding: 16px 13px;
        .wrapper-wins {
            display: flex;
            margin-bottom: 16px;
            .win {
                display: flex;
                margin-right: 24px;
                .win-item {
                    border-radius: 0% !important;
                }
                .win-text {
                    background: #e8ecef;
                    font-weight: 500;
                    font-size: 12px;
                    line-height: 14px;

                    /* identical to box height */

                    color: #474d56;
                }
                .win-number {
                    border: 1px solid #e8ecef;
                    background: #fff;
                }
            }
        }
        .wrapper-tables {
            display: flex;
            justify-content: space-between;
            .table-bet {
                width: 19%;
                table {
                    border: 1px solid #dde2f0;
                    .table-header {
                        tr {
                            th {
                                font-weight: bold;
                                font-size: 12px;
                                line-height: 14px;
                                color: #474d56;
                            }
                        }
                        background: #f0f3fa;
                    }
                    .table-content {
                        tr td:nth-child(2) {
                            border-left: 1px solid #dde2f0;
                            border-right: 1px solid #dde2f0;
                        }
                        .wrapper-left-number {
                            padding: 0px;
                            background: #e8ecef;
                        }
                        .left-number {
                            padding: 8px 14px;
                            font-weight: bold;
                            font-size: 12px;
                            line-height: 14px;
                            color: #474d56;
                        }
                        .wrapper-color-block {
                            padding: 0px;
                            .less-green,
                            .more-green,
                            .not-green {
                                padding: 8px 14px;
                            }
                        }
                    }
                }
            }
        }
    }
}
</style>

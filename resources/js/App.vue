<template>
    <v-app id="inspire">
        <Header/>
        <v-content>
            <v-container
                class="fill-height pa-6"
                max-width="600px"
            >
                <v-row
                    justify="center"
                    align="center"
                >
                    <v-col class="text-center ">
                        <div width="100%" class="d-flex wrapper-form-coop">
                            <v-card
                                class="pa-5 mr-5 wrapper-form"
                            >
                                <div class="display-1 pb-12 ">
                                    Поиск по спортсменам
                                </div>
                                <div>
                                    <v-form
                                        ref="form"
                                    >
                                        <div class="d-flex wrapper-selects">
                                            <v-autocomplete
                                                v-model="player1"
                                                :items="entries1"
                                                :loading="isLoading1"
                                                :search-input.sync="searchSportsmen1"
                                                item-text="name"
                                                return-object
                                                required
                                                outlined
                                                class="picker-player mr-5 select-player"
                                                width="50%" 
                                                label="Первый игрок"
                                                hide-no-data
                                                >
                                           </v-autocomplete>
                                             <v-autocomplete
                                                v-model="player2"
                                                :items="entries2"
                                                :loading="isLoading2"
                                                :search-input.sync="searchSportsmen2"
                                                item-text="name"
                                                return-object
                                                class="select-player"
                                                required
                                                outlined
                                                label="Второй игрок"
                                                hide-no-data
                                                >
                                           </v-autocomplete>
                                        </div>

                                        <v-autocomplete
                                            v-model="tourney"
                                            :items="champs"
                                            item-text="name"
                                            return-object
                                            required
                                            outlined
                                            label="Чемпионат"
                                            hide-no-data
                                            >
                                        </v-autocomplete>
                                        <v-slider
                                        color="primary"
                                        v-model="count"
                                        label="Количество"
                                        min="1"
                                        max="100"
                                        thumb-label
                                        ></v-slider>
                                       <div class="d-flex wrapper-buttons mt-5" >
                                            <div class="button mr-5" >
                                                <v-btn :loading="loadingMatches" color="success" dense width="100%" @click="search">
                                                    Получить информацию
                                                </v-btn>
                                                 <v-snackbar
                                                    v-model="snackbar"
                                                    color="success"
                                                    left
                                                    bottom
                                                >
                                                    Матчи успешно получены!
                                                    <v-btn
                                                        text
                                                        @click="snackbar = false"
                                                    >
                                                        <v-icon>mdi-close</v-icon>
                                                    </v-btn>
                                                </v-snackbar>
                                            </div>

                                            <div class="button">
                                                 <v-btn :loading="loadingLastDate" color="primary" dense width="100%" @click="getLastUpdateDate" >
                                                    Актуальность базы
                                                </v-btn>
                                                <v-dialog 
                                                    v-model="dialog"
                                                    width="500"
                                                >
                                                 <v-card>
                                                    <v-card-title class="headline">Последнее обновление базы</v-card-title>
                                                    <v-card-text class="title">{{lastUpdateDate}}</v-card-text>
                                                    <v-card-actions>
                                                    <v-spacer></v-spacer>
                                                    <v-btn color="green darken-1" text @click="dialog = false">Закрыть</v-btn>
                                                    </v-card-actions>
                                                </v-card>
                                                </v-dialog>
                                            </div>
                                            <HistorySearch 
                                            :history="historySearch" 
                                            @changeHistorySearch="changeHistorySearch"
                                            @searchByData="searchByData"/>
                                       </div>

                                    </v-form>
                                </div>
                            </v-card>
                            <v-card class="wrapper-coop" v-if="matches.length">
                                    <CooperativeMatch 
                                        :matches="matches[3].mergeGames"
                                        :firstPlayer="matches[3].player1"
                                        :secondPlayer="matches[3].player2"
                                        :winFirst="matches[3].win1"
                                        :winSecond="matches[3].win2"
                                    ></CooperativeMatch>
                            </v-card>
                        </div>
                        <div class="d-flex mt-12 wrapper-cards" v-if="matches.length">
                           <CardMatches :count="countMatches" width="49%" :name="matches[0].name" :matches="matches[0].matches" class="wrapper-card mr-5" ></CardMatches>
                           <CardMatches :count="countMatches" :name="matches[1].name" :matches="matches[1].matches" class="wrapper-card" ></CardMatches>
                        </div>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
    import Header from './components/Header';
    import CardMatches from './components/CardMatches';
    import CooperativeMatch from './components/CooperativeMatch';
    import HistorySearch from './components/HistrorySearch';
    import API from './service/api';
    export default {
        name: "App",
        components:{
            Header,
            CardMatches,
            CooperativeMatch,
            HistorySearch
        },
        data: function() {
            return {
                drawer: true,
                isLoading1: false,
                isLoading2: false,
                player1: null,
                player2: null,
                entries1:[],
                entries2:[],
                searchSportsmen1: null,
                searchSportsmen2: null,
                matches: [],

                champs: [],
                count: '',
                lastUpdateDate: '',
                dialog: false,

                loadingMatches: false,
                loadingLastDate: false,
                countMatches:'',
                snackbar: false,
                
                historySearch: [],
            }
        },
        async created() {
            this.champs = await API.getAllChamps();
            const saveHistorySearch = JSON.parse(localStorage.getItem('historySearch'));
            if(saveHistorySearch) this.historySearch = saveHistorySearch;
        },
        methods: {
            search: async function() {
                const data = {
                    player1: this.player1.name,
                    player2: this.player2.name,
                    champName: this.tourney,
                    countMatches: this.count,
                };
                this.searchByData(data);
            },
            searchByData: async function (data) {
                this.loadingMatches = true;
                this.matches = await API.searchBySportsmen(data);

                const current = this.historySearch.filter(match => {
                    return (match.player1 == data.player1 && match.player2 == data.player2 && match.champName == data.champName);
                })

                if(current.length == 0) {
                    this.historySearch.push(data);
                    let saveHistorySearch = JSON.parse(localStorage.getItem('historySearch'));
                    if(!saveHistorySearch) saveHistorySearch = [];
                    saveHistorySearch.push(data);
                    localStorage.setItem('historySearch', JSON.stringify(saveHistorySearch));
                    
                }

                this.countMatches = this.count;
                this.snackbar = true;
                this.loadingMatches = false;
            },
            getLastUpdateDate: async function() {
                this.loadingLastDate = true;
                this.lastUpdateDate = await API.getLastUpdateDate();
                this.dialog = true;
                this.loadingLastDate = false;
            },
            changeHistorySearch: function() {
                this.historySearch = [];
            }
        },
        watch: {
            async searchSportsmen1 (val) {
                if (this.isLoading1) return
                this.isLoading1 = true
                this.entries1 = await API.searchSportsmen({
                    name: this.searchSportsmen1,
                })
                this.isLoading1 = false;
                
            },
            async searchSportsmen2 (val) {
                if (this.isLoading2) return
                this.isLoading2 = true
                this.entries2 = await API.searchSportsmen({
                    name: this.searchSportsmen2,
                })
                this.isLoading2 = false;
                
            },
        },
}
</script>

<style scoped >
    
    .wrapper-form {
        width: 30%;
    }
    .wrapper-coop {
        width: 70%;
    }
    .button {
        width: 100%;
        margin-top: 15px;
    }
    .wrapper-buttons {
        flex-direction: column;
    }
    .wrapper-form-coop,
    .wrapper-cards {
        justify-content: center;
    }
    .wrapper-cards .wrapper-card {
            width: 50%;
            margin-right: 0px;
            margin-top: 20px;
    }
    @media screen and (max-width: 1200px) {
        .wrapper-form {
            width: 50%;
        }
        .wrapper-coop {
            width: 50%;
        }
    }
    @media screen and (max-width: 768px) {
        .wrapper-form-coop,
        .wrapper-cards {
            flex-direction: column;;
        }
        .wrapper-form,
        .wrapper-coop,
        .wrapper-cards .wrapper-card {
            width: 100%;
            margin-right: 0px;
        }
        .wrapper-coop {
            margin-top: 48px;
        }
    }
    @media screen and (max-width: 600px) {
        .wrapper-buttons {
            flex-direction: column;
        }
        .wrapper-buttons .button {
            width: 100%;
            margin-top: 15px;
        }
        .wrapper-selects {
            flex-direction: column;
        }
        .wrapper-selects .select-player {
            width: 100%;
        }
    }
</style>

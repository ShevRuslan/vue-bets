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
                        <div width="100%" class="d-flex">
                            <v-card
                                width="30%"
                                class="pa-5 mr-5"
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
                                                <v-btn color="success" dense width="100%" @click="search">
                                                    Получить информацию
                                                </v-btn>
                                            </div>

                                            <div class="button">
                                                 <v-btn  color="primary" dense width="100%" @click="getLastUpdateDate" >
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

                                       </div>

                                    </v-form>
                                </div>
                            </v-card>
                            <v-card width="70%" v-if="matches.length">
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
                           <CardMatches :count="count" :name="matches[0].name" :matches="matches[0].matches" class="wrapper-card mr-5" ></CardMatches>
                           <CardMatches :name="matches[1].name" :matches="matches[1].matches" class="wrapper-card" ></CardMatches>
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
    import API from './service/api';
    export default {
        name: "App",
        components:{
            Header,
            CardMatches,
            CooperativeMatch
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

                searchTourney: null,
                tourney: null,
                tournes: [],
                isLoading3: false,

                champs: [],
                count: '',
                lastUpdateDate: '',
                dialog: false,
            }
        },
        async created() {
            this.champs = await API.getAllChamps();
        },
        methods: {
            changeHeader: function() {
                this.drawer = !this.drawer;
            },
            search: async function() {
                this.matches = await API.searchBySportsmen({
                    player1: this.player1.name,
                    player2: this.player2.name,
                    champName: this.tourney,
                    countMatches: this.count,
                })
            },
            getLastUpdateDate: async function() {
                this.lastUpdateDate = await API.getLastUpdateDate();
                this.dialog = true;
            }
        },
        watch: {
            async searchSportsmen1 (val) {
                if (this.isLoading1) return
                this.isLoading1 = true
                // Lazily load input items
                this.entries1 = await API.searchSportsmen({
                    name: this.searchSportsmen1,
                })
                this.isLoading1 = false;
                
            },
            async searchSportsmen2 (val) {
                if (this.isLoading2) return
                this.isLoading2 = true
                // Lazily load input items
                this.entries2 = await API.searchSportsmen({
                    name: this.searchSportsmen2,
                })
                this.isLoading2 = false;
                
            },
            async searchTourney (val) {
                if(this.isLoading3) return
                this.isLoading3 = true;

                this.tournes = await API.searchChamp({
                    champName: this.searchTourney
                })
                this.isLoading3 = false;
            },
        },
}
</script>

<style scoped >
    .button {
        width: 50%;
    }
    .wrapper-cards {
        flex-direction: row;
    }
    .wrapper-cards .wrapper-card {
            width: 50%;
            margin-right: 0px;
            margin-top: 20px;
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

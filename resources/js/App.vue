<template>
    <v-app id="inspire">
<!--        <v-navigation-drawer-->
<!--            v-model="drawer"-->
<!--            app-->
<!--        >-->
<!--            <v-list dense>-->
<!--                <v-list-item link>-->
<!--                    <v-list-item-action>-->
<!--                        <v-icon>mdi-home</v-icon>-->
<!--                    </v-list-item-action>-->
<!--                    <v-list-item-content>-->
<!--                        <v-list-item-title>Главная</v-list-item-title>-->
<!--                    </v-list-item-content>-->
<!--                </v-list-item>-->
<!--            </v-list>-->
<!--        </v-navigation-drawer>-->

        <Header @close="changeHeader"/>

        <v-content>
            <v-container
                class="fill-height pa-6"
                max-width="600px"
            >
                <v-row
                    justify="center"
                    aligng="center"
                >
                    <v-col class="text-center ">
                        <div width="100%">
                            <v-card
                                width="100%"
                                class="pa-10"
                            >
                                <div class="display-1 pb-12 ">
                                    Поиск по спортсменам
                                </div>
                                <div>
                                    <v-form
                                        ref="form"
                                    >
                                        <div class="d-flex flex-row">
                                            <v-autocomplete
                                                v-model="player1"
                                                :items="entries1"
                                                :loading="isLoading1"
                                                :search-input.sync="searchSportsmen1"
                                                item-text="name"
                                                return-object
                                                required
                                                outlined
                                                class="picker-player mr-5"
                                                width="50%" 
                                                >
                                           </v-autocomplete>
                                             <v-autocomplete
                                                v-model="player2"
                                                :items="entries2"
                                                :loading="isLoading2"
                                                :search-input.sync="searchSportsmen2"
                                                item-text="name"
                                                return-object
                                                required
                                                outlined
                                                >
                                           </v-autocomplete>
                                        </div>

                                        <v-autocomplete
                                            v-model="tourney"
                                            :items="tournes"
                                            :loading="isLoading3"
                                            :search-input.sync="searchTourney"
                                            item-text="name"
                                            return-object
                                            required
                                            outlined
                                            >
                                        </v-autocomplete>

                                       <div class="d-flex flex-row">
                                            <div class="button mr-5" >
                                                <v-btn color="success" dense width="100%" @click="search">
                                                    Получить информацию
                                                </v-btn>
                                            </div>

                                            <div class="button">
                                                <v-btn color="primary" dense width="100%" >
                                                    Обновить данные
                                                </v-btn>
                                            </div>
                                       </div>

                                    </v-form>
                                </div>
                            </v-card>
                        </div>
                        <div class="d-flex mt-12" v-if="matches.length">
                           <CardMatches :name="matches[0].name" :matches="matches[0].matches" class="wrapper-card mr-5" width="50%"></CardMatches>
                           <CardMatches :name="matches[1].name" :matches="matches[1].matches" class="wrapper-card" width="50%"></CardMatches>
                        </div>
                        <div class="d-flex mt-12" v-if="matches.length">
                            <div class="display-1 pb-12 ">
                                Совместные матчи
                            </div>
                            <CardMatches :matches="matches[3].mergeGames"></CardMatches>
                        </div>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
        <v-footer
            color="indigo"
            app
        >
            <span class="white--text">&copy; 2020</span>
        </v-footer>
    </v-app>
</template>

<script>
    import Header from './components/Header';
    import CardMatches from './components/CardMatches';
    import API from './service/api';
    export default {
        name: "App",
        components:{
            Header,
            CardMatches
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
            }
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
                })
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
            async searchTourney (vall) {
                if(this.isLoading3) return
                this.isLoading3 = true;

                this.tournes = await API.searchChamp({
                    champName: this.searchTourney
                })
                this.isLoading3 = false;
            }
        },
}
</script>

<style scoped>
    .wrapper-card {
        width: 50%;
    }
    .button {
        width: 50%;
    }
</style>

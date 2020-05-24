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
                                                class="picker-player"
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

                                        <v-select
                                            :items="items"
                                            label="Чемпионат"
                                            required
                                            outlined
                                        ></v-select>

                                       <div class="d-flex">
                                            <v-btn color="success" dense width="50%" @click="search" class="mr-5">
                                            Получить информацию
                                            </v-btn>

                                            <v-btn color="primary" dense width="50%" >
                                                Обновить данные
                                            </v-btn>
                                       </div>

                                    </v-form>
                                </div>
                            </v-card>
                        </div>
                        <div class="d-flex flex-row mt-12">
                            <!-- <v-card
                                class="mx-auto pa-6 mr-6"
                                width="100%"
                            >
                                <v-card-text>
                                    <p class="display-1 text--primary">
                                        Сергей Сарычев
                                    </p>
                                    <p>игрок настольного тенниса</p>
                                    <v-list>
                                        <v-subheader>Последние 10 матчей</v-subheader>
                                        <v-list-item-group v-model="item" color="primary">
                                            <v-list-item
                                                v-for="(item, i) in items"
                                                :key="i"
                                            >
                                                <v-list-item-content>
                                                    <v-list-item-title v-text="item"></v-list-item-title>
                                                </v-list-item-content>
                                            </v-list-item>
                                        </v-list-item-group>
                                    </v-list>
                                </v-card-text>
                            </v-card>
                            <v-card
                                class="mx-auto pa-6"
                                width="100%"
                            >
                                <v-card-text>
                                    <p class="display-1 text--primary">
                                        Сергей Сарычев
                                    </p>
                                    <p>игрок настольного тенниса</p>
                                    <v-list>
                                        <v-subheader>Последние 10 матчей</v-subheader>
                                        <v-list-item-group v-model="item" color="primary">
                                            <v-list-item
                                                v-for="(item, i) in items"
                                                :key="i"
                                            >
                                                <v-list-item-content>
                                                    <v-list-item-title v-text="item"></v-list-item-title>
                                                </v-list-item-content>
                                            </v-list-item>
                                        </v-list-item-group>
                                    </v-list>
                                </v-card-text>
                            </v-card> -->
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
    import API from './service/api';
    export default {
        name: "App",
        components:{
            Header,
        },
        data: function() {
            return {
                drawer: true,
                isLoading1: false,
                isLoading2: false,
                player1: null,
                player2: null,
                items:[
                    'Чемпионат 1',
                    'Чемпионат 2',
                    'Чемпионат 3',
                    'Чемпионат 4'
                ],
                entries1:[],
                entries2:[],
                searchSportsmen1: null,
                searchSportsmen2: null
            }
        },
        methods: {
            changeHeader: function() {
                this.drawer = !this.drawer;
            },
            search: async function() {
                const response = await API.searchBySportsmen({
                    player1: this.player1.name,
                    player2: this.player2.name,
                })
                console.log(response);
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
        },
}
</script>

<style scoped>
    .picker-player{
        padding-right: 30px;
    }
</style>

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
            <v-containeсr
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
                                            <v-text-field
                                                label="Первый игрок"
                                                required
                                                outlined
                                                class="picker-player"
                                            ></v-text-field>

                                            <v-text-field
                                                label="Второй игрок"
                                                required
                                                outlined
                                            ></v-text-field>
                                        </div>

                                        <v-select
                                            :items="items"
                                            label="Чемпионат"
                                            required
                                            outlined
                                        ></v-select>

                                        <v-btn color="success" dense width="100%">
                                            Поиск
                                        </v-btn>


                                    </v-form>
                                </div>
                            </v-card>
                        </div>
                        <div class="d-flex flex-row mt-12">
                            <v-card
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
                            </v-card>
                        </div>
                    </v-col>
                </v-row>
            </v-containeсr>
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
    export default {
        name: "App",
        components:{
            Header,
        },
        data: function() {
            return {
                drawer: true,
                items:[
                    'Чемпионат 1',
                    'Чемпионат 2',
                    'Чемпионат 3',
                    'Чемпионат 4'
                ]
            }
        },
        methods: {
            changeHeader: function() {
                this.drawer = !this.drawer;
            }
        }
    }
</script>

<style scoped>
    .picker-player{
        padding-right: 30px;
    }
</style>

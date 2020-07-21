<template>
    <div class="wrapper-header d-flex flex-column align-start">
        <v-app-bar app color="#313A46" dark class="app-header d-flex flex-row">
            <v-toolbar-title class="app-name">TABLE TENNIS</v-toolbar-title>
            <HeaderForm v-if="this.$route.path == '/'" @search="search"></HeaderForm>
            <v-menu offset-y content-class="elevation-1 pt-4 pb-0" z-index="0">
                <template v-slot:activator="{ on, attrs }">
                    <v-btn class="ml-2" @click="getLastUpdateDate" v-on="on" v-bind="attrs" text>
                        <v-icon>mdi-cog-outline</v-icon>
                    </v-btn>
                </template>
                <v-list class="pb-0">
                    <v-list-item>
                        <v-list-item-title> Актуальность: {{ updateDate }} </v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
        </v-app-bar>
        <div class="wrapper-header__navbar">
            <Navbar @search="search" />
        </div>
        <v-snackbar absolute v-model="snackbar" color="success" left bottom>
            Матчи успешно получены!
            <v-btn text @click="snackbar = false">
                <v-icon>mdi-close</v-icon>
            </v-btn>
        </v-snackbar>
    </div>
</template>

<script>
import API from '../service/api';
import { mapActions } from 'vuex';
import { mapMutations } from 'vuex';
import { mapGetters } from 'vuex';
import HeaderForm from './HeaderForm';
import Navbar from './Navbar';
export default {
    name: 'Header',
    components: {
        HeaderForm,
        Navbar
    },
    data: () => ({
        historyMatches: null,
        snackbar: false,
        updateDate: '',
    }),
    async created () {
        this.updateDate = await API.getLastUpdateDate();
    },
    computed: {
        ...mapGetters(['getHistory'])
    },
    methods: {
        ...mapActions(['setResponse']),
        ...mapMutations(['setHistory']),
        async getLastUpdateDate() {
            this.updateDate = await API.getLastUpdateDate();
        },
        search: async function(data) {
            this.searchByData(data);
        },
        searchByData: async function(data) {
            const matches = await API.searchBySportsmen(data);
            const rivalsMatches = await API.getRivalsMatch(data);
            matches[3] = rivalsMatches;
            this.setResponse(matches);
            let date = new Date();
            let month = date.getMonth() + 1;
            let nameMonth = this.getNameMonth(month);
            let day = date.getDate();
            let fullNameDate = `${day} ${nameMonth}`;

            this.historyMatches = this.getHistory;

            let matchName = `${this.getMatchName(data.player1)} : ${this.getMatchName(data.player2)}`;

            if (this.historyMatches == null) {
                let match = {
                    date: fullNameDate,
                    matches: [
                        {
                            ...data,
                            matchName
                        }
                    ]
                };
                localStorage.setItem('historySearch', JSON.stringify([match]));
                this.setHistory([match]);
            } else {
                const currentDate = this.historyMatches.findIndex((element, index, array) => {
                    return element.date == fullNameDate;
                });
                if (currentDate != -1) {
                    const currentMatch = this.historyMatches[currentDate].matches.filter(match => {
                        return (
                            match.player1 == data.player1 &&
                            match.player2 == data.player2 &&
                            match.champName == data.champName
                        );
                    });
                    if (currentMatch.length == 0) {
                        let historyMatch = {
                            ...data,
                            matchName
                        };
                        this.historyMatches[currentDate].matches.push(historyMatch);
                    }
                } else {
                    let newListDate = {
                        date: fullNameDate,
                        matches: [
                            {
                                ...data,
                                matchName
                            }
                        ]
                    };
                    this.historyMatches.unshift(newListDate);
                }
                this.setHistory(this.historyMatches);
                localStorage.setItem('historySearch', JSON.stringify(this.historyMatches));
                this.snackbar = true;
            }
        },
        getMatchName(player) {
            const arrayName = player.split(' ');
            return `${arrayName[1]} ${arrayName[0][0]}.`;
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
.wrapper-header__navbar {
    width: 100%;
    margin-top: 64px;
    background: #ffffff;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.075);
    align-items: baseline;
    display: flex;
    padding-left: 56px;
    padding-right: 56px;
}
.app-header {
    .v-label {
        color: #f1f3fa;
    }
    padding-left: 56px;
    padding-right: 56px;
    .v-toolbar__content {
        width: 100%;
    }
    .app-name {
        font-family: 'Gemunu Libre SemiBold';
        font-style: normal;
        font-weight: 300;
        font-size: 16px;
        line-height: 26px;
        text-transform: uppercase;
        display: block;
        white-space: normal;
    }
}
</style>
